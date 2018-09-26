<?php

namespace App\Http\Controllers\Cabinet;

use Auth;
use PayTypes;
use DeliveryTypes;
use OrderStatuses;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrdersController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()->with(['orderProducts' => function($query) {
            $query->with('options');
        }])
            ->with(['promoUse' => function($query) {
                $query->with('code');
            }])
            ->orderBy('updated_at', 'desc')
            ->get();

        $payTypes      = PayTypes::getCollection();
        $orderStatuses = OrderStatuses::getCollection();
        $deliveryTypes = DeliveryTypes::getCollection();

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
