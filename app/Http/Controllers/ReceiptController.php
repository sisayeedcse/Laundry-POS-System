<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    /**
     * View receipt in browser
     */
    public function show(Order $order): View
    {
        $order->load(['customer', 'orderItems.service', 'payments']);
        
        return view('receipts.order-receipt', compact('order'));
    }

    /**
     * Download receipt as PDF
     */
    public function download(Order $order): Response
    {
        $order->load(['customer', 'orderItems.service', 'payments']);
        
        $pdf = Pdf::loadView('receipts.order-receipt', compact('order'));
        
        return $pdf->download('receipt-' . $order->order_number . '.pdf');
    }

    /**
     * Print receipt (opens in new window for printing)
     */
    public function print(Order $order): Response
    {
        $order->load(['customer', 'orderItems.service', 'payments']);
        
        $pdf = Pdf::loadView('receipts.order-receipt', compact('order'));
        
        return $pdf->stream('receipt-' . $order->order_number . '.pdf');
    }
}
