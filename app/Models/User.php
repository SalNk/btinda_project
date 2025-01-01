<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $role
 * @property bool $is_active
 * @property string|null $address
 * @property string|null $telephone
 * @property string|null $avatar
 * 
 * @property Collection|DeliveryMan[] $delivery_men
 * @property Collection|Seller[] $sellers
 *
 * @package App\Models
 */
class User extends Authenticatable implements HasMedia
{
	use HasFactory;
	use InteractsWithMedia;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'is_active' => 'bool'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'role',
		'is_active',
		'address',
		'telephone',
		'avatar'
	];

	public function delivery_men()
	{
		return $this->hasMany(DeliveryMan::class);
	}

	public function sellers()
	{
		return $this->hasMany(Seller::class);
	}
}
