<?php

namespace App\Models\Device;

use App\Enums\TransactionTypes;
use App\Models\Transaction;
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
 * @method static \Database\Factories\Device\OperatingSystemFactory factory($count = null, $state = [])
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

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (self $system) {
            Transaction::query()->create([
                'model_id' => $system->id,
                'model_class' => self::class,
                'link' => request()->url(),
                'description' => "The device's operating system information has been recorded",
                'transaction_type' => TransactionTypes::CREATE,
            ]);
        });
    }
}
