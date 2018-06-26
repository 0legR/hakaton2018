<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\User;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacancies = Vacancy::byActive(Vacancy::STATUS_ACTIVE)->get();
        if ($vacancies->isEmpty()) {
            return response()->json(['error' => Vacancy::RESPONSE_EMPTY, 'status' => 204]);
        } else {
            return response()->json(['vacancies' => $vacancies, 'status' => 200]);
        }
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
            $newVacancy = new Vacancy($request->except('_token'));
            if ($newVacancy->validate()) {
                $newVacancy->save();
                return response()->json(['success' => Vacancy::RESPONSE_SUCCESS, 'status' => 201]);
            } else {
                return response()->json(['error' => strval($newVacancy->errorMessages), 'status' => 418]);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED, 'status' => 401]);
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
        $user = User::findOrFail($request->userId);
        if ($user->isHR()) {
            $vacancy = Vacancy::findOrFail($id);
            $vacancy->fill($request->except('_token'));
            if ($vacancy->validate()) {
                $vacancy->save();
                return response()->json(['success' => Vacancy::RESPONSE_SUCCESS, 'status' => 201]);
            } else {
                return response()->json(['error' => strval($newVacancy->errorMessages), 'status' => 418]);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED, 'status' => 401]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($request->userId);
        if ($user->isHR()) {
            if (Vacancy::destroy($id)) {
                return response()->json(['success' => Vacancy::RESPONSE_DESTROY, 'status' => 201]);
            } else {
                return response()->json(['error' => Vacancy::RESPONSE_UNDESTROY, 'status' => 418]);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED, 'status' => 401]);
    }
}
