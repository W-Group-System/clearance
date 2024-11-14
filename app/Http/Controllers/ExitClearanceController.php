<?php

namespace App\Http\Controllers;
use App\ExitResign;
use App\ExitClearanceSignatory;
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

    public function view(Request $request,$id)
    {
        $resign = ExitResign::with('exit_clearance.department','exit_clearance.checklists','exit_clearance.signatories')->findOrfail($id);
        // dd($resigns);
        return view('view_clearance',array(
            'resignEmployee'=>$resign
        ));
    }
    public function forClearance(Request $request)
    {
        $status = $request->status;
        if(empty($status))
        {
            $status = "Pending";
        }
        $for_clearances = ExitClearanceSignatory::with('clearance')->where('employee_id',auth()->user()->employee->id)->get();
        // dd($for_clearances);
        return view('for_clearances',array(
            'for_clearances'=>$for_clearances,
            'status'=>$status
        ));
    }
}
