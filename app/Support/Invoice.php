<?php

namespace App\Support;

use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PdfInstance;

class Invoice
{
    public static function forOrder(Order $order): PdfInstance
    {
        $order->loadMissing('items');

        $configuredGst = Setting::get('gst_percentage');
        $gstPercentage = ($configuredGst !== null && $configuredGst !== '') ? (float) $configuredGst : null;

        $taxableValue = null;
        $gstAmount = null;

        if ($gstPercentage !== null && $gstPercentage > 0) {
            $grandTotal = (float) $order->grand_total;
            $taxableValue = $grandTotal / (1 + ($gstPercentage / 100));
            $gstAmount = $grandTotal - $taxableValue;
        }

        return Pdf::loadView('invoices.order', [
            'order' => $order,
            'siteSettings' => Setting::allSettings(),
            'gstPercentage' => $gstPercentage,
            'taxableValue' => $taxableValue,
            'gstAmount' => $gstAmount,
        ]);
    }

    public static function filename(Order $order): string
    {
        return "invoice-{$order->order_number}.pdf";
    }
}
