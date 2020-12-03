<?php
namespace App\Http\Controllers;

use App\Repositories\Abstracts\PaymentRepository;
use App\Services\PaymentService;
use Illuminate\Http\Request;

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

    public function getAll() {
        $invoices = $this->repository->all();
        return response()->json($invoices);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPayment(Request $request) {

        $data = $request->all();
        $payment = $this->paymentService->store($data);
        return response()->json($payment);
    }
}
