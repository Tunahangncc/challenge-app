<?php

namespace App\Models;

use App\Models\Device\Device;
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
 * @mixin \Eloquent
 */
class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt',
        'device_id',
        'cancelled',
        'expire_date'
    ];

    protected $casts = [
        'expire_date' => 'datetime'
    ];

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
