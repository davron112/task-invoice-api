<?php

namespace App\Services\Contracts;

/**
 * Interface PaymentService
 * @package App\Services\Contracts
 */
interface PaymentService extends BaseService
{
    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     */
    public function store(array $data);
}
