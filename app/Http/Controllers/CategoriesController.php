<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\City;
use App\Category_follow;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Cache;

class CategoriesController extends Controller {

    /**
     * @api {get} /categories/:id getCategories
     * @apiVersion 0.1.1
     * @apiName getCategories
     * @apiGroup Categories
     * 
     * @apiHeader {integer} [city_id]
     * @apiParam {integer} [id]
     */
    public function index() {
        return $this->helpReturn(Category::all());
    }

    public function showAll() {
        $shops = Category::all();
        
        return view('admin.categories', array('categories' => $shops,'categoriesList'=>  $this->getCategoriesForHtml()));
    }

    /**
     * @api {post} /categories/follow followCategory
     * @apiVersion 0.1.0
     * @apiName followCategory
     * @apiGroup Categories
     * 
     * @apiParam {integer} user_id
     * @apiParam {integer} category_id
     */
    public function follow(Request $request) {
        $rules = array('user_id' => 'required', 'category_id' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $follow = Category_follow::where('user_id', '=', $request->user_id)
                    ->where('category_id', '=', $request->category_id)
                    ->get();
            if($follow->isEmpty()) {
                $follow = new Category_follow;
                $follow->user_id = $request->user_id;
                $follow->category_id = $request->category_id;
                $follow->save();
            }
            return $this->helpInfo();
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * @api {post} /categories/unfollow unfollowCategory
     * @apiVersion 0.1.0
     * @apiName unfollowCategory
     * @apiGroup Categories
     * 
     * @apiParam {integer} user_id
     * @apiParam {integer} category_id
     */
    public function unfollow(Request $request) {
        $rules = array('user_id' => 'required', 'category_id' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $follow = Category_follow::where('user_id', '=', $request->user_id)
                    ->where('category_id', '=', $request->category_id)
                    ->delete();
            /*
              var_dump($follow);
              if(!$follow->isEmpty()){
              $follow->delete();
              } */
            return $this->helpInfo();
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * @api {get} /categories/:id/childrens getСhildrenCategories
     * @apiVersion 0.1.3
     * @apiName getСhildrenCategories
     * @apiGroup Categories
     * @apiDescription получить под категорий по родительской
     * 
     * @apiHeader {integer} [user_id]
     * @apiHeader {integer} [city_id]
     * @apiParam {integer} id
     */
    public function childrens(Request $request, $id) {
        $childrens = Category::findorfail($id)->childrens;
        if($request->header('user_id')) {
            foreach($childrens as $children) {
                $follow = Category_follow::where('user_id', '=', $request->header('user_id'))
                        ->where('category_id', '=', $children->id)
                        ->get();
                //var_dump($follow);
                if(!$follow->isEmpty()) {
                    $children->user_follow = true;
                } else {
                    $children->user_follow = false;
                }
            }
        }
        return $this->helpReturn($childrens);
    }

    /**
     * @api {get} /categories/:id/events getEventsByCategory
     * @apiVersion 0.1.0
     * @apiName getEventsByCategory
     * @apiGroup Events
     * 
     * @apiParam {integer} [id]
     */
    public function events($id) {
        $events = Category::findorfail($id)->events;
        return $this->helpReturn($events);
    }

    /**
     * @api {get} /categories/:id/shops getShopsByCategory
     * @apiVersion 0.1.0
     * @apiName getShopsByCategory
     * @apiGroup Shops
     * 
     * @apiHeader {integer} city_id
     * @apiParam {integer} id
     */
    public function shops(Request $request, $id) {
        $city_id = $request->header('city_id');
        if($city_id) {
            $shops = Category::findorfail($id)->shops->where('city_id', $city_id);
        } else {
            $shops = Category::findorfail($id)->shops;
        }
        
        return $this->helpReturn($shops);
    }

    public function show($id) {
        return $this->helpReturn(Category::findorfail($id));
    }

    public function edit($id = FALSE) {
        $parents = ['0' => 'With out parent (Main category)'];
        foreach(Category::all() as $category) {
            $parents[$category->id] = $category->name;
        }

        if($id) {
            $data = array('item' => Category::findorfail($id));
        } else {
            $data = array('item' => '');
        }
        $data['parents'] = $parents;
        return view('admin.category', $data);
    }

    /**
     * @api {post} /categories storeCategories
     * @apiVersion 0.1.0
     * @apiName storeCategories
     * @apiGroup Categories
     * 
     * @apiParam {integer} parent_id id Родительской категории
     * @apiParam {string} name
     * @apiParam {file} image
     */
    public function store(Request $request) {
        $rules = array('name' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $category = new Category;
            if(!$request->parent_id) {
                $request->parent_id = 0;
            }
            $category->parent_id = $request->parent_id;
            $category->name = $request->name;
            if($request->hasFile('image')) {
                $fileName = md5($category->title . date('d m Y') . $category->name) . '.jpg';
                $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                $category->image = $fileName;
            } else {
                $category->image = null;
            }
            $category->save();
            return $this->helpInfo();
        } else {
            return $this->helpError('Validator', $valid);
        }
    }

    /**
     * @api {put} /categories/:id updateCategories
     * @apiVersion 0.1.0
     * @apiName updateCategories
     * @apiGroup Categories
     * 
     * @apiParam {integer} parent_id id Родительской категории
     * @apiParam {string} name
     * @apiParam {file} image
     */
    public function update(Request $request, $id) {
        $rules = array('name' => 'required');
        $valid = Validator($request->all(), $rules);
        if(!$valid->fails()) {
            $category = Category::findorfail($id);
            if($category) {
                if(!$request->parent_id) {
                    $request->parent_id = 0;
                }
                $category->parent_id = $request->parent_id;
                $category->name = $request->name;
                if($request->hasFile('image')) {
                    $fileName = md5(rand(999, 9999) . date('d m Y') . $category->name) . '.jpg';
                    $request->file('image')->move(storage_path() . '/app/public/images', $fileName);
                    $category->image = $fileName;
                }
                $category->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('Not found resource');
            }
        } else {
            return $this->helpError('Validator', $valid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $item = Category::findorfail($id);
        $item->delete();
        return redirect('/admin/categories');
    }

}
