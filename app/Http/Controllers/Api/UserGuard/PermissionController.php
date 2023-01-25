<?php

namespace App\Http\Controllers\Api\UserGuard;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\UserGuard\PermissionController\AttachRoleRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\CreateRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\DeleteRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\DetachRoleRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\GetAllRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\GetByIdRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\GetByParentIdRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\GetRolesRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\SyncRolesRequest;
use App\Http\Requests\Api\UserGuard\PermissionController\UpdateRequest;
use App\Interfaces\Eloquent\IPermissionService;

class PermissionController extends Controller
{
    use HttpResponse;

    private $IPermissionService;

    public function __construct(IPermissionService $IPermissionService)
    {
        $this->IPermissionService = $IPermissionService;
    }


    public function getAll(GetAllRequest $request)
    {
        $response = $this->IPermissionService->getAll();
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }


    public function getById(GetByIdRequest $request)
    {
        $response = $this->IPermissionService->getById($request->permissionId);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function create(CreateRequest $request)
    {
        $response = $this->IPermissionService->create($request->name, $request->parent_id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function update(UpdateRequest $request)
    {
        $response = $this->IPermissionService->update($request->id, $request->name, $request->parent_id);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function delete(DeleteRequest $request)
    {
        $response = $this->IPermissionService->delete($request->permissionId);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function getRoles(GetRolesRequest $request)
    {
        $response = $this->IPermissionService->getRoles($request->permissionId);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function attachRole(AttachRoleRequest $request)
    {
        $response = $this->IPermissionService->attachRoles($request->permissionId, $request->roleId);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function detachRole(DetachRoleRequest $request)
    {
        $response = $this->IPermissionService->detachRoles($request->permissionId, $request->roleId);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function syncRoles(SyncRolesRequest $request)
    {
        $response = $this->IPermissionService->syncRoles($request->permissionId, $request->roleIds);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    public function getByParentId(GetByParentIdRequest $request)
    {

        $response = $this->IPermissionService->getByParentId($request->parentId ?? null);
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }






}
