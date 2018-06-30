<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function store(Request $request) {
    	$newUser = new User($request->except('_token', 'password'));
        // $newUser->password = bcrypt($request->password);
    	if ($newUser->validate()) {
    		$newUser->save();
    		return response()->json(['success' => User::RESPONSE_SUCCESS], 201);
    	} else {
    		return response()->json(['error' => strval($newUser->errorMessages)], 418);
    	}
    }

    public function loggin(Request $request) {
        if($request->all()) {
        	$user = User::byEmail($request->email)->first();
            if ($user->password === $request->password) {
                if ($user->isHR()) {
                    $user['isHR'] = true;
                } else if($user->isApplicant()) {
                    $user['isApplicant'] = true;
                } else {
                    return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
                }
                return response()->json(compact('user'), 200);
            } else {
                return response()->json(['error' => User::RESPONSE_UNREGISTERED], 401);
            }
        }
        return response()->json(['error' => User::RESPONSE_EMPTY], 204);
    }

}
