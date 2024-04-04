<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());

            return response()->json([
                'status' => true,
                'message' => 'User registered successfully.',
                'data' => $data,
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
}
