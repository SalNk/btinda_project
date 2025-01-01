<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryMan
 * 
 * @property int $id
 * @property int|null $user_id
 * @property bool $is_available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Delivery[] $deliveries
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class DeliveryMan extends Model
{
	protected $table = 'delivery_men';

	protected $casts = [
		'user_id' => 'int',
		'is_available' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'is_available'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
