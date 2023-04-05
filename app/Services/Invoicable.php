<?php

namespace App\Services;

use App\Models\Invoice as InvoiceModel;
use App\Models\Order;

interface Invoicable
{
    public function createInvoice(Order $order): InvoiceModel;
}
