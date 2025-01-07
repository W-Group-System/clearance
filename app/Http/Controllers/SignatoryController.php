<?php

namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\ExitSignatory;
use App\ExitSignatorySignatory;
use Illuminate\Http\Request;
use App\Employee;
use App\ExitClearanceSignatory;
use RealRashid\SweetAlert\Facades\Alert;

class SignatoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $company = $request->company;
        $department = $request->department ?? [];
        $employees = Employee::where('status','Active')->get();
        $companies = Company::get();
        $signatories = ExitSignatory::with('department','checklists','signatories')->where('company_id',$request->company)->get();
        $signatory_departments = $signatories->pluck('department_id')->toArray();
        $departments = Department::whereNotIn('id',$signatory_departments)->get();
        return view('signatories',array(
            'companies'=>$companies,
            'department'=>$department,
            'departments'=>$departments,
            'signatories'=>$signatories,
            'company'=>$company,
            'employees'=>$employees,
        ));
    }


    public function store(Request $request)
    {
        foreach($request->departments as $department)
        {
            $exist = ExitSignatory::where('company_id',$request->company)->where('department_id',$department)->first();
            if($exist == null)
            {
                $signatories = new ExitSignatory;
                $signatories->company_id = $request->company;
                $signatories->department_id = $department;
                $signatories->created_by = auth()->user()->id;
                $signatories->save();
            }
     
        }
        Alert::success('Successfully Stored')->persistent('Dismiss');
        return back();
    }
    public function addSignatory(Request $request,$id)
    {
        $signatories = ExitSignatorySignatory::where('exit_signatory_id',$id)->delete();

        foreach($request->employees as $employee)
        {
           
            $signatories = new ExitSignatorySignatory;
            $signatories->exit_signatory_id = $id;
            $signatories->employee_id = $employee;
            $signatories->save();
    
        }
        Alert::success('Successfully Stored')->persistent('Dismiss');
        return back();
    }

    public function update(Request $request,$id)
    {
        $signatories = ExitClearanceSignatory::findOrFail($id);
        $signatories->employee_id = $request->employee;
        $signatories->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }
}
