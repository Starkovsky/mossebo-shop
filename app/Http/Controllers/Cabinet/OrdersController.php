<?php

namespace App\Http\Controllers\Cabinet;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use PayTypes;
use DeliveryTypes;
use OrderStatuses;

class OrdersController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()->with(['orderProducts' => function($query) {
            $query->with('options');
        }])
            ->orderBy('updated_at', 'desc')
            ->get();

        $orderStatuses = OrderStatuses::getCollection('currentI18n');
        $payTypes      = PayTypes::getCollection('currentI18n');
        $deliveryTypes = DeliveryTypes::getCollection('currentI18n');

        $orders = $orders->each(function(& $order) use($orderStatuses, $payTypes, $deliveryTypes) {
            $order->status       = $orderStatuses->where('id', $order->order_status_id)->first();

            $order->payType      = $payTypes->where('id', $order->pay_type_id)->first();

            $order->deliveryType = $deliveryTypes->where('id', $order->delivery_type_id)->first();
        });

        return response()->json([
            'orders' => OrderResource::collection($orders)
        ], 200);
    }
}
