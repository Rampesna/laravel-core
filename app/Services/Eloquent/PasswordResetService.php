<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IPasswordResetService;
use App\Models\Eloquent\PasswordReset;
use App\Core\ServiceResponse;
use Illuminate\Support\Str;

class PasswordResetService implements IPasswordResetService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        return new ServiceResponse(
            true,
            'All password resets',
            200,
            PasswordReset::all()
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
        $passwordReset = PasswordReset::find($id);
        if ($passwordReset) {
            return new ServiceResponse(
                true,
                'Password reset',
                200,
                $passwordReset
            );
        } else {
            return new ServiceResponse(
                false,
                'Password reset not found',
                404,
                null
            );
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
        $passwordReset = $this->getById($id);
        if ($passwordReset->isSuccess()) {
            return new ServiceResponse(
                true,
                'Password reset deleted',
                200,
                $passwordReset->getData()->delete()
            );
        } else {
            return $passwordReset;
        }
    }

    /**
     * @param string $token
     *
     * @return ServiceResponse
     */
    public function getByToken(
        string $token
    ): ServiceResponse
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if ($passwordReset) {
            return new ServiceResponse(
                true,
                'Password reset',
                200,
                $passwordReset
            );
        } else {
            return new ServiceResponse(
                false,
                'Password reset not found',
                404,
                null
            );
        }
    }

    /**
     * @param string $relationType
     * @param int $relationId
     * @param string $datetime
     *
     * @return ServiceResponse
     */
    public function checkPasswordReset(
        string $relationType,
        int    $relationId,
        string $datetime
    ): ServiceResponse
    {
        $passwordReset = PasswordReset::where('relation_type', $relationType)
            ->where('relation_id', $relationId)
            ->where('created_at', '>', $datetime)
            ->where('used', 0)
            ->exists();
        if ($passwordReset) {
            return new ServiceResponse(
                true,
                'Password reset',
                200,
                true
            );
        } else {
            return new ServiceResponse(
                false,
                'Password reset not found',
                404,
                false
            );
        }
    }

    /**
     * @param string $relationType
     * @param int $relationId
     *
     * @return ServiceResponse
     */
    public function create(
        string $relationType,
        int    $relationId
    ): ServiceResponse
    {
        $passwordReset = new PasswordReset;
        $passwordReset->relation_type = $relationType;
        $passwordReset->relation_id = $relationId;
        $passwordReset->token = Str::random(32);
        $passwordReset->save();

        return new ServiceResponse(
            true,
            'Password reset created',
            201,
            $passwordReset
        );
    }

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function setUsed(
        int $id
    ): ServiceResponse
    {
        $passwordReset = $this->getById($id);
        if ($passwordReset->isSuccess()) {
            $passwordReset->getData()->used = 1;
            $passwordReset->getData()->save();

            return new ServiceResponse(
                true,
                'Password reset used',
                200,
                $passwordReset->getData()
            );
        } else {
            return $passwordReset;
        }
    }
}
