<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Mail\SendReport;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function create()
    {
        return Inertia::render('Reports/report');
    }

    public function store(ReportRequest $request)
    {
        try{
            $report=Report::create($request->all());
            if(!$report){
                return redirect(rawurldecode(url()->previous()));
            }else{
                \Mail::send(new SendReport($request->all()));
                return redirect(rawurldecode(url()->previous()));
            }
        }catch(\Exception $e){
            return $e;
        }
        
        
    }
}
