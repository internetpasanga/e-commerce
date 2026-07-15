<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Support\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()
            ->with(['items.product:id,slug,thumbnail,status'])
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('site.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $order->load('items', 'statusHistories');

        return view('site.orders.show', compact('order'));
    }

    public function invoice(Request $request, Order $order): Response
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->status !== 'delivered', 403, 'Invoices are available once your order has been delivered.');

        return Invoice::forOrder($order)->download(Invoice::filename($order));
    }
}
