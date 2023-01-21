<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IPersonalAccessTokenService
{
    /**
     * @param string $token
     *
     * @return ServiceResponse
     */
    public function findToken(
        string $token
    ): ServiceResponse;
}
