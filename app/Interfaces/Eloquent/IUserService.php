<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IUserService extends IEloquentService
{
    /**
     * @param string $email
     * @param int|null $exceptId
     *
     * @return ServiceResponse
     */
    public function getByEmail(
        string $email,
        int    $exceptId = null
    ): ServiceResponse;

    /**
     * @param string $email
     * @param string $password
     *
     * @return ServiceResponse
     */
    public function login(
        string $email,
        string $password
    ): ServiceResponse;
}
