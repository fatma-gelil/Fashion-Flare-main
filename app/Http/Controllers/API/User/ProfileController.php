<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileRequest;
use App\Models\Style;
use App\Repositories\AuthRepository;
use App\Traits\MediaTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                $user->load(['profile']);

                $styleNames = $user->styles()->pluck('name');

                $user->styles = $styleNames->toArray();
            }


            return response()->json([
                'status' => true,
                'message' => 'User data retrieved successfully',
                'data' => [
                    'user' => $user,
                ],
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ]);
        }
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
    public function create_style(Request $request)
    {
        try {
            $user = Auth::guard()->user();

            $styleData = $request->all();

            $style = Style::create($styleData);

            $user->styles()->attach($style->id);

            return ResponseTrait::responseSuccess($style,'Style created successfully for the user');

        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }
}
