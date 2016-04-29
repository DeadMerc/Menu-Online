<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Event;
use App\Review;
use App\Stat;
use App\Shop;
use Carbon\Carbon;

class AdminController extends Controller {

    public function index() {
        
        $counts['users'] = User::all();
        $counts['users'] = $counts['users']->count();

        $counts['events'] = Event::all();
        $counts['events'] = $counts['events']->count();

        $counts['reviews'] = Review::all()->count();
        $counts['views'] = Stat::findorfail(1)->views;
        //count users every month
        $counts['line_users'] = array();
        for($i = 1; $i <= 12; $i++) {
            $now = Carbon::createFromDate(date("Y"), $i, 1);
            $counts['line_users'][$i] = User::where('created_at', '>=', $now->toDateTimeString())
                    ->where('created_at', '<=', $now->addMonth()->toDateTimeString())
                    ->get()
                    ->count();
        }

        //уведомления
        $messages['stoped'] = [];
        $now = Carbon::now('Europe/Moscow');
        $i = 0;
        foreach(Shop::where('date_stop', '<', $now->toDateString())->get() as $shop) {
            $messages['stoped'][$i]['title'] = $shop->title;
            $messages['stoped'][$i]['id'] = $shop->id;
            $shop_date_stop = Carbon::createFromFormat('Y-m-d', $shop->date_stop);
            $difference = $now->diffInHours($shop_date_stop);
            $messages['stoped'][$i]['ago_type'] = 'часов';
            $messages['stoped'][$i]['for_sort'] = $difference;
            if($difference > 100) {
                $difference = $now->diffInDays($shop_date_stop);
                $messages['stoped'][$i]['ago_type'] = 'дней';
            }
            $messages['stoped'][$i]['type'] = 'shop';
            $messages['stoped'][$i]['ago'] = $difference;
            $i++;
        }
        foreach(Event::where('date_stop', '<', $now->toDateString())->get() as $shop) {
            $messages['stoped'][$i]['title'] = $shop->title;
            $messages['stoped'][$i]['id'] = $shop->id;
            $shop_date_stop = Carbon::createFromFormat('Y-m-d', $shop->date_stop);
            $difference = $now->diffInHours($shop_date_stop);
            $messages['stoped'][$i]['ago_type'] = 'часов';
            $messages['stoped'][$i]['for_sort'] = $difference;
            if($difference > 24) {
                $difference = $now->diffInDays($shop_date_stop);
                $messages['stoped'][$i]['ago_type'] = 'дней';
            }
            $messages['stoped'][$i]['type'] = 'event';
            $messages['stoped'][$i]['ago'] = $difference;
            $i++;
        }
        usort($messages['stoped'], function($a, $b) {
            if($a['for_sort'] > $b['for_sort']) {
                return 1;
            } else {
                return 0;
            }
        });
        $i = 0;
        $now3d = clone $now;
        $now3d->addDays(7);
        $messages['remain'] = [];
        
        foreach(Shop::where('date_stop', '>=', $now->toDateString())
                ->where('date_stop', '<=', $now3d->toDateString())
                ->get() as $shop) {
            $messages['remain'][$i]['title'] = $shop->title;
            $messages['remain'][$i]['id'] = $shop->id;
            $shop_date_stop = Carbon::createFromFormat('Y-m-d', $shop->date_stop);
            $difference = $now->diffInHours($shop_date_stop);
            $messages['remain'][$i]['ago_type'] = 'часов';
            $messages['remain'][$i]['for_sort'] = $difference;
            if($difference > 100) {
                $difference = $now->diffInDays($shop_date_stop);
                $messages['remain'][$i]['ago_type'] = 'дней';
            }
            $messages['remain'][$i]['type'] = 'shop';
            $messages['remain'][$i]['ago'] = $difference;
            $i++;
        }

        $counts['messages'] = $messages;

        return view('admin.index', $counts);
    }

}
