<?php

namespace App\Http\Controllers;
use App\Resign;
use App\Company;
use App\ExitResign;
use App\Employee;
use App\Department;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ResignController extends Controller
{
    //
    public function index()
    {
        $resigns = ExitResign::get();
        return view('resigned_employees',array(
            'resigns'=>$resigns));
    }

    public function upload()
    {
        $companies = Company::get();
        $departments = Department::get();
        $employees = Employee::with('company','department')->where('status','Active')->get();
        return view('upload_resigned',array(
            'companies' => $companies,
            'departments' => $departments,
            'employees' => $employees
        ));
    }
    public function store(Request $request)
    {
        $employee = Employee::where('id',$request->name)->first();
        $exitResign = new ExitResign;
        $exitResign->employee_id = $request->name;
        $exitResign->company_id = $employee->company_id;
        $exitResign->department_id = $employee->department_id;
        $exitResign->date_hired = $employee->original_date_hired;
        $exitResign->position = $employee->position;
        $exitResign->reason_for_separation = $request->reason;
        $exitResign->personal_email = $request->personal_email_address;
        $exitResign->personal_number = $request->personal_phone_number;
        $exitResign->address = $request->address;
        $exitResign->last_date = $request->last_date_of_employment;

        if($request->file('resignation_letter')){
            $logo = $request->file('resignation_letter');
            $original_name = $logo->getClientOriginalName();
            $name = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path() . '/resignation_letters/', $name);
            $file_name = '/resignation_letters/' . $name;
            $exitResign->resignation_letter = $file_name;
        }
        if($request->file('acceptance_letter')){
            $logo = $request->file('acceptance_letter');
            $original_name = $logo->getClientOriginalName();
            $name = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path() . '/acceptance_letters/', $name);
            $file_name = '/acceptance_letters/' . $name;
            $exitResign->acceptance_letter = $file_name;
        }
        $exitResign->save();
        Alert::success('Successfully Stored')->persistent('Dismiss');
        return back();

    }
    public function trackClearance(Request $request)
    {
        return view('tracker');
    }
}
