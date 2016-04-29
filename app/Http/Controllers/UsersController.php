<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->helpError('Access denied');
        //return $this->helpReturn(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * @api {post} /users storeUsers
     * @apiVersion 0.1.0
     * @apiName storeUsers
     * @apiGroup Users
     * 
     * @apiParam {string} type android/ios
     * @apiParam {string} token
     */
    public function store(Request $request) {
        $rules = array('type' => 'required', 'token' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $find = User::where('deviceType', '=', $request->type)
                            ->where('deviceToken', '=', $request->token)->first();
            if(!$find) {
                $user = new User;
                $user->deviceType = $request->type;
                $user->deviceToken = $request->token;
                $user->save();
                return $this->helpInfo($user->id);
            }else{
                return $this->helpInfo($find->id);
            }
        } else {
            return $this->helpError('Valid', $valid);
        }
    }

    /**
     * @api {get} /users/:id getUsers
     * @apiVersion 0.1.0
     * @apiName getUsers
     * @apiGroup Users
     * 
     */
    public function show($id) {
        return $this->helpReturn(User::findorfail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * @api {put} /users storeUsers
     * @apiVersion 0.1.0
     * @apiName storeUsers
     * @apiGroup Users
     * 
     * @apiParam {string} type android/ios
     * @apiParam {string} token
     */
    public function update(Request $request, $id) {
        $rules = array('type' => 'required', 'token' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $user = User::findorfail($id);
            if($user) {
                $user->deviceType = $request->type;
                $user->deviceToken = $request->token;
                return $this->helpInfo();
            } else {
                return $this->helpError('Resource not found');
            }
        } else {
            return $this->helpError('Valid', $valid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
