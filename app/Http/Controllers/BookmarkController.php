<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BookmarkController extends Controller
{

    public function index(){
        $bookmarks=auth()->user()->bookmarks;
        return Inertia::render('Bookmarks/bookmarks',compact('bookmarks'));
    }

    public function toggleMark(Request $request){
        if($request->user()->isMarked($request->place)){
            $request->user()->bookmarks()->detach($request->place);
        }else{
            $request->user()->bookmarks()->attach($request->place);
        }
        $bookmarks=auth()->user()->bookmarks;
        return response()->json(['data'=>$bookmarks]);
    }
}
