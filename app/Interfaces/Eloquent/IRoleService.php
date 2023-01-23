<?php
namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IEloquentService;

/**
 *
 */
interface IRoleService extends IEloquentService{

    /**
     * @param string $name
     * @return ServiceResponse
     */
    public function create(string $name): ServiceResponse;

    /**
     * @param int $id
     * @param string $name
     * @return ServiceResponse
     */
    public function update(int $id, string $name): ServiceResponse;

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getPermissions(int $id): ServiceResponse;

    /**
     * @param int $id
     * @param array $permissions
     * @return ServiceResponse
     */
    public function syncPermissions(int $id, array $permissions): ServiceResponse;

    /**
     * @param int $id
     * @param int $permissionId
     * @return ServiceResponse
     */
    public function attachPermissions(int $id, int $permissionId): ServiceResponse;

    /**
     * @param int $id
     * @param int $permissionId
     * @return ServiceResponse
     */
    public function detachPermissions(int $id, int $permissionId): ServiceResponse;
}
