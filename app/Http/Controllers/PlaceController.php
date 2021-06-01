<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use App\Traits\RateableTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlaceController extends Controller
{
    use RateableTrait;
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
        $this->middleware('role', ['only' => ['create', 'store']]);
    }
    
    public function index()
    {
        return $places=Place::orderBy('view_count','desc')->take(3)->get();
        return Inertia::render('Welcome',compact('places'));
    }

    
    public function create()
    {
        return Inertia::render('Places/create');
    }

   
    public function store(PlaceRequest $request)
    {
        $file_path='img/default.png';
        if($request->has('image')){
            $file_path=imgUpload($request->image);
        }
        $place=$request->user()->places()->create($request->except('image') + ['image'=>$file_path]);
        if(!$place){
            return redirect(rawurldecode(url()->previous()));
        }else{
            return redirect()->route('places.show',$place);
        }
        return redirect('/');
    }

    
    public function show(Place $place)
    {
        
        $reviews=Review::with('user')->withCount('likes')->where('place_id',$place->id)->paginate(5);

        $avg=$this->averageRating($place);
        $total = $avg['total'];
        $service_rating = $avg['service_rating'];
        $quality_rating = $avg['quality_rating'];
        $cleanliness_rating = $avg['cleanliness_rating'];
        $pricing_rating = $avg['pricing_rating'];
        $place=$place::with(['user'])->where('id',$place->id)->withCount('reviews')->get();

        $myuser=null;
        if(auth()->user()){
            $myuser=User::with(['likes','bookmarks'])->where('id',auth()->id())->get();
        }
        return Inertia::render('Places/show', compact('place', 'total', 'service_rating', 'quality_rating', 'cleanliness_rating', 'pricing_rating','reviews','myuser'));
    }

    public function edit(Place $place)
    {
        //
    }

    public function update(Request $request, Place $place)
    {
        //
    }

   
    public function destroy(Place $place)
    {
        //
    }
}
