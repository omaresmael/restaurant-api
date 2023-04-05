<?php

namespace App\Services;
use App\Models\Customer;
use App\Models\Invoice as InvoiceModel;
use App\Models\Order;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class InvoiceService implements invoicable
{
    private Customer $customer;
    private Order $order;
    private function getInvoiceCustomer(): Buyer
    {
        return new Buyer([
            'name' => $this->customer->name,
            'custom_fields' => [
                'phone number' => $this->customer->phone,
            ],
        ]);
    }

    private function getInvoiceItems(): array
    {

        $items = [];
        foreach ($this->order->meals as $meal) {
            $items[] = (new InvoiceItem())
                ->title($meal->name)
                ->pricePerUnit($meal->price)
                ->quantity(1)
                ->discountByPercent($meal->discount);
        }
        return $items;
    }

    public function createInvoice(Order $order): InvoiceModel
    {
        $this->order = $order;
        $this->customer = $order->customer;

        $invoice = Invoice::make()
            ->buyer($this->getInvoiceCustomer())
            ->addItems($this->getInvoiceItems())
            ->filename($this->getInvoiceName())
            ->save('public');


        $invoiceModel = InvoiceModel::create([
            'order_id' => $this->order->id,
            'path' => $invoice->url(),
        ]);

        return $invoiceModel;
    }
    private function getInvoiceName(): string
    {
        return 'invoice_' . $this->order->id . '_' . now()->format('Y-m-d_H-i-s');
    }

}
