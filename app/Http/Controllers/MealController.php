<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealCollection;
use App\Models\Meal;


class MealController extends Controller
{
    public function index(): MealCollection
    {
        $meals = Meal::query()
            ->select('id', 'name', 'description', 'available_quantity', 'price', 'discount')
            ->cursorPaginate(Meal::PAGINATION_COUNT);

        return new MealCollection($meals);
    }
}
