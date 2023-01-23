<?php

namespace App\Services\Eloquent;
use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IRoleService;
use App\Models\Eloquent\Role;


/**
 *
 */
class RoleService implements IRoleService
{

    /**
     * @param string $name
     * @return ServiceResponse
     */
    public function create(string $name): ServiceResponse
    {
        $role = new Role();
        $role->name = $name;
        $role->save();
        return new ServiceResponse(true, 'Role created successfully', 200, $role);
    }

    /**
     * @param int $id
     * @param string $name
     * @return ServiceResponse
     */
    public function update(int $id, string $name): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            $role->name = $name;
            $role->save();
            return new ServiceResponse(true, 'Role updated successfully', 200, $role);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getPermissions(int $id): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            return new ServiceResponse(true, 'Role permissions', 200, $role->permissions);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param array $permissions
     * @return ServiceResponse
     */
    public function syncPermissions(int $id, array $permissions): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            $role->permissions()->sync($permissions);
            return new ServiceResponse(true, 'Role permissions synced successfully', 200, $role->permissions);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param int $permissionId
     * @return ServiceResponse
     */
    public function attachPermissions(int $id, int $permissionId): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            $role->permissions()->attach($permissionId);
            return new ServiceResponse(true, 'Role permissions attached successfully', 200, $role->permissions);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @param int $permissionId
     * @return ServiceResponse
     */
    public function detachPermissions(int $id, int $permissionId): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            $role->permissions()->detach($permissionId);
            return new ServiceResponse(true, 'Role permissions detached successfully', 200, $role->permissions);
        } else {
            return new ServiceResponse(false, 'Role not found', null, 404);
        }
    }

    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse
    {
        $roles = Role::all();
        return new ServiceResponse(true, 'Role', 200, $roles);
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function getById(int $id): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            return new ServiceResponse(true, 'Role', 200, $role);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }

    /**
     * @param int $id
     * @return ServiceResponse
     */
    public function delete(int $id): ServiceResponse
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return new ServiceResponse(true, 'Role deleted successfully', 200, null);
        } else {
            return new ServiceResponse(false, 'Role not found', 404, null);
        }
    }
}
