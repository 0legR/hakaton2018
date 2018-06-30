<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Result;
use App\Models\Vacancy;
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
            $vacancyId = $request->vacancy_id;
            $user = User::findOrFail($userId);
            if ($user->isApplicant()) {
                if ($vacancyId) {
                    $data = $this->getSingleUserResult($vacancyId, $user);
                } else {
                    $data = $this->getAllUserResults($user);
                }
                return response()->json(['results' => $data['results']], $data['status']);
            } else if ($user->isHR()) {
                $results = $this->getAllResults();
                return response()->json(compact('results'), 200);
            }
            return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
        }
        return response()->json(['error' => User::RESPONSE_EMPTY], 204);
    }

    public function getAllResults()
    {
        $usersResult = Result::with('user')->select('user_id')->distinct()->get();
        $results = [];
        foreach ($usersResult as $user) {
            $results[] = $this->getAllUserResults($user->user)['results'];
        }
        return $results;
    }

    public function getSingleUserResult($vacancyId, $user)
    {
        $vacancy = Vacancy::findOrFail($vacancyId);
        if ($vacancy->count() > 0) {
            $results = $vacancy->results;
            $resultsCounted = $this->getResultHelper($results, $vacancy, $user);
            return ['results' => $resultsCounted, 'status' => 200];
        }
        return ['results' => Result::RESPONSE_EMPTY, 'status' => 204];
    }

    public function getResultHelper($results, $vacancy, $user)
    {
        $questionsAmount = $results->count();
        $rightAnswersAmount = $this->getAnswers($results);
        $persentageResult = 100 / (int)$questionsAmount * (int)$rightAnswersAmount;
        return [
            'vacancy' => $vacancy,
            'user' => $user,
            'result' => $persentageResult,
        ];
    }

    public function getAllUserResults($user)
    {
        $results = Result::byUserId($user->id)->select('vacancy_id')->distinct()->get();
        if (!$results->isEmpty()) {
            $resultsCounted = [];
            foreach ($results as $result) {
                $vacancy = Vacancy::findOrFail($result->vacancy_id);
                $resultsByVacancy = $vacancy->results;
                $resultsCounted[] = $this->getResultHelper($resultsByVacancy, $vacancy, $user);                
            }
            return ['results' => $resultsCounted, 'status' => 200];
        }
        return ['results' => Result::RESPONSE_EMPTY, 'status' => 204];
    }

    public function getAnswers($results)
    {
        $trueAnswers = 0;
        foreach ($results as $result) {
            $answer = Answer::findOrFail($result->answer_id);
            if ($answer->status) {
                $trueAnswers += 1;
            }
        }
        return $trueAnswers;
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
        if ($user->isApplicant()) {
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

    public function isUserPassedTest(Request $request)
    {
        if($request->all()) {
            $user = User::findOrFail($request->user_id);
            if ($user->isApplicant()) {
                $vacancyId = $request->vacancy_id;
                $questionId = $request->question_id;
                if ($vacancyId) {
                    $result = Result::byUserAndVacancy($user->id, $vacancyId)->get();
                } else if($questionId) {
                    $result = Result::byUserAndQuestion($user->id, $questionId)->get();
                }
                return response()->json(compact('result'), 200);
            }
            return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
        }
        return response()->json(['error' => User::RESPONSE_EMPTY], 204);

    }
}
