<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Abstracts\PaymentRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PaymentRepositoryEloquent
 * @package App\Repositories
 */
class PaymentRepositoryEloquent extends BaseRepository implements PaymentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payment::class;
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
