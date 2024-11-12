<?php

namespace App\Http\Controllers;
use App\ExitResign;
use Illuminate\Http\Request;

class ExitClearanceController extends Controller
{
    //

    public function index(Request $request)
    {
        $resigns = ExitResign::with('exit_clearance.signatories')->where('status','Ongoing Clearance')->get();
        // dd($resigns);
        return view('ongoing_clearances',array(
            'resigns'=>$resigns
        ));
    }
}
