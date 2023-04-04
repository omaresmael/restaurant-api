<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableAvailabilityRequest;
use App\Http\Requests\TableReserveRequest;
use App\Models\Customer;
use App\Models\Table;
use App\Models\WaitingList;
use Illuminate\Http\JsonResponse;


class TableController extends Controller
{
    public function checkAvailability(TableAvailabilityRequest $request, Table $table): JsonResponse
    {
        if($table->isReserved($request->input('from_time'), $request->input('to_time'))) {
            return jsonResponse('Table is not available at this time',['table_available' => false],400);
        }
        return jsonResponse('Table is available',['table_available' => true]);

    }

    public function reserve(TableReserveRequest $request, Customer $customer): JsonResponse
    {
        $from = $request->input('from_time');
        $to = $request->input('to_time');
        $guests = $request->input('guests');

        if ($table = Table::available($from, $to, $guests)->first()) {
            return $this->reserveTable($table, $customer, $request);
        }

        return $this->addCustomerToWaitingList($from,$to,$guests,$customer);
    }

    private function reserveTable($table, Customer $customer, TableReserveRequest $request): JsonResponse
    {
        $table->customers()->attach($customer, [
            'from_time' => $request->input('from_time'),
            'to_time' => $request->input('to_time'),
        ]);
        return jsonResponse('Table is reserved successfully');

    }

    private function addCustomerToWaitingList(string $from,string $to,int $guests,Customer $customer): JsonResponse
    {
        WaitingList::create([
            'guests' => $guests,
            'from_time' => $from,
            'to_time' => $to,
            'customer_id' => $customer->id,
        ]);
        return jsonResponse('No table is available at this time, customer has been added to the waiting list');

    }
}
