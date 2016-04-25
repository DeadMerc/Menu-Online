<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Shop;
use App\Category;
use App\City;
use App\Photo;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class ShopsController extends Controller {

    /**
     * @api {get} /shops/:id getShops
     * @apiVersion 0.1.1
     * @apiName getShops
     * @apiGroup Shops
     * 
     * @apiHeader {integr} [city_id]
     * @apiParam {integer} [id]
     */
    public function index(Request $request) {
        $city_id = $request->header('city_id');
        if($city_id) {
            return $this->helpReturn(Shop::with('photos')
                                    ->with('reviews')
                                    ->with('category')
                                    ->where('date_start', '<=', Carbon::today()->toDateString())
                                    ->where('date_stop', '>=', Carbon::today()->toDateString())
                                    ->where('city_id', '=', $city_id)
                                    ->get(), null, 'city_id');
        } else {
            return $this->helpReturn(Shop::with('photos')
                                    ->with('reviews')
                                    ->with('category')
                                    ->where('date_start', '<=', Carbon::today()->toDateString())
                                    ->where('date_stop', '>=', Carbon::today()->toDateString())
                                    ->get(), null, 'with out city_id');
        }
    }

    public function show($id) {
        return $this->helpReturn(Shop::with('photos')->with('reviews')->findorfail($id));
    }

    public function edit($id = false) {
        $cities = [];
        foreach(City::all() as $city) {
            $cities[$city->id] = $city->name;
        }
        $categories = [];
        foreach(Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }

        if($id) {
            $data = array('item' => Shop::findorfail($id));
        } else {
            $data = array('item' => '');
        }
        $data['cities'] = $cities;
        $data['categories'] = $categories;
        return view('admin.shop', $data);
    }

    /**
     * @api {post} /shops storeShops
     * @apiVersion 0.1.0
     * @apiName storeShops
     * @apiGroup Shops
     * 
     * @apiParam {integer} category_id
     * @apiParam {integer} city_id
     * @apiParam {string} title
     * @apiParam {string} time В какое время работает
     * @apiParam {string} street Улица
     * @apiParam {string} lat
     * @apiParam {string} lon
     * @apiParam {string} url
     * @apiParam {datetime} date_start
     * @apiParam {datetime} date_stop
     * @apiParam {file} image
     * 
     */
    public function store(Request $request) {
        $rules = array('category_id' => 'required', 'city_id' => 'required',
            'title' => 'required', 'time' => 'required', 'street' => 'required',
            'date_start' => 'required', 'date_stop' => 'required', 'description' => 'required',
            'phone' => 'required', 'lat' => 'required', 'lon' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $shop = new Shop;
            $shop->category_id = $request->category_id;
            $shop->city_id = $request->city_id;
            $shop->title = $request->title;
            $shop->time = $request->time;
            $shop->street = $request->street;
            $shop->date_start = $request->date_start;
            $shop->date_stop = $request->date_stop;
            $shop->description = $request->description;
            $shop->lat = $request->lat;
            $shop->lon = $request->lon;
            $shop->phone = $request->phone;
            $shop->url = $request->url;
            $shop->save();
            if(is_array($request->images)) {
                foreach($request->images as $image) {
                    if($image) {
                        $fileName = md5(rand(999, 99999) . date('d m Y')) . '.jpg';
                        $image->move(storage_path() . '/app/public/images', $fileName);
                        $photo = new Photo;
                        $photo->shop_id = $shop->id;
                        $photo->image = $fileName;
                        $photo->save();
                        unset($photo);
                    }
                }
            }
            return $this->helpInfo();
            /*
              if($request->hasFile('image')) {
              $fileName = md5($shop->title . date('d m Y') . $shop->title) . '.jpg';
              $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
              //$shop->image = $fileName;
              } else {
              //$shop->image = null;
              } */
        } else {
            return $this->helpError('Validator', $valid);
        }
    }

    /**
     * @api {post} /shops/:id updateShops
     * @apiVersion 0.1.0
     * @apiName updateShops
     * @apiGroup Shops
     * 
     * @apiParam {integer} category_id
     * @apiParam {integer} city_id
     * @apiParam {string} title
     * @apiParam {string} time В какое время работает
     * @apiParam {string} street Улица
     * @apiParam {string} lat
     * @apiParam {string} lon
     * @apiParam {string} url
     * @apiParam {datetime} date_start
     * @apiParam {datetime} date_stop
     * @apiParam {file} image
     * 
     */
    public function update(Request $request, $id) {
        $rules = array('category_id' => 'required', 'city_id' => 'required',
            'title' => 'required', 'time' => 'required', 'street' => 'required',
            'date_start' => 'required', 'date_stop' => 'required', 'description' => 'required',
            'phone' => 'required', 'lat' => 'required', 'lon' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $shop = Shop::findorfail($id);
            if($shop) {
                $shop->category_id = $request->category_id;
                $shop->city_id = $request->city_id;
                $shop->title = $request->title;
                $shop->time = $request->time;
                $shop->lat = $request->lat;
                $shop->lon = $request->lon;
                $shop->street = $request->street;
                $shop->date_start = $request->date_start;
                $shop->date_stop = $request->date_stop;
                $shop->description = $request->description;
                $shop->phone = $request->phone;
                $shop->url = $request->url;
                $shop->save();

                if(is_array($request->images)) {
                    Photo::where('shop_id', '=', $shop->id)->delete();
                    foreach($request->images as $image) {
                        if($image) {
                            $fileName = md5(rand(999, 99999) . date('d m Y')) . '.jpg';
                            $image->move(storage_path() . '/app/public/images', $fileName);
                            $photo = new Photo;
                            $photo->shop_id = $shop->id;
                            $photo->image = $fileName;
                            $photo->save();
                            unset($photo);
                        }
                    }
                }
                return $this->helpInfo();
            } else {
                return $this->helpError('Not found resource');
            }
        } else {
            return $this->helpError('Validator', $valid);
        }
    }

    public function showAll() {
        $shops = Shop::with('photos')->get();

        return view('admin.shops', array('shops' => $shops));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $item = Shop::findOrFail($id);
        $item->delete();
        return redirect('/admin/shops');
    }

}
