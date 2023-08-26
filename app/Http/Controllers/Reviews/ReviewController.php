<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
         $request['user_id']=auth('sanctum')->id();
         $validator = Validator::make($request->all(), [
             'restaurant_uuid' => ['required', 'string', 'exists:restaurants,uuid'],
             'comment' => ['required', 'string'],
             'star' => ['required', 'integer','min:0','max:5'],
         ]);

         if ($validator->fails()) {
             return $this->requiredField($validator->errors()->first());
         }

         try {
            $restaurant=Restaurant::where('uuid',$request->restaurant_uuid)->first();
            if(!$restaurant){
                return $this->notFoundResponse('not found restaurant');
            }

             $review = Review::create([
                'uuid'=> Str::uuid(),
                'user_id'=> $request->user_id,
                'restaurant_id'=>$restaurant->id,
                'star'=>$request->star,
                'comment'=>$request->comment
                         ]);
                $data['review']= new ReviewResource($review);

             return $this->apiResponse($data,true,null,200);
         } catch (\Exception $ex) {
            return $this->apiResponse(null,false,$ex->getMessage(),500);
         }
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
