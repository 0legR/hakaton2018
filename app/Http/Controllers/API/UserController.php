<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function store(Request $request) {
    	$newUser = new User($request->except('_token'));
    	if ($newUser->validate()) {
    		$newUser->save();
    		return response()->json(['success' => User::RESPONSE_SUCCESS, 'status' => 201]);
    	} else {
    		return response()->json(['error' => strval($newUser->errorMessages), 'status' => 418]);
    	}
    }

    public function loggin(Request $request) {
    	$user = User::byEmail($request->email)->first();
    	if ($user->isHR()) {
    		$user['isHR'] = true;
    	} else if($user->isUser()) {
    		$user['isUser'] = true;
    	} else {
    		return response()->json(['error' => User::RESPONSE_UNREGISTERED, 'status' => 401]);
    	}
    	return response()->json(['user' => $user, 'status' => 200]);
    }

}
