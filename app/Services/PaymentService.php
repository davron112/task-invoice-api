<?php

namespace App\Services;


use App\Models\Payment;
use App\Models\User;
use App\Repositories\Abstracts\InvoiceRepository;
use App\Repositories\Abstracts\PaymentRepository;
use App\Repositories\Abstracts\UserRepository;
use App\Services\Contracts\PaymentService as PaymentServiceInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;

/**
 * Class PaymentService
 * @package App\Services
 */
class PaymentService  extends BaseService implements PaymentServiceInterface
{

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var PaymentRepository
     */
    protected $repository;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * PaymentService constructor.
     * @param DatabaseManager $databaseManager
     * @param PaymentRepository $repository
     * @param UserRepository $userRepository
     * @param InvoiceRepository $invoiceRepository
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager $databaseManager,
        PaymentRepository $repository,
        UserRepository $userRepository,
        InvoiceRepository $invoiceRepository,
        Logger $logger
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->userRepository     = $userRepository;
        $this->invoiceRepository     = $invoiceRepository;
        $this->logger     = $logger;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     *
     * @return Payment
     *
     * @throws
     */
    public function store(array $data)
    {

        $this->beginTransaction();

        try {
            /** @var Payment $payment */
            $payment = $this->repository->newInstance();
            /** @var User $user */
            $user = $this->invoiceRepository->find(Arr::get($data, 'invoice_id'))->user;
            if ($user->full_name != Arr::get($data, 'full_name')) {
                $user->full_name = Arr::get($data, 'full_name');
                $user->save();
            }
            $payment->payer_id = $user->id;
            $payment->status = Payment::STATUS_PAYED;
            $payment->invoice_id = Arr::get($data, 'invoice_id');

            if ($payment->save()) {
                throw new \Exception(["type" => "error","message" => "cart is empty"]);
            }

          $this->logger->info('Payment was successfully saved into database.');
        } catch (\Exception $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $payment;
    }
}
