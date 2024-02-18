<?php

namespace App\Models\Device;

use App\Enums\TransactionTypes;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Device\Device
 *
 * @property int $id
 * @property string $uid
 * @property string $app_uid
 * @property string $client_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Device\OperatingSystem> $operatingSystems
 * @property-read int|null $operating_systems_count
 * @property-read Purchase|null $subscription
 *
 * @method static \Database\Factories\Device\DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereAppUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereClientToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'app_uid',
        'client_token',
    ];

    // region Relations
    public function operatingSystems(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            OperatingSystem::class,
            'device_operating_systems',
            'device_id',
            'operating_system_id'
        );
    }

    public function subscription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Purchase::class, 'device_id', 'id');
    }

    // endregion

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (self $device) {
            Transaction::query()->create([
                'model_id' => $device->id,
                'model_class' => self::class,
                'link' => request()->url(),
                'description' => 'Device registration created for the new application',
                'transaction_type' => TransactionTypes::CREATE,
            ]);
        });
    }
}
