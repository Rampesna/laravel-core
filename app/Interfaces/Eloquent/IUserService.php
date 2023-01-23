<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

/**
 *
 */
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

    /**
     * @param int $userId
     *
     * @return ServiceResponse
     */
    public function getCompanies(
        int $userId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param array $roleId
     * @return ServiceResponse
     */
    public function attachRole(
        int $userId,
        int $roleId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param array $roleId
     * @return ServiceResponse
     */
    public function detachRole(
        int $userId,
        int $roleId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @return ServiceResponse
     */
    public function getRoles(
        int $userId
    ): ServiceResponse;

    /**
     * @param int $userId
     * @param array $roleId
     * @return ServiceResponse
     */
    public function syncRoles(
        int $userId,
        array $roleId
    ): ServiceResponse;










}
