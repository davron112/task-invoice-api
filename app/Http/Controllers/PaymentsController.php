<?php
namespace App\Http\Controllers;

use App\Repositories\Abstracts\PaymentRepository;
use App\Services\Contracts\PaymentService as PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class PaymentsController
 * @package App\Http\Controllers
 */
class PaymentsController extends Controller
{
    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * @var PaymentRepository
     */
    protected $repository;

    /**
     * PaymentsController constructor.
     *
     * @param PaymentService $paymentService
     * @param PaymentRepository $repository
     */
    public function __construct(
        PaymentService $paymentService,
        PaymentRepository $repository
    ) {
        $this->paymentService = $paymentService;
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPayment(Request $request) {

        $data = $request->all();
        $payment = $this->paymentService
            ->update($data, Arr::get($data, 'id'));
        return response()->json($payment);
    }
}
