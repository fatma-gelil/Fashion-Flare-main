<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;

class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct(private AuthRepository $auth)
    {
      $this->auth = $auth;
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data=$this->auth->login($request->all());
            return $this->responseSuccess($data,'Logged in Successfully');

        }
        catch (\Exception $exception)
        {
           return $this->responseError([],$exception->getMessage());
        }

    }
}
