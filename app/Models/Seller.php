<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Seller
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string|null $shop_name
 * @property string|null $shop_address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Delivery[] $deliveries
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Seller extends Model
{
	protected $table = 'sellers';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'shop_name',
		'shop_address'
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
