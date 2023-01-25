<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IEloquentService
{
    /**
     * @return ServiceResponse
     */
    public function getAll(): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function getById(
        int $id
    ): ServiceResponse;

    /**
     * @param int $id
     *
     * @return ServiceResponse
     */
    public function delete(
        int $id
    ): ServiceResponse;



}
