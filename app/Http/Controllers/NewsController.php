<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\City;
use App\Http\Requests;

class NewsController extends Controller {

    /**
     * @api {get} /news/:id getNews
     * @apiVersion 0.1.0
     * @apiName getNews
     * @apiGroup News
     * 
     * @apiHeader {integr} [city_id]
     * @apiParam {integer} [id]
     */
    public function index(Request $request) {
        $city_id = $request->header('city_id');
        if($city_id) {
            return $this->helpReturn(News::where('city_id', '=', $city_id)
                                    ->get());
        } else {
            return $this->helpReturn(News::all());
        }
    }
    public function show($id) {
        return $this->helpReturn(News::find($id));
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
     * @api {post} /news/:id storeNews
     * @apiVersion 0.1.0
     * @apiName storeNews
     * @apiGroup News
     * 
     * @apiParam {integr} city_id
     * @apiParam {string} title
     * @apiParam {string} description
     * @apiParam {file} image
     * @apiParam {datetime} date
     */
    public function store(Request $request) {
        $rules = ['city_id' => 'required', 'title' => 'required',
            'description' => 'required','date'=>'required'];
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $news = new News;
            $news->title = $request->title;
            $news->city_id = $request->city_id;
            $news->description = $request->description;
            $news->date = $request->date;
            if($request->hasFile('image')) {
                $fileName = md5($news->title . date('d m Y')) . '.jpg';
                $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                $news->image = $fileName;
            } else {
                $news->image = null;
            }
            $news->save();
            return $this->helpInfo();
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    
    public function showAll() {
        return view('admin.news', array('news' => News::all()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = false) {
        $cities = [];
        foreach(City::all() as $city) {
            $cities[$city->id] = $city->name;
        }
        if($id) {
            $data = array('item' => News::find($id));
        } else {
            $data = array('item' => '');
        }
        $data['cities'] = $cities;
        return view('admin.new', $data);
    }

    /**
     * @api {put} /news/:id updateNews
     * @apiVersion 0.1.0
     * @apiName updateNews
     * @apiGroup News
     * 
     * @apiParam {integer} city_id
     * @apiParam {string} title
     * @apiParam {string} description
     * @apiParam {file} image
     * @apiParam {datetime} date
     */
    public function update(Request $request, $id) {
        $rules = ['city_id' => 'required', 'title' => 'required',
            'description' => 'required','date'=>'required'];
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $news = News::find($id);
            if($news) {
                $news->title = $request->title;
                $news->city_id = $request->city_id;
                $news->description = $request->description;
                $news->date = $request->date;
                if($request->hasFile('image')) {
                    $fileName = md5($news->title . date('d m Y')) . '.jpg';
                    $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                    $news->image = $fileName;
                } else {
                    $news->image = null;
                }
                $news->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('not found resource');
            }
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $news = News::find($id);
        $news->delete();
        return redirect('/admin/news');
    }

}
