<?php

namespace App\Services;


use App\Models\Invoice;
use App\Repositories\Abstracts\InvoiceRepository;
use App\Repositories\Abstracts\SchoolRepository;
use App\Services\Contracts\InvoiceService as InvoiceServiceInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Services\Contracts\PaymentService;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService  extends BaseService implements InvoiceServiceInterface
{

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var InvoiceRepository
     */
    protected $repository;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * @var SchoolRepository
     */
    protected $schoolRepository;

    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * InvoiceService constructor.
     * @param DatabaseManager $databaseManager
     * @param InvoiceRepository $repository
     * @param Logger $logger
     * @param SchoolRepository $schoolRepository
     * @param Contracts\PaymentService $paymentService
     */
    public function __construct(
        DatabaseManager $databaseManager,
        InvoiceRepository $repository,
        Logger $logger,
        SchoolRepository $schoolRepository,
        PaymentService $paymentService
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->schoolRepository     = $schoolRepository;
        $this->logger     = $logger;
        $this->paymentService     = $paymentService;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     *
     * @return Invoice
     *
     * @throws
     */
    public function store(array $data)
    {

        $this->beginTransaction();

        try {
            /** @var Invoice $invoice */
            $invoice = $this->repository->newInstance();
            $school = $this->schoolRepository
                ->firstOrCreate(
                    ['name'=> Arr::get($data, 'school_name')]
                );
            $invoice->school_id = $school->id;
            $invoice->amount = Arr::get($data, 'amount', 0);
            $invoice->description = Arr::get($data, 'description', '');
            $invoice->link = Str::random(7);
            $invoice->invoice_number = rand(1111, 9999);
            $invoice->payer_id = Arr::get($data, 'user_id');
            $invoice->status = Invoice::STATUS_NEW;

            if (!$invoice->save()) {
                throw new \Exception('Invoice not created');
            }
            $this->paymentService->store([
                'user_id' => Arr::get($data, 'user_id'),
                'amount' => Arr::get($data, 'amount'),
                'invoice_id' => Arr::get($data, 'invoice_id'),
            ]);
          $this->logger->info('Invoice was successfully saved into database.');
        } catch (\Exception $e) {
            $this->rollback($e, $e->getMessage(), [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $invoice;
    }
}
