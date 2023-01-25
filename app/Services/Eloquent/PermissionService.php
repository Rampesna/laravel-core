<?php

namespace App\Services\Eloquent;
use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IPermissionService;
use App\Models\Eloquent\Permission;


/**
 *
 */
class PermissionService implements IPermissionService {


    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
       $permissions = Permission::all();
       return new ServiceResponse(true, 'All permissions', 200, $permissions);
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getById(int $id): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            return new ServiceResponse(true, 'Permission found', 200, $permission);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function delete(int $id): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return new ServiceResponse(true, 'Permission deleted successfully', 200, null);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param string $name
     * @return ServiceResponse
     */
    public function create(string $name,int $parent_id): ServiceResponse
    {
        $permission = new Permission();
        $permission->name = $name;
        $permission->parent_id = $parent_id;

        $permission->save();
        return new ServiceResponse(true, 'Permission created successfully', 200, $permission);
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $parent_id
     * @return ServiceResponse
     */
    public function update(int $id, string $name,int $parent_id): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->name = $name;
            $permission->parent_id = $parent_id;

            $permission->save();
            return new ServiceResponse(true, 'Permission updated successfully', 200, $permission);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getRoles(int $id): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            return new ServiceResponse(true, 'Permission roles', 200, $permission->roles);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param array $roles
     * @return ServiceResponse
     */
    public function syncRoles(int $id, array $roles): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->roles()->sync($roles);
            return new ServiceResponse(true, 'Permission roles synced successfully', 200, $permission->roles);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param int $roleId
     * @return ServiceResponse
     */
    public function attachRoles(int $id, int $roleId): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->roles()->attach($roleId);
            return new ServiceResponse(true, 'Permission role attached successfully', 200, $permission->roles);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param int $roleId
     * @return ServiceResponse
     */
    public function detachRoles(int $id, int $roleId): ServiceResponse
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->roles()->detach($roleId);
            return new ServiceResponse(true, 'Permission role detached successfully', 200, $permission->roles);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getByParentId( ?int $id = null): ServiceResponse
    {
        $permission = Permission::where('top_id', $id)->get();
        if ($permission) {
            return new ServiceResponse(true, 'Permission found', 200, $permission);
        } else {
            return new ServiceResponse(false, 'Permission not found', 404, null);
        }
    }
}
