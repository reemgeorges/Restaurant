<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Menu;
use App\Models\MenuOrder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use PhpParser\Node\Stmt\Return_;

class OrderController extends Controller
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
    public function addAllOrder(Request $request)
    {
        // Check if the user is logged in
        $user = auth('sanctum')->user();
        // dd($user);

        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'menu_items' => ['required', 'array'],
            'menu_items.*.menu_uuid' => ['required', 'string', 'exists:menus,uuid'],
            'menu_items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Create a new order
            $order = new Order();
            $order->uuid = Str::uuid();
            $order->user()->associate($user)->save();

            // Loop through each menu item in the request and add it to the order
            foreach ($request->input('menu_items') as $menuItem) {
                $menu = Menu::where('uuid', $menuItem['menu_uuid'])->firstOrFail();

                // Create a record in the pivot table linking the menu and the order
                MenuOrder::create([
                    'menu_id' => $menu->id,
                    'order_id' => $order->id,
                    'quantity' => $menuItem['quantity'],
                ]);
            }

            $data['order'] = new OrderResource($order);

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    public function addoneOrder(Request $request)
    {
        // Check if the user is logged in
        $user = auth('sanctum')->user();
        // dd($user);

        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'menu_uuid' => ['required', 'string', 'exists:menus,uuid'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Create a new order
            $order = new Order();
            $order->uuid = Str::uuid();
            $order->user()->associate($user)->save();


                $menu = Menu::where('uuid', $request->menu_uuid)->firstOrFail();

                // Create a record in the pivot table linking the menu and the order
                MenuOrder::create([
                    'menu_id' => $menu->id,
                    'order_id' => $order->id,
                    'quantity' => $request->quantity,
                ]);


            $data['order'] = new OrderResource($order);

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateAllOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_items' => ['required', 'array'],
            'menu_items.*.menu_uuid' => ['required', 'string', 'exists:menus,uuid'],
            'menu_items.*.quantity' => ['required', 'integer', 'min:1'],
            'UuidOrder' => ['required','string']
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
        try {
            // Find the order using the UUID sent in the request
            $order = Order::where('uuid', $request->input('UuidOrder'))->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found.');
            }

            // Delete all records in  menu-order
            $order->menuOrders()->delete();

            // Loop through each menu item in the request and add it to the order
            foreach ($request->input('menu_items') as $menuItem) {
                $menu = Menu::where('uuid', $menuItem['menu_uuid'])->firstOrFail();

                // Create a new record in the pivot table linking the menu and the order
                MenuOrder::create([
                    'menu_id' => $menu->id,
                    'order_id' => $order->id,
                    'quantity' => $menuItem['quantity'],
                ]);
            }
            $data['order'] = new OrderResource($order);

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    public function updateOneOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_uuid' => ['required', 'string', 'exists:menus,uuid'],
            'quantity' => ['required', 'integer', 'min:1'],
            'UuidOrder' => ['required','string']
        ]);

        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }
        try {
            // Find the order using the UUID sent in the request
            $order = Order::where('uuid', $request->input('UuidOrder'))->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found.');
            }

            // Delete all records in  menu-order
            $order->menuOrders()->delete();

                $menu = Menu::where('uuid',$request->menu_uuid)->firstOrFail();

                // Create a new record in the pivot table linking the menu and the order
                MenuOrder::create([
                    'menu_id' => $menu->id,
                    'order_id' => $order->id,
                    'quantity' => $request->quantity,
                ]);

            $data['order'] = new OrderResource($order);

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Request $request)
    {
        try {
            // Find the order using the UUID sent in the request
            $order = Order::where('uuid', $request->input('order_uuid'))->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found.');
            }

            // Delete all records linking the order and menu items in the pivot table
            $order->menuOrders()->delete();

            // delete the order
            $order->delete();

            return $this->apiResponse([], true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }



    public function deliverOrder(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            // Find the order by UUID
            $order = Order::where('uuid', $request->UuidOrder)->first();

            if (!$order) {
                return $this->notFoundResponse('Order not found.');
            }

            // Check if the order belongs to the authenticated user
            if ($order->user_id !== $user->id) {
                return $this->notFoundResponse('You are not allowed to update this order.');
            }

            // Update the order status to 1 (delivered)
            $order->update(['status' => 1]);

            $data['order'] = new OrderResource($order);

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


}
