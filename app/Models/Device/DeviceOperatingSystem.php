<?php

namespace App\Models\Device;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Device\DeviceOperatingSystem
 *
 * @property int $device_id
 * @property int $operating_system_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceOperatingSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceOperatingSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceOperatingSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceOperatingSystem whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceOperatingSystem whereOperatingSystemId($value)
 *
 * @mixin \Eloquent
 */
class DeviceOperatingSystem extends Model
{
    protected $fillable = [
        'device_id',
        'operating_system_id',
    ];
}
