<?php

namespace App\Http\Controllers;
use App\ExitResign;
use App\ExitClearance;
use App\ExitClearanceComment;
use App\ExitClearanceChecklist;
use App\ExitClearanceSignatory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
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
        $for_clearances = ExitClearanceSignatory::with('clearance.department')->where('employee_id',auth()->user()->employee->id)->get();
        // dd($for_clearances);
        return view('for_clearances',array(
            'for_clearances'=>$for_clearances,
            'status'=>$status
        ));
    }

    public function viewAsSignatory (Request $request,$id)
    {   

        $for_clearances = ExitClearanceSignatory::with('clearance.department')->where('employee_id',auth()->user()->employee->id)->where('id',$id)->first();   
        $resign = ExitResign::with('exit_clearance.department','exit_clearance.checklists','exit_clearance.signatories')->findOrfail($for_clearances->clearance->resign_id);
        return view('view_as_signatory',array(
            'for_clearances'=>$for_clearances,
            'resignEmployee'=>$resign,
        ));

    }
    public function submitComment(Request $request,$id)
    {
        $comment = new ExitClearanceComment;
        $comment->remarks = $request->observation;
        $comment->exit_clearance_id = $id;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        Alert::success('Successfully Stored')->persistent('Dismiss');

        return back();
    }

    public function changestatus(Request $request,$id)
    {
        $checklist = ExitClearanceChecklist::findOrfail($id);
        $checklist->status = $request->status;
        $checklist->save();

        $comment = new ExitClearanceComment;
        $remarks = "<span>Checklist: ".$request->checklist." <br>".$request->old_status." -> ".$request->status."</span> <br> Remarks : ".$request->remarks."<br> ";
        if($request->file('proof')){
            $proof = $request->file('proof');
            $original_name = $proof->getClientOriginalName();
            $name = time() . '_' . $proof->getClientOriginalName();
            $proof->move(public_path() . '/proof/', $name);
            $file_name = '/proof/' . $name;
            $remarks = $remarks."<a class='btn btn-sm btn-danger' href='".url($file_name)."'  target='blank'>Proof</a> ";
        }
        $comment->remarks = $remarks;
        $comment->exit_clearance_id = $checklist->exit_clearance_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        Alert::success('Successfully Change Status')->persistent('Dismiss');

        return back();

    }
    public function cleared(Request $request,$id)
    {
        $exit_signatory = ExitClearanceSignatory::findOrfail($id);
        $exit_signatory->status = "Cleared";
        $exit_signatory->save();

        $comment = new ExitClearanceComment;
        $remarks = "<span>Tag ".$request->name." as Cleared <br> Remarks : ".$request->remarks."<br> ";
        $comment->remarks = $remarks;
        $comment->exit_clearance_id = $exit_signatory->exit_clearance_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        Alert::success('Successfully Change Status')->persistent('Dismiss');

        return back();

    }
}
