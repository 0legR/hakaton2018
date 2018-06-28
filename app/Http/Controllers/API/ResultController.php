<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Result;
use App\Models\Answer;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->all()) {
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
            if ($user->isUser()) {
                $results = Result::byUserId($userId)->get();
                $data = $this->getResult($results);
                return response()->json(['results' => $data['results']], $data['status']);
            } else if ($user->isHR()) {
                
            }
            return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
        }
        return response()->json(['error' => User::RESPONSE_EMPTY], 204);
    }

    public function getResult($results)
    {
        if (!$results->isEmpty()) {
            
            // $questionsAmount = $results->count();
            // $rightAnswersAmount = $results->where('status', true)->count();

            dd($results);




            return [compact('results'), 'status' => 200];
        }
        return response()->json(['error' => Result::RESPONSE_EMPTY, 'status' => 204]);
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
        $user = User::findOrFail($request->user_id);
        if ($user->isUser()) {
            $newResult = new Result($request->except('_token'));
            if ($newResult->validate()) {
                $newResult->save();
                return response()->json(['success' => Result::RESPONSE_SUCCESS], 201);
            } else {
                return response()->json(['error' => strval($newResult->errorMessages)], 418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
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
