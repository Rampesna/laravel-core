<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IUserService;
use App\Models\Eloquent\User;
use App\Core\ServiceResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService implements IUserService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All users',
            200,
            User::all()
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse
    {
        $user = User::find($id);
        if ($user) {
            return new ServiceResponse(
                true,
                'User',
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @param string $email
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByEmail(
        string $email,
        int    $exceptId = null
    ): ServiceResponse
    {
        $user = User::where('email', $email)->when($exceptId, function ($user) use ($exceptId) {
            return $user->where('id', '!=', $exceptId);
        })->first();

        if ($user) {
            return new ServiceResponse(
                true,
                'User',
                200,
                $user
            );
        } else {
            return new ServiceResponse(
                false,
                'User not found',
                404,
                null
            );
        }
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function login(
        string $email,
        string $password
    ): ServiceResponse
    {
        $user = $this->getByEmail($email);
        if ($user->isSuccess()) {
            if (Hash::check($password, $user->getData()->password)) {
                $token = $user->getData()->createToken('userApiToken')->plainTextToken;
                return new ServiceResponse(
                    true,
                    'User logged in successfully',
                    200,
                    [
                        'token' => $token
                    ]
                );
            } else {
                return new ServiceResponse(
                    false,
                    'Incorrect password',
                    401,
                    null
                );
            }
        } else {
            return $user;
        }
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse
    {
        $user = $this->getById($id);
        if ($user->isSuccess()) {
            $user->getData()->delete();

            return new ServiceResponse(
                true,
                __('ServiceResponse/Eloquent/UserService.delete.success'),
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }
}
