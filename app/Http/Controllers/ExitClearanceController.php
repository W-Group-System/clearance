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
        
        $exitClearanceIds = ExitClearanceSignatory::where('exit_clearance_id', $for_clearances->exit_clearance_id)->pluck('employee_id')->toArray();
        $resign = ExitResign::with('exit_clearance.department','exit_clearance.checklists','exit_clearance.signatories')->findOrfail($for_clearances->clearance->resign_id);
        return view('view_as_signatory',array(
            'for_clearances'=>$for_clearances,
            'resignEmployee'=>$resign,
            'exitClearanceIds'=>$exitClearanceIds,
        ));

    }
    public function viewComments(Request $request,$id)
    {   
        $employeeId = auth()->user()->employee->id;
        $exitClearanceIds = ExitClearanceSignatory::where('exit_clearance_id', $id)->pluck('employee_id')->toArray();
        $exit = ExitClearance::findOrFail($id);

        // Check if the current user is authorized to view the page
        if ($exit->employee_id == $employeeId || in_array($employeeId, $exitClearanceIds) || auth()->user()->clearance_admin == 1) {
            // Retrieve the necessary data once
            $for_clearances = ExitClearanceSignatory::with('clearance.department')
                ->where('exit_clearance_id', $exit->id)
                ->first();

            $resign = ExitResign::with('exit_clearance.department', 'exit_clearance.checklists', 'exit_clearance.signatories')
                ->findOrFail($for_clearances->clearance->resign_id);

            return view('view_as_signatory', [
                'for_clearances' => $for_clearances,
                'exitClearanceIds' => $exitClearanceIds,
                'resignEmployee' => $resign,
            ]);
        }

        // If user is not authorized
        Alert::error('You are not allowed to view this page.')->persistent('Dismiss');
        return redirect('home');

    }
    public function viewMyClearance()
    {   
        $employeeId = auth()->user()->employee->id;
        // dd($employeeId); 
        $resignExit = ExitResign::with('exit_clearance.department','exit_clearance.checklists','exit_clearance.signatories')->where('employee_id',auth()->user()->employee->id)->where('status','!=','Retracted')->first();
        
        if($resignExit)
        {
            return view('view_clearance',array(
                'resignEmployee'=>$resignExit
            ));
        }
        else
        {
            Alert::error('Your clearance is not yet processed, please coordinate with HR.')->persistent('Dismiss');
            return redirect('home');
        }
       

        // If user is not authorized
        // Alert::error('You are not allowed to view this page.')->persistent('Dismiss');
        // return redirect('home');

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
        $remarks = "<span>Checklist: ".$request->checklist." <br>".$request->old_status." &#x2192; ".$request->status."</span> <br> Remarks : ".$request->remarks."<br> ";
        if($request->file('proof')){
            $proof = $request->file('proof');
            $original_name = $proof->getClientOriginalName();
            $name = time() . '_' . $proof->getClientOriginalName();
            $proof->move(public_path() . '/proof/', $name);
            $file_name = '/proof/' . $name;
            $remarks = $remarks."<a class='btn btn-sm btn-success' href='".url($file_name)."'  target='blank'>".$original_name."</a> ";
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
        $signatories = ExitClearanceSignatory::where('exit_clearance_id',$exit_signatory->exit_clearance_id)->where('id','!=',$id)->where('status','Pending')->count();
        if($signatories == 0)
        {
            $exitChecklist = ExitClearanceChecklist::where('status','Pending')->where('exit_clearance_id',$exit_signatory->exit_clearance_id)->count();
            if($exitChecklist > 0 )
            {
                Alert::error('Kindly complete the entire checklist, or mark items as "N/A" if they are not applicable.')->persistent('Dismiss');
                return back();
            }
        }
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
