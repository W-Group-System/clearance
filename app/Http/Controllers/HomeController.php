<?php

namespace App\Http\Controllers;
use App\ExitResign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // Get resignations for the current year
        $resigns = ExitResign::get();
        $resignThisMonth = ExitResign::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->get();
        // dd($resigns_old);
        return view('home',
        array(
            'resigns' => $resigns,
            'resignThisMonth' => $resignThisMonth,
        ));
    }
}
