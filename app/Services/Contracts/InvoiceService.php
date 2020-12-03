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

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @param  array  $data
     */
    public function update($id, array $data);

    /**
     * Update block in the storage.
     *
     * @param  int  $id
     * @return array
     */
    public function delete($id);
}
