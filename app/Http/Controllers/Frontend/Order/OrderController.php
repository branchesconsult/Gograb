<?php

namespace App\Http\Controllers\Frontend\Order;

use App\Http\Requests\Frontend\Orders\MakeOrderRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function store(MakeOrderRequest $request)
    {
        $orderApiController = new \App\Http\Controllers\Api\V1\OrderController();
        $customerLocationInfo = explode(',', session()->get('customer.customer_location'));
        $request->merge($this->formatProductsForCart());
        $request->merge(['customer_lat' => $customerLocationInfo[0]]);
        $request->merge(['customer_lng' => $customerLocationInfo[1]]);
        $placeOrderRes = $orderApiController->store(new \App\Http\Requests\Api\Orders\MakeOrderRequest($request->all()));
        dd($request->all(), $customerLocationInfo, $placeOrderRes->toJson());

    }

    public function formatProductsForCart()
    {
        $result['products'] = [];
        $products = \Cart::content()->toArray();
        $loopCounter = 0;
        foreach ($products as $key => $val) {
            $result['products'][$loopCounter]['id'] = $val['id'];
            $result['products'][$loopCounter]['qty'] = $val['qty'];
            $result['products'][$loopCounter]['special_instructions'] = $val['options']['special_instructions'] ?? null;
            $loopCounter++;
        }
        return $result;
    }
}
