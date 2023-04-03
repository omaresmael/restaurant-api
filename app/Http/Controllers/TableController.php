<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableAvailabilityRequest;
use App\Models\Table;
use Illuminate\Http\JsonResponse;


class TableController extends Controller
{
    public function checkAvailability(TableAvailabilityRequest $request, Table $table): JsonResponse
    {
        if($table->isReserved($request->input('from_time'), $request->input('to_time'))) {
            return response()->json([
                'message' => 'Table is not available',
                'data' => null
            ]);
        }
        return response()->json([
            'message' => 'Table is available',
            'data' => null
        ]);

    }
}
