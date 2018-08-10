<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    // public function login(Request $request){
    //     $credentials = $request->only('email', 'password');
    //     if(Auth::attempt($credentials)){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('passport')->accessToken;
    //         return response()->json(['success' => $success], config('constants.responseStatuses.OK'));
    //     }
    //     else{
    //         return response()->json(['error'=>'Unauthorised'], config('constants.responseStatuses.unauthorized'));
    //     }
    // }
    public function loggin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('passport')->accessToken;
            if ($user->isHR()) {
                $user['isHR'] = true;
            } else if($user->isApplicant()) {
                $user['isApplicant'] = true;
            } else if($user->isAdmin()) {
                $user['isAdmin'] = true;
            } else {
                return response()->json(['error' => User::RESPONSE_UNREGISTERED], config('constants.responseStatuses.unauthorized'));
            }
            return response()->json(compact('user'), config('constants.responseStatuses.OK'));
        } else {
            return response()->json(['error' => User::RESPONSE_UNREGISTERED], config('constants.responseStatuses.unauthorized'));
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    // public function register(Request $request)
    // {
    //     $newUser = new User($request->except('_token'));

    //     if ($newUser->validate()) {
    //         $newUser['password'] = bcrypt($request->password);
    //         $newUser->save();
    //         $success['token'] =  $newUser->createToken('passport')->accessToken;
    //         $success['name'] =  $newUser->name;
    //         return response()->json(['success'=>$success], config('constants.responseStatuses.created'));
    //     }
    //     return response()->json(['error'=>strval($newUser->errorMessages)], config('constants.responseStatuses.unauthorized'));
    // }

    public function store(Request $request)
    {
        $newUser = new User($request->except('_token'));
        if ($newUser->validate()) {
            $newUser['password'] = bcrypt($request->password);
            $newUser->save();
            $user = $newUser;
            $user['token'] = $newUser->createToken('passport')->accessToken;
            return response()->json(compact('user'), config('constants.responseStatuses.created'));
        }
        return response()->json(['error'=>strval($newUser->errorMessages)], config('constants.responseStatuses.unauthorized'));
    }

     // public function store(Request $request)
    // {
    //     $newUser = new User($request->except('_token'));
    //     // $newUser->password = bcrypt($request->password);
    //     if ($newUser->validate()) {
    //         $newUser->save();
    //         return response()->json(['success' => User::RESPONSE_SUCCESS], config('constants.responseStatuses.created'));
    //     } else {
    //         return response()->json(['error' => strval($newUser->errorMessages)], 418);
    //     }
    // }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    // public function details()
    // {
    //     $user = Auth::user();
    //     return response()->json(['success' => $user], config('constants.responseStatuses.OK'));
    // }

}
