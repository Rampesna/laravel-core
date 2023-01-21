<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IPasswordResetService extends IEloquentService
{
    /**
     * @param string $token
     *
     * @return ServiceResponse
     */
    public function getByToken(
        string $token
    ): ServiceResponse;

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
    ): ServiceResponse;

    /**
     * @param string $relationType
     * @param int $relationId
     *
     * @return ServiceResponse
     */
    public function create(
        string $relationType,
        int    $relationId
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function setUsed(
        int $id
    ): ServiceResponse;
}
