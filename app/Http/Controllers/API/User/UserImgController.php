<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClothesRequest;
use App\Models\UserImg;
use App\Traits\MediaTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserImgController extends Controller
{

    public function upload(ClothesRequest $request)
    {
        try {
            $user = Auth::guard()->user();
            $request->validated();
            $project=$request->except('img');
            if ($request->hasFile('img')) {
                $photoName = MediaTrait::upload($request->file('img'), 'clothes');
                $photoNamePath = asset('/uploads/' . $photoName);
            }
            $project['img'] = $photoNamePath;
            $data = UserImg::create([
               'user_id'=>$user->id,
               'img'=>$photoNamePath
           ]);
            return ResponseTrait::responseSuccess($data);
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }

    }
    public function destroy($id)
    {
        try {
            $userImg = UserImg::findOrFail($id);
            $photoNamePath = asset('uploads/' . $userImg);
            if ($userImg->img) {
                MediaTrait::delete($userImg->img);
                $userImg->delete();
            }

            return ResponseTrait::responseSuccess([], 'Image deleted successfully.');
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception);
        }
    }
}
