<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promo;
use App\Shop;
use App\Http\Requests;
use App\City;

class PromosController extends Controller {

    /**
     * @api {get} /promos/:id getPromos
     * @apiVersion 0.1.0
     * @apiName getPromos
     * @apiGroup Promos
     * 
     * @apiParam {integer} [id]
     */
    public function index(Request $request) {
        $city_id = $request->header('city_id');
        if($city_id) {
            $promos = Promo::where('city_id', '=', $city_id)->get();
        } else {
            $promos = Promo::all();
        }
        return $this->helpReturn($promos);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->helpReturn(Promo::findorfail($id));
    }

    public function showAll() {
        $promos = Promo::all();
        return view('admin.promos', ['promos' => $promos]);
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
     * @api {post} /promos storePromos
     * @apiVersion 0.1.0
     * @apiName storePromos
     * @apiGroup Promos
     * 
     * @apiParam {file} image
     * @apiParam {string} [shop_id]
     * @apiParam {string} [url]
     */
    public function store(Request $request) {
        if($request->hasFile('image')) {
            $fileName = md5(rand(999, 9999) . date('d m Y')) . '.jpg';
            $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
            $promo = new Promo;
            $promo->image = $fileName;
            $promo->shop_id = $request->shop_id == 0 || empty($request->shop_id) ? null : $request->shop_id;
            $promo->url = $request->url;
            $promo->city_id = $request->city_id;
            $promo->save();
            return $this->helpInfo();
        } else {
            return $this->helpError('Where image?');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = false) {
        $shops = ['0' => 'Заведение не установлено'];
        foreach(Shop::all() as $shop) {
            $shops[$shop->id] = $shop->title;
        }
        $cities = [];
        foreach(City::all() as $city) {
            $cities[$city->id] = $city->name;
        }
        if($id) {
            $data = ['item' => Promo::findorfail($id)];
        } else {
            $data = ['item' => ''];
        }
        $data['cities'] = $cities;
        $data['shops'] = $shops;
        return view('admin.promo', $data);
    }

    /**
     * @api {put} /promos updatePromos
     * @apiVersion 0.1.0
     * @apiName updatePromos
     * @apiGroup Promos
     * 
     * @apiParam {file} image
     * @apiParam {string} [shop_id]
     * @apiParam {string} [url]
     */
    public function update(Request $request, $id) {
        if($request->hasFile('image')) {
            $fileName = md5(rand(999, 9999) . date('d m Y')) . '.jpg';
            $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
            $promo = Promo::findorfail($id);
            if($promo) {
                $promo->image = $fileName;
                $promo->shop_id = $request->shop_id;
                $promo->url = $request->url;
                $promo->city_id = $request->city_id;
                $promo->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('not found resource');
            }
        } else {
            return $this->helpError('Where image?');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $promo = Promo::findorfail($id);
        $promo->delete();
        return redirect('/admin/promos');
    }

}
