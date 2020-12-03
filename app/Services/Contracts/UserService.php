<?php

namespace App\Services\Contracts;

/**
 * Interface UserService
 * @package App\Services\Contracts
 */
interface UserService extends BaseService
{
    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     */
    public function store(array $data);
}
