<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IEloquentService;

/**
 *
 */
interface IPermissionService extends IEloquentService{


    /**
     * @param string $name
     * @param int $paren_id
     * @return ServiceResponse
     */
    public function create(string $name,int $paren_id): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @param int $parent_id
     * @return ServiceResponse
     */
    public function update(int $id, string $name,int $parent_id): ServiceResponse;

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getRoles(int $id): ServiceResponse;

    /**
     * @param int $id
     * @param array $roles
     * @return ServiceResponse
     */
    public function syncRoles(int $id, array $roles): ServiceResponse;

    /**
     * @param int $id
     * @param int $roleId
     * @return ServiceResponse
     */
    public function attachRoles(int $id, int $roleId): ServiceResponse;

    /**
     * @param int $id
     * @param int $roleId
     * @return ServiceResponse
     */
    public function detachRoles(int $id, int $roleId): ServiceResponse;


    /**
     * @param int|null $id
     * @return ServiceResponse
     */
    public function getByParentId(?int $id = null): ServiceResponse;


}
