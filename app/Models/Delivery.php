<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delivery
 * 
 * @property int $id
 * @property int $order_id
 * @property int $seller_id
 * @property int|null $delivery_man_id
 * @property Carbon $delivery_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property DeliveryMan|null $delivery_man
 * @property Order $order
 * @property Seller $seller
 *
 * @package App\Models
 */
class Delivery extends Model
{
	protected $table = 'deliveries';

	protected $casts = [
		'order_id' => 'int',
		'seller_id' => 'int',
		'delivery_man_id' => 'int',
		'delivery_date' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'seller_id',
		'delivery_man_id',
		'delivery_date'
	];

	public function delivery_man()
	{
		return $this->belongsTo(DeliveryMan::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function seller()
	{
		return $this->belongsTo(Seller::class);
	}
}
