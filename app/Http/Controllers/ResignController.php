<?php

namespace App\Http\Controllers;
use App\Resign;
use App\Company;
use App\Department;
use Illuminate\Http\Request;

class ResignController extends Controller
{
    //
    public function index()
    {
        $resigns = Resign::get();
        return view('resigned_employees');
    }

    public function upload()
    {
        $companies = Company::get();
        $departments = Department::get();
        return view('upload_resigned',array(
            'companies' => $companies,
            'departments' => $departments
        ));
    }
    public function store(Request $request)
    {
        dd($request->all());
    }
}
