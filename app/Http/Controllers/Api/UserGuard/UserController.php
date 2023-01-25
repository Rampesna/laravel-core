<?php

namespace App\Http\Controllers\Api\UserGuard;

use App\Core\Controller;
use App\Core\HttpResponse;
use App\Http\Requests\Api\UserGuard\UserController\AttachRoleRequest;
use App\Http\Requests\Api\UserGuard\UserController\DeleteRequest;
use App\Http\Requests\Api\UserGuard\UserController\DetachRoleRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetAllRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetByEmailRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetByIdRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetCompaniesRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetProfileRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetRolesRequest;
use App\Http\Requests\Api\UserGuard\UserController\GetSelectedCompanyRequest;
use App\Http\Requests\Api\UserGuard\UserController\LoginRequest;
use App\Http\Requests\Api\UserGuard\UserController\SetSelectedCompanyRequest;
use App\Http\Requests\Api\UserGuard\UserController\SyncRolesRequest;
use App\Interfaces\Eloquent\IUserService;

/**
 *
 */
class UserController extends Controller
{
    use HttpResponse;

    /**
     * @var $userService
     */
    private $userService;

    /**
     * @var IUserService $userService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $response = $this->userService->login(
            $request->email,
            $request->password
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetProfileRequest $request
     */
    public function getProfile(GetProfileRequest $request)
    {
        $response = $this->userService->getById(
            $request->user()->id
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
     */
    public function getAll(GetAllRequest $request)
    {
        $response = $this->userService->getAll();

        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetByIdRequest $request
     */
    public function getById(GetByIdRequest $request)
    {
        $response = $this->userService->getById(
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
     * @param GetByEmailRequest $request
     */
    public function getByEmail(GetByEmailRequest $request)
    {
        $response = $this->userService->getByEmail(
            $request->email,
            $request->exceptId
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
     */
    public function delete(DeleteRequest $request)
    {
        $response = $this->userService->delete(
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
     * @param GetCompaniesRequest $request
     */
    public function getCompanies(GetCompaniesRequest $request)
    {
        $response = $this->userService->getCompanies(
            $request->user()->id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param AttachRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachRole(AttachRoleRequest $request) {
        $response = $this->userService->attachRole(
            $request->user()->id,
            $request->roleId
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param DetachRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachRole(DetachRoleRequest $request) {
        $response = $this->userService->detachRole(
            $request->user()->id,
            $request->roleId
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param GetRolesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles(GetRolesRequest $request) {
        $response = $this->userService->getRoles(
            $request->user()->id
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }

    /**
     * @param SyncRolesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncRoles(SyncRolesRequest $request) {
        $response = $this->userService->syncRoles(
            $request->user()->id,
            $request->roleIds
        );
        return $this->httpResponse(
            $response->getMessage(),
            $response->getStatusCode(),
            $response->getData(),
            $response->isSuccess()
        );
    }


    /**
     * @param SetSelectedCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setSelectedCompanies(SetSelectedCompanyRequest $request) {
        $companies = $this->userService->getCompanies($request->user()->id);

        if ($companies->isSuccess()) {
            if (count($companies->getData()) == 0) {
                return $this->httpResponse(
                    'User has no access to any company',
                    403,
                    null,
                    false
                );
            }

            foreach ($request->companyIds as $companyId) {
                if (!in_array($companyId, $companies->getData()->pluck('id')->toArray())) {
                    return $this->httpResponse(
                        'User has no access to company with id ' . $companyId,
                        403,
                        null,
                        false
                    );
                }
            }

            $setSelectedCompaniesResponse = $this->userService->setSelectedCompanies(
                $request->user()->id,
                $request->companyIds
            );

            if ($setSelectedCompaniesResponse->isSuccess()) {
                return $this->httpResponse(
                    $setSelectedCompaniesResponse->getMessage(),
                    $setSelectedCompaniesResponse->getStatusCode(),
                    $setSelectedCompaniesResponse->getData(),
                    $setSelectedCompaniesResponse->isSuccess()
                );
            } else {
                return $this->httpResponse(
                    $setSelectedCompaniesResponse->getMessage(),
                    $setSelectedCompaniesResponse->getStatusCode(),
                    $setSelectedCompaniesResponse->getData(),
                    $setSelectedCompaniesResponse->isSuccess()
                );
            }
        }else {
            return $this->httpResponse(
                $companies->getMessage(),
                $companies->getStatusCode(),
                $companies->getData(),
                $companies->isSuccess()
            );
        }
    }

    /**
     * @param GetSelectedCompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSelectedCompanies(GetSelectedCompanyRequest $request)
    {
        $getSelectedCompaniesResponse = $this->userService->getSelectedCompanies(
            $request->user()->id
        );
        if ($getSelectedCompaniesResponse->isSuccess()) {
            return $this->httpResponse(
                $getSelectedCompaniesResponse->getMessage(),
                $getSelectedCompaniesResponse->getStatusCode(),
                $getSelectedCompaniesResponse->getData(),
                $getSelectedCompaniesResponse->isSuccess()
            );
        } else {
            return $this->httpResponse(
                $getSelectedCompaniesResponse->getMessage(),
                $getSelectedCompaniesResponse->getStatusCode(),
                $getSelectedCompaniesResponse->getData(),
                $getSelectedCompaniesResponse->isSuccess()
            );
        }
    }
}
