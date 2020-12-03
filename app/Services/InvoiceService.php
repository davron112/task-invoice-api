<?php

namespace App\Services;


use App\Models\Invoice;
use App\Repositories\Abstracts\InvoiceRepository;
use App\Repositories\Abstracts\SchoolRepository;
use App\Repositories\Abstracts\UserRepository;
use App\Services\Contracts\InvoiceService as InvoiceServiceInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * InvoiceService constructor.
     * @param DatabaseManager $databaseManager
     * @param InvoiceRepository $repository
     * @param Logger $logger
     * @param SchoolRepository $schoolRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        DatabaseManager $databaseManager,
        InvoiceRepository $repository,
        Logger $logger,
        SchoolRepository $schoolRepository,
        UserRepository $userRepository
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->userRepository     = $userRepository;
        $this->schoolRepository     = $schoolRepository;
        $this->logger     = $logger;
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
            $payer = $this->userRepository
                ->firstOrCreate(
                    [
                        'full_name'=> Arr::get($data, 'full_name'),
                        'email' => Str::limit(5) . '@gmail.com',
                        'password' => Hash::make('Password123'),
                    ]
                );
            $invoice->school_id = $school->id;
            $invoice->amount = $school->amount;
            $invoice->invoice_number = rand(1111, 9999);
            $invoice->status = Invoice::STATUS_NEW;
            $invoice->payer_id = $payer->id;

            if ($invoice->save()) {
                throw new \Exception('Invoice not created');
            }

          $this->logger->info('Invoice was successfully saved into database.');
        } catch (\Exception $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $invoice;
    }
}
