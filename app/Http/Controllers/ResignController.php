<?php

namespace App\Http\Controllers;
use App\Resign;
use App\Company;
use App\Mail\UploadResignation;
use App\Mail\SetupClearance;
use App\Mail\Signatory;
use Illuminate\Support\Facades\Mail;
use App\ExitResign;
use App\User;
use App\ExitReason;
use App\ExitClearance;
use App\ExitClearanceChecklist;
use App\ExitClearanceSignatory;
use App\ExitSignatory;
use App\Employee;
use App\Department;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ResignController extends Controller
{
    //
    public function index()
    {
 
        $resigns = ExitResign::whereDoesntHave('exit_clearance')->get();
        return view('resigned_employees',array(
            'resigns'=>$resigns));
    }

    public function upload()
    {
        $companies = Company::get();
        $departments = Department::get();
        $reasons = ExitReason::get();
        $employees = Employee::with('company','department')->whereDoesntHave('resign')->where('status','Active')->get();
        return view('upload_resigned',array(
            'companies' => $companies,
            'departments' => $departments,
            'employees' => $employees,
            'reasons' => $reasons,
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
        $exitResign->status = "For Clearance";
        $exitResign->type = "Resign";
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
     
        $users_admin = User::where('clearance_admin','1')->where('status','Active')->pluck('email')->toArray();
        $data = [];
        $data['employee_info'] = $employee;
        $data['last_employment'] = $exitResign;
        $send_update = Mail::to([$exitResign->personal_email, $employee->user_info->email])->cc($users_admin)->send(new UploadResignation($data));
        // $send_update = Mail::to("renz.cabato@wgroup.com.ph")->send(new LeaveNotification($details));
        Alert::success('Successfully Stored')->persistent('Dismiss');
        return redirect('resigned-employees');

    }
    public function trackClearance(Request $request)
    {
        return view('tracker');
    }
    public function setupClearancePost(Request $request,$id)
    {
       
        $resignEmployee = ExitResign::findOrfail($id);
        $employeeResign = Employee::findOrfail($resignEmployee->employee_id);
        $data = [];
        $data['employee_info'] = $employeeResign;
        $send_update = Mail::to([$resignEmployee->personal_email, $employeeResign->user_info->email])->send(new SetupClearance($data));
        foreach($request->checklists as $key => $checklist)
        {
            $exitClearance = new ExitClearance;
            $exitClearance->resign_id = $id;
            $exitClearance->department_id = $key;
            $exitClearance->employee_id = $resignEmployee->employee_id;
            $exitClearance->user_id = auth()->user()->id;
            $exitClearance->status = "Pending";
            $exitClearance->save();
            foreach($checklist as $check)
            {
                $exitClearanceChecklist = new ExitClearanceChecklist;
                $exitClearanceChecklist->exit_clearance_id = $exitClearance->id;
                $exitClearanceChecklist->checklist = $check;
                $exitClearanceChecklist->user_id = auth()->user()->id;
                $exitClearanceChecklist->status = "Pending";
                $exitClearanceChecklist->save();
            }
            foreach($request->employees[$key] as $employee)
            {
           
                $ExitClearanceSignatory = new ExitClearanceSignatory;
                $ExitClearanceSignatory->exit_clearance_id = $exitClearance->id;
                $ExitClearanceSignatory->department_id = $key;
                $ExitClearanceSignatory->employee_id = $employee;
                $ExitClearanceSignatory->user_id = auth()->user()->id;
                $ExitClearanceSignatory->status = "Pending";
                $ExitClearanceSignatory->save();

                $employee_signatory = Employee::findOrfail($employee);
                $data = [];
                $data['employee_info'] = $employee_signatory;
                $data['resignee_info'] = $employeeResign;

                $send_update = Mail::to([$employee_signatory->user_info->email])->send(new Signatory($data));
            }
        } 
        $resignEmployee->status = "Ongoing Clearance";   
        $resignEmployee->save();   
        Alert::success('Successfully Setup')->persistent('Dismiss');
        return redirect('resigned-employees');
    }
    public function setupClearance (Request $request, $id)
    {
        $employees = Employee::where('status','Active')->get();
        $resignEmployee = ExitResign::findOrfail($id);
        
        $employee = Employee::where('id',$resignEmployee->employee_id)->first();
        $signatories = ExitSignatory::with('department','checklists','signatories')->where('company_id',$employee->company_id)->get();
       
        if (count($signatories) == 0) {
            $signatories = ExitSignatory::with('department', 'checklists', 'signatories')
                ->where('company_id', 1)
                ->get();
        }
        return view('setup_clearance',
            array(
                'resignEmployee' =>  $resignEmployee,
                'signatories' =>  $signatories,
                'employees' =>  $employees,
            )
        );
    }

    public function editResignationLetter(Request $request, $id)
    {
        // dd($request->all(), $id);
        $exit_resign = ExitResign::findOrFail($id);

        if ($request->has('resignation_letter'))
        {
            $resignation_letter_file = $request->file('resignation_letter');
            $name = time().'_'.$resignation_letter_file->getClientOriginalName();
            $resignation_letter_file->move(public_path('resignation_letters'), $name);
    
            $exit_resign->resignation_letter = '/resignation_letters/'.$name;
            $exit_resign->save();
    
            Alert::success('Successfully Updated')->persistent('Dismiss');
            return back();
        }

        if ($request->has('acceptance_letter'))
        {
            $acceptance_letter_file = $request->file('acceptance_letter');
            $name = time().'_'.$acceptance_letter_file->getClientOriginalName();
            $acceptance_letter_file->move(public_path('acceptance_letters'), $name);
    
            $exit_resign->acceptance_letter = '/acceptance_letters/'.$name;
            $exit_resign->save();
    
            Alert::success('Successfully Updated')->persistent('Dismiss');
            return back();
        }

        // Alert::warning('Error! Please fill-up the fields before submitting')->persistent('Dismiss');
        // return back();
    }
}
