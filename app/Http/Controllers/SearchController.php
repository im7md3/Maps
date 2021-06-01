<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->address) {
            $input = $request->address;
            return $data = Place::where('name', 'LIKE', "%$input%")->get();
        }
    }

    public function view(Request $request){
        $places = Place::search($request)->get();
        return Inertia::render('Categories/show',compact('places'));
    }

    
}
