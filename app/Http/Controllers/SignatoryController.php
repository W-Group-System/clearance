<?php

namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\ExitSignatory;
use Illuminate\Http\Request;
use App\Employee;
use RealRashid\SweetAlert\Facades\Alert;

class SignatoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $company = $request->company;
        $department = $request->department ?? [];
        $employees = Employees::where('status','Active')->get();
        $companies = Company::get();
        $signatories = ExitSignatory::with('department','checklists')->where('company_id',$request->company)->get();
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
}
