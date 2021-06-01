<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request){
        if(auth()->id()==$request->user_id){
            return redirect(url()->previous())->with(['youCant'=>'لا يمكنك الإعجاب بهذه المراجعة']);
        }else{
            if(auth()->user()->alreadyLike($request->review_id)){
                $request->user()->likes()->detach($request->review_id);
            }else{
                $request->user()->likes()->attach($request->review_id);
            }
            
    
            
            return redirect(url()->previous());
        }
        
    }
}
