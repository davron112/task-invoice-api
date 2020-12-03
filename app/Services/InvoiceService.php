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

/**
 * @method bool destroy
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
                    ['full_name'=> Arr::get($data, 'full_name')]
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

    /**
     * Update invoice
     *
     * @param int $id
     * @param array $data
     * @return Category
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $this->beginTransaction();

        try {
            $invoice = $this->repository->find($id);
            // code here
            $this->logger->info('Invoice was successfully updated.');
        } catch (\Exception $e) {
            $this->rollback($e, 'An error occurred while updating an articles.', [
                'id'   => $id,
                'data' => $data,
            ]);

        }
        $this->commit();
        return $invoice;
    }
    /**
     * Delete block in the storage.
     *
     * @param  int  $id
     *
     * @return array
     *
     * @throws
     */
    public function delete($id)
    {

        $this->beginTransaction();

        try {
            $invoice = $this->repository->find($id);

            if (!$invoice->delete()) {
                throw new \Exception(
                    'Invoice was not deleted from database.'
                );
            }
            $this->logger->info('Invoice was successfully deleted from database.');
        } catch (\Exception $e) {
            $this->rollback($e, 'An error occurred while deleting an category.', [
                'id'   => $id,
            ]);
        }
        $this->commit();
        return [
            'type' => 'success',
            'message' => 'Invoice item successfully deleted',
            'data' => [
                'id' => $id
            ],
        ];
    }
}
