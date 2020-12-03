<?php
namespace App\Http\Controllers;

use App\Repositories\Abstracts\InvoiceRepository;
use App\Services\Contracts\InvoiceService as InvoiceService;
use Illuminate\Http\Request;

/**
 * Class InvoicesController
 * @package App\Http\Controllers
 */
class InvoicesController extends Controller
{
    /**
     * @var InvoiceService
     */
    protected $service;

    /**
     * @var InvoiceRepository
     */
    protected $repository;

    /**
     * InvoicesController constructor.
     * @param InvoiceRepository $repository
     * @param InvoiceService $service
     */
    public function __construct(
        InvoiceRepository $repository,
        InvoiceService $service
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function getAll() {
        $invoices = $this->repository->all();
        return response()->json($invoices);
    }

    /**
     * @param Request $request
     */
    public function create(Request $request) {
        $data = $request->all();
        $invoice = $this->service->store($data);
        return response()->json($invoice);
    }
}
