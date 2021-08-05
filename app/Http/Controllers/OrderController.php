<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Response;

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

	public function export()
	{
		$headers = array(
			"Content-Type" => "text\csv",
			"Content-Disposition" => "attachment; filename=orders.csv",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Exoires" => "0"
		);

		$collback = function () {
			$orders = Order::all();
			$file = fopen("php://output", 'w');

			fputcsv($file, array(
				"ID",
				"Name",
				"Email",
				"Product title",
				"Price",
				"Quantity"
			));

			foreach ($orders as $order) {
				fputcsv($file, array(
					$order->id,
					$order->name,
					$order->email,
					"",
					"",
					""
				));

				foreach ($order->orderItems as $orderItem) {
					fputcsv($file, array(
						"",
						"",
						"",
						$orderItem->product_title,
						$orderItem->price,
						$orderItem->quantity,
					));
				}
			}

			fclose($file);
		};

		return Response::stream($collback, 200, $headers);
	}
}
