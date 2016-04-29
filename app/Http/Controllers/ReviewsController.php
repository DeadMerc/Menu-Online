<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;

class ReviewsController extends Controller
{

    /**
     * @api {get} /reviews/:id getReview
     * @apiVersion 0.1.1
     * @apiName getReview
     * @apiGroup Reviews
     *
     * @apiParam {integer} [id]
     */
    public function index()
    {
        return $this->helpReturn(Review::all());
    }

    public function showAll()
    {
        $reviews = Review::all();
        return view('admin.reviews', array('reviews' => $reviews));
    }

    public function publish($id)
    {
        $reviews = Review::findorfail($id);
        $reviews->publish = 1;
        $reviews->save();
        return $this->helpInfo();
    }

    public function unpublish($id)
    {
        $reviews = Review::findorfail($id);
        $reviews->publish = 0;
        $reviews->save();
        return $this->helpInfo();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->helpReturn(Review::findorfail($id));
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
     * @api {post} /reviews storeReview
     * @apiVersion 0.1.0
     * @apiName storeReview
     * @apiGroup Reviews
     *
     * @apiParam {string} name
     * @apiParam {string} phone
     * @apiParam {string} rating
     * @apiParam {string} user_id
     * @apiParam {string} shop_id
     * @apiParam {string} review
     */
    public function store(Request $request)
    {
        $rules = array('name' => 'required', 'phone' => 'required', 'rating' => 'required',
            'user_id' => 'required', 'shop_id' => 'required', 'review' => 'required');
        $valid = Validator($request->all(), $rules);
        if (!$valid->fails()) {
            if (!Review::where('user_id', '=', $request->user_id)
                ->where('shop_id', '=', $request->shop_id)->first()
            ) {
                $review = new Review;
                $review->name = $request->name;
                $review->phone = $request->phone;
                $review->review = $request->review;
                $review->user_id = $request->user_id;
                $review->shop_id = $request->shop_id;
                $review->rating = $request->rating;
                $review->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('denied access for repeat store review');
            }
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = FALSE)
    {
        if ($id) {
            $data = array('item' => Review::findorfail($id));
        } else {
            $data = array('item' => '');
        }
        return view('admin.review', $data);
    }

    /**
     * @api {put} /reviews/:id storeReview
     * @apiVersion 0.1.0
     * @apiName storeReview
     * @apiGroup Reviews
     *
     * @apiParam {integr} id
     * @apiParam {string} name
     * @apiParam {string} phone
     * @apiParam {string} rating
     * @apiParam {string} user_id
     * @apiParam {string} shop_id
     * @apiParam {string} review
     */
    public function update(Request $request, $id = false)
    {
        $rules = array('name' => 'required', 'phone' => 'required', 'rating' => 'required',
            'user_id' => 'required', 'shop_id' => 'required', 'review' => 'required');
        $valid = Validator($request->all(), $rules);
        if (!$valid->fails()) {
            $review = Review::where('user_id', '=', $request->user_id)
                ->where('shop_id', '=', $request->shop_id)->first();
            $review_inDB = Review::findorfail($id);

            if (($review AND $review_inDB) AND $review->id === $review_inDB->id) {
                $review->name = $request->name;
                $review->phone = $request->phone;
                $review->review = $request->review;
                $review->user_id = $request->user_id;
                $review->shop_id = $request->shop_id;
                $review->rating = $request->rating;
                $review->save();
                return $this->helpInfo();
            } else {
                return $this->helpError('not found or shop_id and user_id not equal old params');
            }
        } else {
            return $this->helpError('valid', $valid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Review::findOrFail($id);
        $item->delete();
        return redirect('/admin/reviews');
    }

}
