<?php

namespace App\Http\Controllers\Api\User;

use App\Core\Controller;
use App\Http\Requests\Api\User\UserController\LoginRequest;
use App\Http\Requests\Api\User\UserController\GetProfileRequest;
use App\Http\Requests\Api\User\UserController\GetAllRequest;
use App\Http\Requests\Api\User\UserController\GetByIdRequest;
use App\Http\Requests\Api\User\UserController\GetByEmailRequest;
use App\Http\Requests\Api\User\UserController\DeleteRequest;
use App\Interfaces\Eloquent\IUserService;
use App\Core\HttpResponse;

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
}
