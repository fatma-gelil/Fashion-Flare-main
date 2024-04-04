<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository
{
    public function login(array $data): array
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception("Sorry, user does not exist.", 404);
        }


        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", 401);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }

    public function register(array $data): array
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", 500);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }
    public function updateProfile(array $data): array
    {

        $user = User::create($this->prepareDataForProfile($data));

        $profile = $user->profile;

        $profile->update([
            'full_name' => $data['full_name'],
            'nickname' => $data['nickname'],
            'phone_number' => $data['phone_number'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'address' => $data['address'],
            'height' => $data['height'],
            'width' => $data['width'],
            'shoulder' => $data['shoulder'],
            'chest' => $data['chest'],
            'waist' => $data['waist'],
            'hips' => $data['hips'],
            'thigh' => $data['thigh'],
            'inseam' => $data['inseam'],
        ]);

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", 500);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('authToken');
    }

    public function getAuthData(User $user, PersonalAccessTokenResult $tokenInstance): array
    {
        return [
            'user' => $user,
            'access_token' => $tokenInstance->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString()
        ];
    }
    public function prepareDataForProfile(array $data): array
    {
        return [
            'full_name' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }
    public function prepareDataForRegister(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }
}
