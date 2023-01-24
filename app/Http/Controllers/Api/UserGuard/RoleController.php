<?php

namespace App\Http\Controllers\Api\UserGuard;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\UserGuard\RoleController\AttachPermissionRequest;
use App\Http\Requests\Api\UserGuard\RoleController\CreateRequest;
use App\Http\Requests\Api\UserGuard\RoleController\DeleteRequest;
use App\Http\Requests\Api\UserGuard\RoleController\DetachPermissionRequest;
use App\Http\Requests\Api\UserGuard\RoleController\GetAllRequest;
use App\Http\Requests\Api\UserGuard\RoleController\GetByIdRequest;
use App\Http\Requests\Api\UserGuard\RoleController\GetPermissionsRequest;
use App\Http\Requests\Api\UserGuard\RoleController\SyncPermissionsRequest;
use App\Http\Requests\Api\UserGuard\RoleController\UpdateRequest;
use App\Interfaces\Eloquent\IRoleService;

/**
 *
 */
class RoleController extends Controller
{
    use HttpResponse;

    /**
     * @var IRoleService
     */
    private $IRoleService;

    /**
     * @param IRoleService $IRoleService
     */
    public function __construct(IRoleService $IRoleService)
    {
        $this->IRoleService = $IRoleService;
    }


    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $response = $this->IRoleService->create(
            $request->name
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->IRoleService->update(
            $request->id,
            $request->name
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetPermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissions(GetPermissionsRequest $request)
    {
        $response = $this->IRoleService->getPermissions(
            $request->id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SyncPermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncPermissions(SyncPermissionsRequest $request)
    {
        $response = $this->IRoleService->syncPermissions(
            $request->role_id,
            $request->permission_id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param AttachPermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachPermission(AttachPermissionRequest $request){
        $response = $this->IRoleService->attachPermissions(
            $request->role_id,
            $request->permission_id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
     }

    /**
     * @param DetachPermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachPermission(DetachPermissionRequest $request){
        $response = $this->IRoleService->detachPermissions(
            $request->role_id,
            $request->permission_id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
     }

    /**
     * @param DeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteRequest $request){
        $response = $this->IRoleService->delete(
            $request->role_id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
     }

    /**
     * @param GetAllRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(GetAllRequest $request){
        $response = $this->IRoleService->getAll();
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
     }

    /**
     * @param GetByIdRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById(GetByIdRequest $request){
        $response = $this->IRoleService->getById(
            $request->role_id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
     }
}
