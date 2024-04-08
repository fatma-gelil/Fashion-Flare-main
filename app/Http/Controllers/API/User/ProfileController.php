<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileRequest;
use App\Repositories\AuthRepository;
use App\Traits\MediaTrait;
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
            $user = Auth::user();

            if ($user) {
                $user->load('profile');
            }
            return  $user;
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
            $request->validated();
            $project = $request->except('user_img');
            if ($request->hasFile('user_img')) {
                $photoName = MediaTrait::upload($request->file('user_img'), 'profiles');
                $photoNamePath = asset('/uploads/' . $photoName);
                $project['user_img'] = $photoNamePath;
            }
            $data = $user->profile->fill($project)->save();
            return ResponseTrait::responseSuccess($data);
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }
}
