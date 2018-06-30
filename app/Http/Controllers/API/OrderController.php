<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\User;

class OrderController extends Controller
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

            if ($user->isAdmin()) {
                $orders = Order::all();
                if ($orders->count() > 0) {
                    return response()->json(compact('orders'), 200);
                } 
                return response()->json(['error' => Order::RESPONSE_EMPTY, 'status' => 204]);
            }
        }
        return response()->json(['error' => Order::RESPONSE_EMPTY, 'status' => 204]);
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
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        if ($user->isHR()) {
            $newOrder = new Order($request->except('_token'));
            if ($newOrder->validate()) {
                $newOrder->user_id = $user->id;
                $newOrder->save();
                return response()->json(['success' => Order::RESPONSE_SUCCESS], 201);
            } else {
                return response()->json(['error' => strval($newOrder->errorMessages)],418);
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
