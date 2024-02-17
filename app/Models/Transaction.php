<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $model_id
 * @property string $model_class
 * @property string $description
 * @property string|null $link
 * @property string $transaction_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_class',
        'description',
        'link',
        'transaction_type',
    ];
}
