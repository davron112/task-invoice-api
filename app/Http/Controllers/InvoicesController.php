<?php
namespace App\Http\Controllers;

use App\Http\Resources\InvoiceListResource;
use App\Mail\InvoiceSend;
use App\Repositories\Abstracts\InvoiceRepository;
use App\Services\Contracts\InvoiceService as InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

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

    /**
     * Get all invoices
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll() {
        $invoices = InvoiceListResource::collection($this->repository->all());
        return response()->json($invoices);
    }

    /**
     * Show detail by link
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        $invoice = $this->repository
            ->where('link', $request->link)
            ->first();
        return response()->json($invoice);
    }

    /**
     * Create a new invoice
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $data = $request->all();
        $invoice = $this->service
            ->store($data);
        return response()->json($invoice);
    }
}
