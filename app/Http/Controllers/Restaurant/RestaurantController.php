<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuRestaurantResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Display a listing of all restaurants along with their ratings.
    public function showAllRestaurant()
    {
        try{
            $restaurants=Restaurant::all();
            if(!$restaurants){
                return  $this->notFoundResponse('No restaurants found');
            }
            $data['restaurants']= RestaurantResource::collection($restaurants);
            return $this->apiResponse($data,true,null,200);

        }catch(\Exception $ex){
            return $this->apiResponse(null,false,$ex->getMessage(),500);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function showٌRestaurantWithMenu($UuidRestaurant)
    {
        try {
            $restaurant = Restaurant::with('menus.item.type')->where('uuid',$UuidRestaurant)->first();

            if (!$restaurant) {
                return $this->notFoundResponse('Restaurant not found');
            }

            $data['restaurant']= new MenuRestaurantResource($restaurant);
            return $this->apiResponse($data,true,null,200);

        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
    public function search(Request $request)
    {
        try {
            $address = $request->input('address');
            $cuisineType = $request->input('cuisine_type');

            $query = Restaurant::query();

            if ($address) {
                $query->where('address', 'like',  $address );
            }

            if ($cuisineType) {
                $query->where('address', $cuisineType);
            }

            $restaurants = $query->get();

            if ($restaurants->isEmpty()) {
                $data['message'] = 'No restaurants found';
                return $this->apiResponse($data, true, null, 200);
            }

            $data['restaurant'] = RestaurantResource::collection($restaurants);
            return $this->apiResponse($data, true, null, 200);

        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }



}
