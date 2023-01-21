<?php

namespace App\Services\Eloquent;

use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use App\Core\ServiceResponse;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenService implements IPersonalAccessTokenService
{
    /**
     * @param string $token
     *
     * @return ServiceResponse
     */
    public function findToken(
        string $token
    ): ServiceResponse
    {

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ($personalAccessToken) {
            return new ServiceResponse(
                true,
                'Personal access token',
                200,
                $personalAccessToken
            );
        } else {
            return new ServiceResponse(
                false,
                'Personal access token not found',
                404,
                null
            );
        }
    }
}
