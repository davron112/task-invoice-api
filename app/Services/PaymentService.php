<?php

namespace App\Services;


use App\Models\Invoice;
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
            $user = User::find(Arr::get($data, 'user_id'));
            $payment->amount = Arr::get($data, 'amount');
            $payment->payer_id = $user->id;
            $payment->status = Payment::STATUS_UNPAID;
            $payment->invoice_id = Arr::get($data, 'invoice_id');

            if (!$payment->save()) {
                throw new \Exception('Payment not created');
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

    /**
     * @param array $data
     * @param $id
     * @return Payment
     * @throws \Exception
     */
    public function update(array $data, $id)
    {

        $this->beginTransaction();

        try {
            /** @var Payment $payment */
            $payment = $this->repository->find($id);
            /** @var User $user */
            $user = User::find($payment->payer_id);
            if ($user->full_name != Arr::get($data, 'full_name')) {
                $user->full_name = Arr::get($data, 'full_name');
                $user->save();
            }
            $payment->status = Payment::STATUS_PAYED;


            if (!$payment->save()) {
                throw new \Exception('Payment not updated');
            }

            $payment->invoice->status = Invoice::STATUS_COMPLETED;

            if (!$payment->invoice->save()) {
                throw new \Exception('Invoice status not updated');
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
