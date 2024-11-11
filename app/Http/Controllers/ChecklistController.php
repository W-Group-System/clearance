<?php

namespace App\Http\Controllers;
use App\ExitChecklist;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;
class ChecklistController extends Controller
{
    //

    public function store(Request $request,$id)
    {
        // dd($request->all());
        $checklists = explode("\r\n",$request->checklist);
        foreach($checklists as $check)
        {
            $checklist = new ExitChecklist;
            $checklist->exit_signatory_id = $id;
            $checklist->checklist = $check;
            $checklist->save();
        }

       
        Alert::success('Successfully Stored')->persistent('Dismiss');
        return back();
    }
    public function remove($id)
    {
        // dd($request->all());
      
    // Retrieve the checklist or fail if not found
    $checklist = ExitChecklist::findOrFail($id);

    // Delete the checklist record
    $checklist->delete();

       
        Alert::success('Successfully Removed')->persistent('Dismiss');
        return back();
    }
}
