<?php

namespace App\Models\Device;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Device\OperatingSystem
 *
 * @property int $id
 * @property string $os_name
 * @property string $os_language
 * @property string $browser_name
 * @property string $browser_version
 * @property string $platform_name
 * @property string $platform_version
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereBrowserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereBrowserVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereOsLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereOsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem wherePlatformName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem wherePlatformVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatingSystem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OperatingSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'os_name',
        'os_language',
        'browser_name',
        'browser_version',
        'platform_name',
        'platform_version',
    ];
}
