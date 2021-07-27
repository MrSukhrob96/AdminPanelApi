<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
	{
		$orders = Order::paginate();
		
		return response(OrderResource::collection($orders), 200);
	}
	
	public function show($id)
	{
		return response(new OrderResource(Order::find($id)), 200);
	}
	
}
