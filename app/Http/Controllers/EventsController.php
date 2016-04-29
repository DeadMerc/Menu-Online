<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Event;
use App\Event_follow;
use App\Shop;
use App\User;
use App\City;
use App\Category;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use App\Category_follow;

class EventsController extends Controller {
    /**
     * @api {none} /none ВАЖНАЯ ИНФА
     * @apiVersion 0.1.0
     * @apiName importantInformation
     * @apiGroup importantInformation
     * @apiDescription Акции -> Events,Cобытия -> News
     */

    /**
     * @api {get} /events/:id getEvents
     * @apiVersion 0.1.1
     * @apiName getEvents
     * @apiGroup Events
     * @apiHeader {integer} [city_id]
     * @apiParam {integer} [id]
     */
    public function index(Request $request) {
        $city_id = $request->header('city_id');
        if($city_id) {
            return $this->helpReturn(Event::where('date_start', '<=', Carbon::today()->toDateString())
                                ->where('date_stop', '>=', Carbon::today()->toDateString())
                                ->where('city_id','=',$city_id)
                                ->get());
        } else {
            return $this->helpReturn(Event::where('date_start', '<=', Carbon::today()->toDateString())
                                ->where('date_stop', '>=', Carbon::today()->toDateString())
                                ->get());
        }
        
    }

    public function show($id) {
        return $this->helpReturn(Event::findorfail($id));
    }

    public function showAll() {
        $events = Event::all();
        return view('admin.events', array('events' =>$events));
    }

    /**
     * @api {post} /events/ storeEvents
     * @apiVersion 0.1.0
     * @apiName storeEvents
     * @apiGroup Events
     * 
     * @apiParam {integer} category_id
     * @apiParam {string} title
     * @apiParam {string} description
     * @apiParam {datetime} dateStart
     * @apiParam {datetime} dateStop
     * @apiParam {integer} publish
     * @apiParam {file} image
     * 
     */
    public function store(Request $request) {
        $rules = array('category_id' => 'required', 'title' => 'required',
            'description' => 'required', 'date_start' => 'required', 'date_stop' => 'required',
            'shop_id' => 'required', 'city_id' => 'required','shop_id'=>'required');

        $request->dateStart = urldecode($request->dateStart);
        $request->dateStop = urldecode($request->dateStop);
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $event = new Event;
            $event->category_id = $request->category_id;
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date_start = $request->date_start;
            $event->date_stop = $request->date_stop;
            $event->shop_id = $request->shop_id;
            $event->city_id = $request->city_id;
            if($request->hasFile('image')) {
                $fileName = md5($event->title . date('d m Y') . $event->dateStop) . '.jpg';
                $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                $event->image = $fileName;
            } else {
                $event->image = null;
            }
            $event->save();
            //send push with info, new branch
            $users = Category_follow::where('category_id', '=', $request->category_id)->get();
            $debug = [];
            foreach($users as $user) {
                $message['message'] = $request->title;
                $message['image'] = $event->image;
                $message['shop_id'] = $event->shop_id;
                $message['description'] = $event->description;
                $debug[] = $this->sendPushToUser(User::findorfail($user->user_id), $message);
            }

            return $this->helpInfo($debug);
        } else {
            return $this->helpError('Valid', $valid);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = false) {
        $shops = [];
        foreach(Shop::all() as $shop) {
            $shops[$shop->id] = $shop->title;
        }
        /*
        $categories = [];
        foreach(Category::all() as $category) {
            $categories[$category->id] = $category->name;
        }*/
        $categories = $this->getCategoriesForHtml();
        $cities = [];
        foreach(City::all() as $city) {
            $cities[$city->id] = $city->name;
        }

        if($id) {
            $data = ['item' => Event::findorfail($id)];
        } else {
            $data = ['item' => ''];
        }
        $data['shops'] = $shops;
        $data['categories'] = $categories;
        $data['cities'] = $cities;
        return view('admin.event', $data);
    }

    /**
     * @api {put} /events/:id updateEvents
     * @apiVersion 0.1.0
     * @apiName updateEvents
     * @apiGroup Events
     * 
     * @apiParam {integer} category_id
     * @apiParam {string} title
     * @apiParam {string} description
     * @apiParam {datetime} dateStart
     * @apiParam {datetime} dateStop
     * @apiParam {integer} publish
     * @apiParam {file} image
     * 
     */
    public function update(Request $request, $id) {
        $rules = array('category_id' => 'required', 'title' => 'required',
            'description' => 'required', 'date_start' => 'required', 'date_stop' => 'required',
            'shop_id' => 'required', 'city_id' => 'required','shop_id'=>'required');

        $request->dateStart = urldecode($request->dateStart);
        $request->dateStop = urldecode($request->dateStop);
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $event = Event::findorfail($id);
            if($event) {
                $event->category_id = $request->category_id;
                $event->title = $request->title;
                $event->description = $request->description;
                $event->date_start = $request->date_start;
                $event->date_stop = $request->date_stop;
                $event->shop_id = $request->shop_id;
                $event->city_id = $request->city_id;
                if($request->hasFile('image')) {
                    $fileName = md5($event->title . date('d m Y') . $event->dateStop) . '.jpg';
                    $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                    $event->image = $fileName;
                } else {
                    $event->image = null;
                }
                //$event->publish = $request->publish;
                $event->save();
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
        $item = Event::findOrFail($id);
        $item->delete();
        return redirect('/admin/events');
    }

}
