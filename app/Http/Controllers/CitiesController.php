<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Exceptions\Handler;
use App\City;

class CitiesController extends Controller {

    /**
     * @api {get} /cities/:id getCities
     * @apiVersion 0.1.0
     * @apiName getCities
     * @apiGroup Cities
     * 
     * @apiParam {integer} [id]
     */
    public function index() {
        return $this->helpReturn(City::all());
    }
    
    public function show($id) {
        return $this->helpReturn(City::find($id));
    }

    /**
     * @api {post} /cities storeCities
     * @apiVersion 0.1.0
     * @apiName storeCities
     * @apiGroup Cities
     * 
     * @apiParam {string} name
     */
    public function store(Request $request) {
        $rules = array('name' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $city = new City;
            $city->name = $request->name;
            $city->save();
            return $this->helpInfo();
        } else {
            return $this->helpError('Validator error', $valid);
        }
    }

    /**
     * @api {put} /cities/:id updateCities
     * @apiVersion 0.1.0
     * @apiName updateCities
     * @apiGroup Cities
     * 
     * @apiParam {string} name
     */
    public function update(Request $request, $id) {
        $rules = array('name' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $city = City::find($id);
            if($city) {
                $city->name = $request->name;
                $city->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('not found city');
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
