<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserListResource;
use App\Repositories\Abstracts\UserRepository;
use App\Services\Contracts\UserService as UserService;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var UserService
     */
    protected $service;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * UsersController constructor.
     * @param UserRepository $repository
     * @param UserService $service
     */
    public function __construct(
        UserRepository $repository,
        UserService $service
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
