<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableAvailabilityRequest;
use App\Http\Requests\TableReserveRequest;
use App\Models\Customer;
use App\Models\Table;
use Illuminate\Http\JsonResponse;


class TableController extends Controller
{
    public function checkAvailability(TableAvailabilityRequest $request, Table $table): JsonResponse
    {
        if($table->isReserved($request->input('from_time'), $request->input('to_time'))) {
            return response()->json([
                'message' => 'Table is not available at this time',
                'data' => null
            ]);
        }
        return response()->json([
            'message' => 'Table is available',
            'data' => null
        ]);
    }

    public function reserve(TableReserveRequest $request, Table $table, Customer $customer): JsonResponse
    {

        if($table->isReserved($request->input('from_time'), $request->input('to_time'))) {
            return response()->json([
                'message' => 'Table is not available at this time',
                'data' => null
            ]);
        }
        $table->customers()->attach($customer, [
            'from_time' => $request->input('from_time'),
            'to_time' => $request->input('to_time'),
        ]);

        return response()->json([
            'message' => 'Table is reserved successfully',
            'data' => null
        ]);
    }
}
