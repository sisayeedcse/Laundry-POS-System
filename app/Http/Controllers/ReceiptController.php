<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

    /**
     * Bulk print receipts for a given set of order IDs (from Reports page)
     */
    public function bulkPrint(Request $request): Response
    {
        $ids = array_filter(
            array_map('intval', explode(',', $request->query('order_ids', '')))
        );

        $orders = Order::with(['customer', 'orderItems.service', 'payments'])
            ->whereIn('id', $ids)
            ->orderBy('created_at')
            ->get();

        $pdf = Pdf::loadView('receipts.bulk-receipts', compact('orders'))
            ->setPaper([0, 0, 226.77, 595.28], 'portrait'); // 80mm wide; DomPDF @page handles 210mm height per receipt

        return $pdf->stream('bulk-receipts-' . now()->format('Y-m-d') . '.pdf');
    }
}
