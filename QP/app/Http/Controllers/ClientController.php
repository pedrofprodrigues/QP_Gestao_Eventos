<?php

namespace App\Http\Controllers;

use App\Models\Appetizer;
use App\Models\Meat;
use App\Models\Fish;
use App\Models\Soup;
use App\Models\Dessert;

class ClientController extends Controller
{
    public function show()
    {
        $appetizers = Appetizer::all();
        $soups = Soup::all();
        $meats = Meat::all();
        $fishs = Fish::all();
        $desserts = Dessert::all();



        return view('client.presentation',compact('appetizers', 'soups', 'meats','fishs','desserts'));
    }

}
