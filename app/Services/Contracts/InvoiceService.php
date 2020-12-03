<?php

namespace App\Services\Contracts;

/**
 * Interface InvoiceService
 * @package App\Services\Contracts
 */
interface InvoiceService extends BaseService
{

    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     */
    public function store(array $data);
}
