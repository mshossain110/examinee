<?php

namespace App\Http\Controllers;

use App\User;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $dataset['data']        = implode(',',$this->standardDeviation());
        $dataset['labels']      = implode(',', $this->standardDeviationLables());
        $dataset['getStudent']  = User::has('userResults')->where('role_id', User::STUDENT)->get();
        return view('home',$dataset);
    }

    public function standardDeviation()
    {
        $getStudent = User::has('userResults')->where('role_id', User::STUDENT)->get();
        $standardDeviation = [];
        $count = 0;
        foreach ($getStudent as $student) {
            $mean = $student->userResults->pluck('obtain')->avg();
            $x_mueSqure = 0;
            foreach ($student->userResults as $result) {
                   $x_mueSqure += ($result->obtain - $mean) * ($result->obtain - $mean); 

            }
            $standardDeviation[$count++] = number_format(sqrt($x_mueSqure / count($student->userResults)),2, '.', ' ');
            // $standardDeviation[$count++] = $mean;
        }
        return $standardDeviation;
        
    }

    public function standardDeviationLables()
    {
        $getStudent = User::has('userResults')->where('role_id', User::STUDENT)->get();
        $labels = [];
        $count = 0;
        foreach ($getStudent as $student) {
            $labels[$count++] = $student->id;
        }
        return $labels;
    }
}
