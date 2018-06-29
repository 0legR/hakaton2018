<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->all()) {
            $user = User::findOrFail($request->user_id);
            if ($user->isHR()) {
                $company = Company::byCreator($user->id)->get();
                if ($company->count() > 0) {
                    return response()->json(compact('company'), 200);
                } else {
                    return response()->json(['error' => Company::RESPONSE_EMPTY, 'status' => 204]);
                }
            }
        }
        return response()->json(['error' => Company::RESPONSE_EMPTY, 'status' => 204]);
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
            $newCompany = new Company($request->except('_token'));
            if ($newCompany->validate()) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    if (!$newCompany->validateImage($image)) {
                        return response()->json(['error' => strval($newCompany->errorMessages)],418);
                    }
                    $newCompany->image = $image->store('companies', 'public');
                }
                $newCompany->user_id = $user->id;
                $newCompany->save();
                return response()->json(['success' => Company::RESPONSE_SUCCESS], 201);
            } else {
                return response()->json(['error' => strval($newCompany->errorMessages)],418);
            }
        }
        return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
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
