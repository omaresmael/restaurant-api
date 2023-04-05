<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Invoice as InvoiceModel;
use LaravelDaily\Invoices\Invoice;

interface Invoicable
{
    public function createInvoice(Order $order): InvoiceModel;
}
