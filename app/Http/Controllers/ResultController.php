<?php

namespace App\Http\Controllers;

use App\Result;
use App\Exam;
use App\Question;
use Illuminate\Http\Request;
use Log;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eid = $request->eid;
        $answers = $request->answer;
        $exam = Exam::with('questions')->find($eid);
        $numberOfQuestion = $exam->questions->count();
        list( $point, $currectAnswer ) = $this->calculateResult( $exam->questions, $answers);
        Result::create([
            'eid'              => $eid,
            'answers'          => $answers,
            'point'            => $point,
            'numberOfQuestion' => $numberOfQuestion,
            'currectAnswer'    => $currectAnswer
        ]);
    }

    private function calculateResult( $questions, $answers)
    {
        $point = 0;
        $currectAnswer = 0;

        foreach ( $answers as $key => $value ) {
            $question = $questions->where('id', $key)->first();
            if ( $question->answer == $value ){
                $currectAnswer ++;
                $point = $point + (int) $question->mark;
            }
        }
        return compact('point', 'currectAnswer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }
}
