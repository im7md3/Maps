<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(ReviewRequest $request)
    {
        if($request->user()->reviews()->where('place_id',$request->place_id)->exists()){
            return redirect(rawurldecode(url()->previous()))->with(['isStored'=>'false']);
        }else{
            $review=Review::create($request->all() + ['user_id'=>auth()->id()]);
            return redirect(rawurldecode(url()->previous()));
        }
        
        
    }


    public function show(Review $review)
    {
        //
    }

    
    public function edit(Review $review)
    {
        //
    }

    
    public function update(Request $request, Review $review)
    {
        //
    }

    
    public function destroy(Review $review)
    {
        //
    }
}
