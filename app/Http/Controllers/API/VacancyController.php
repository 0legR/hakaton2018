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
    public function index(Request $request)
    {
        if ($request->all()) {
            $vacancies = $this->getVacanciesByCreator($request);
        } else {
            $vacancies = Vacancy::byActive(Vacancy::STATUS_ACTIVE)->get();
        }
        if ($vacancies->isEmpty()) {
            return response()->json(['error' => Vacancy::RESPONSE_EMPTY], 204);
        } else {
            return response()->json(compact('vacancies'), 200);
        }
    }

    public function getVacanciesByCreator($data)
    {
        $userId = $data->user_id;
        $user = User::findOrFail($userId);
        if ($user->isHR()) {
            return Vacancy::byCreator($userId)->get();
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        if ($user->isHR()) {
            $newVacancy = new Vacancy($request->except('_token'));
            if ($newVacancy->validate()) {
                $newVacancy->created_by = $user->id;
                $newVacancy->save();
                return response()->json(['success' => Vacancy::RESPONSE_SUCCESS], 201);
            } else {
                return response()->json(['error' => strval($newVacancy->errorMessages)],418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($request->user_id);
        if ($user->isHR()) {
            $vacancy = Vacancy::findOrFail($id);
            if ($vacancy->count() > 0) {
                return response()->json(compact('vacancy'), 201);
            } else {
                return response()->json(['error' => strval($newVacancy->errorMessages)], 418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
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
        $user = User::findOrFail($request->user_id);
        if ($user->isHR()) {
            $vacancy = Vacancy::findOrFail($id);
            $vacancy->fill($request->except('_token'));
            if ($vacancy->validate()) {
                $vacancy->save();
                return response()->json(['success' => Vacancy::RESPONSE_SUCCESS], 201);
            } else {
                return response()->json(['error' => strval($newVacancy->errorMessages)], 418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($request->user_id);
        if ($user->isHR()) {
            if (Vacancy::destroy($id)) {
                return response()->json(['success' => Vacancy::RESPONSE_DESTROY], 201);
            } else {
                return response()->json(['error' => Vacancy::RESPONSE_UNDESTROY], 418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
    }
}
