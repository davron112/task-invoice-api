<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\Abstracts\InvoiceRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class InvoiceRepositoryEloquent
 * @package App\Repositories
 */
class InvoiceRepositoryEloquent extends BaseRepository implements InvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Invoice::class;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
