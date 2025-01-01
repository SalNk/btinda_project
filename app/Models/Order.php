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

/**
 * Class Order
 * 
 * @property int $id
 * @property string $name
 * @property string $delivery_address
 * @property float $delivery_price
 * @property Carbon $delivery_time
 * @property Carbon $delivery_date
 * @property float $item_price
 * @property string $notes
 * @property string|null $description
 * @property string $status
 * @property int $seller_id
 * @property int|null $delivery_man_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property DeliveryMan|null $delivery_man
 * @property Seller $seller
 * @property Collection|Delivery[] $deliveries
 *
 * @package App\Models
 */
class Order extends Model implements HasMedia
{
	use HasFactory;
	use InteractsWithMedia;

	protected $table = 'orders';

	protected $casts = [
		'delivery_price' => 'float',
		'delivery_time' => 'datetime',
		'delivery_date' => 'datetime',
		'item_price' => 'float',
		'seller_id' => 'int',
		'delivery_man_id' => 'int'
	];

	protected $fillable = [
		'name',
		'delivery_address',
		'delivery_price',
		'delivery_time',
		'delivery_date',
		'item_price',
		'notes',
		'description',
		'status',
		'seller_id',
		'delivery_man_id'
	];

	public function delivery_man()
	{
		return $this->belongsTo(DeliveryMan::class);
	}

	public function seller()
	{
		return $this->belongsTo(Seller::class);
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}
}
