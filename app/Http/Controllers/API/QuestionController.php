<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Vacancy;
use App\Models\Answer;
use App\User;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->all()) {
            $user = User::findOrFail($request->userId);
            if ($user->isHR()) {
                if ($request->vacancy_id) {
                    $questions = Question::byVacancy($request->vacancy_id)->get();
                } else {
                    $questions = Question::all();
                }
                
                $vacancies = Vacancy::all();
    
                if (!$vacancies->isEmpty() && !$questions->isEmpty()) {
                    return response()->json([
                        'vacancies' => $vacancies,
                        'questions' => $questions,
                        'status' => 200,
                    ]);
                } 
                return response()->json(['error' => Question::RESPONSE_EMPTY, 'status' => 204]);
            }
        }
        return response()->json(['error' => Question::RESPONSE_EMPTY, 'status' => 204]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::findOrFail($request->userId);
        if ($user->isHR()) {
            $newQuestion = new Question($request->only('vacancy_id', 'name', 'status'));
            if ($newQuestion->validate()) {
                $newQuestion->save();
                $answer = $this->storeAnswer($request->answers, $newQuestion->id);
                if ($answer) {
                    return response()->json(['success' => Question::RESPONSE_SUCCESS, 'status' => 201]);
                } else {
                    return response()->json(['error' => $answer, 'status' => 418]);    
                } 
            } else {
                return response()->json(['error' => strval($newQuestion->errorMessages), 'status' => 418]);
            }
        } else {
            return response()->json(['error' => User::RESPONSE_UNREGISTERED, 'status' => 401]);
        }
    }

    public function storeAnswer($answers, $question_id) {
        if(count($answers) > 0) {
            foreach ($answers as $data) {
                $newAnswer = new Answer($data);
                $newAnswer->question_id = $question_id;
                if ($newAnswer->validate()) {
                    $newAnswer->save();
                } else {
                    return strval($newAnswer->errorMessages);
                }
            }
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
