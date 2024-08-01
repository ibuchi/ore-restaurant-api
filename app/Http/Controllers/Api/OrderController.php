<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::api([
            'message' => 'All orders!',
            'data' => Order::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        return Response::api([
            'message' => 'Order placed!',
            'data' => $request->fulfil(),
        ]);
    }

    /**
     * Show resource in storage.
     */
    public function show(Order $order)
    {
        return Response::api([
            'message' => 'Order details!',
            'data' => $order,
        ]);
    }


    public function update(Request $request, Order $order)
    {
        $order->update($request->validate([
            'status' => Rule::in(OrderStatus::values())
        ]));

        return Response::api([
            'message' => 'Order status updated!',
            'data' => $order,
        ]);
    }
}
