<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItems;

class Order extends Model
{
	use HasFactory;

	protected $guarded = [
		'id'
	];

	public function orderItems()
	{
		return $this->hasMany(OrderItems::class);
	}

	public function getTotalAttribute()
	{
		return $this->orderItems->sum(function (OrderItems $item) {
			return $this->price * $item->quantity;
		});
	}
	
}
