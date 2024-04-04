<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }
    public function show()
    {
        try {
           return  Auth::guard()->user();

        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);        }
    }
    public function logout(): JsonResponse
    {
        try {
            Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Logged Out Successfully!.',
                'data' => '',
                'errors' => null
            ]);


        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
    }
    public function update(ProfileRequest $request)
    {
        try {
            $user = Auth::guard()->user();

            $user->profile->fill($request->all())->save();
            return response()->json([
                'status' => true,
                'message' => 'User Profile updated successfully.',
                'data' => '',
                'errors' => null
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);        }
    }
}
