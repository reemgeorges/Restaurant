<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;

class AuthController extends Controller
{
    use GeneralTrait;
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:8',
            'phone' => 'required|min:10|unique:users',
        ]);

        // Check if validation fails and return errors if any
        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Create a new user using the request data
            $user = User::create([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'uuid' => Str::uuid(),
            ]);

            // Generate a token for the user
            $data['user'] = new UserResource($user);

            return $this->apiResponse($data, true, NULL , 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }


    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10',
            'password' => 'required|min:8',
        ]);

        // Check if validation fails and return errors if any
        if ($validator->fails()) {
            return $this->requiredField($validator->errors()->first());
        }

        try {
            // Attempt to find the user by phone number
            $user = User::where('phone', $request->input('phone'))->first();

               // Verify the phone
            if (!$user) {
                return $this->apiResponse(null, false, 'Invalid phone number .', 401);
            }

            // Verify the password
            if (!Hash::check($request->input('password'), $user->password)) {
                return $this->apiResponse(null, false, 'Invalid phone password.', 401);
            }

            // Generate a token for the user
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('MyApp')->plainTextToken;

            return $this->apiResponse($data, true, null, 200);
        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = auth('sanctum')->user();

            if ($user) {
                $user->tokens()->delete();
                return $this->apiResponse([], true, null, 200);
            }else {
                return $this->unAuthorizeResponse();
            }

        } catch (\Exception $ex) {
            return $this->apiResponse(null, false, $ex->getMessage(), 500);
        }
    }
}



