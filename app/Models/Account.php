<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $checked
 * @property string $description
 * @property string $interest
 * @property string $date_of_birth
 * @property string $email
 * @property string $account
 * @property array $credit_card
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 * @method static Builder|Account whereAccount($value)
 * @method static Builder|Account whereAddress($value)
 * @method static Builder|Account whereChecked($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereCreditCard($value)
 * @method static Builder|Account whereDateOfBirth($value)
 * @method static Builder|Account whereDescription($value)
 * @method static Builder|Account whereEmail($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereInterest($value)
 * @method static Builder|Account whereName($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'interest',
        'date_of_birth',
        'email',
        'account',
        'credit_card'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'credit_card' => 'array',
    ];

}
