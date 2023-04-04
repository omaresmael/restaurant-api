<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealCollection;
use App\Models\Meal;


class MealController extends Controller
{
    public function index(): MealCollection
    {
        return new MealCollection(Meal::cursorPaginate(Meal::PAGINATION_COUNT));
    }
}
