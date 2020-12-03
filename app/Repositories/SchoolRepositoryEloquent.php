<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\School;
use App\Repositories\Abstracts\InvoiceRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SchoolRepositoryEloquent
 * @package App\Repositories
 */
class SchoolRepositoryEloquent extends BaseRepository implements InvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return School::class;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
