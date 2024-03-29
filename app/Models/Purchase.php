<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use App\Models\Device\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Purchase
 *
 * @property int $id
 * @property string $receipt
 * @property int $device_id
 * @property int $cancelled
 * @property \Illuminate\Support\Carbon $expire_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Device $device
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static Builder|Purchase expiredSubscriptions()
 * @method static \Database\Factories\PurchaseFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt',
        'device_id',
        'cancelled',
        'expire_date',
    ];

    protected $casts = [
        'expire_date' => 'date',
    ];

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    // region Scopes
    public function scopeExpiredSubscriptions(Builder $query): Builder
    {
        return $query
            ->where('cancelled', 0)
            ->where('expire_date', '<', now()->format('Y-m-d'));
    }

    // endregion

    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (self $purchase) {
            if ($purchase->isDirty('expire_date')) {
                Transaction::query()->create([
                    'model_id' => $purchase->id,
                    'model_class' => self::class,
                    'link' => request()->url(),
                    'description' => 'Expiration date updated. New date: '.$purchase->expire_date,
                    'transaction_type' => TransactionTypes::UPDATE,
                ]);
            }

            if ($purchase->isDirty('cancelled')) {
                Transaction::query()->create([
                    'model_id' => $purchase->id,
                    'model_class' => self::class,
                    'link' => request()->url(),
                    'description' => 'Subscription canceled because it has expired',
                    'transaction_type' => TransactionTypes::CANCELLED,
                ]);
            }
        });

        static::created(function (self $purchase) {
            Transaction::query()->create([
                'model_id' => $purchase->id,
                'model_class' => self::class,
                'link' => request()->url(),
                'description' => 'A purchase was made for the device with '.$purchase->device_id.' ID.',
                'transaction_type' => TransactionTypes::CREATE,
            ]);
        });
    }
}
