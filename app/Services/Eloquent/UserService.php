<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IUserService;
use App\Models\Eloquent\User;
use App\Core\ServiceResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 *
 */
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

    /**
     * @param int $userId
     * @return ServiceResponse
     */
    public function getCompanies(int $userId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                'User companies',
                200,
                $user->getData()->companies
            );
        } else {
            return $user;
        }
    }


    /**
     * @param int $userId
     * @param int $roleId
     * @return ServiceResponse
     */
    public function attachRole(int $userId, int $roleId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->roles()->attach($roleId);
            return new ServiceResponse(
                true,
                'Role attached to user',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param int $roleId
     * @return ServiceResponse
     */
    public function detachRole(int $userId, int $roleId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->roles()->detach($roleId);
            return new ServiceResponse(
                true,
                'Role detached from user',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @return ServiceResponse
     */
    public function getRoles(int $userId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                'User roles',
                200,
                $user->getData()->roles
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param array $roleId
     * @return ServiceResponse
     */
    public function syncRoles(int $userId, array $roleId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->roles()->sync($roleId);
            return new ServiceResponse(
                true,
                'User roles synced',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @param array $companyIds
     * @return ServiceResponse
     */
    public function setSelectedCompanies(int $userId, array $companyIds): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            $user->getData()->selectedCompanies()->sync($companyIds);
            return new ServiceResponse(
                true,
                'User selected company synced',
                200,
                $user->getData()
            );
        } else {
            return $user;
        }
    }

    /**
     * @param int $userId
     * @return ServiceResponse
     */
    public function getSelectedCompanies(int $userId): ServiceResponse
    {
        $user = $this->getById($userId);
        if ($user->isSuccess()) {
            return new ServiceResponse(
                true,
                'User selected companies',
                200,
                $user->getData()->selectedCompanies
            );
        } else {
            return $user;
        }
    }
}
