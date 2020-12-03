<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\Abstracts\InvoiceRepository;
use App\Repositories\Abstracts\UserRepository;
use App\Services\Contracts\UserService as UserServiceInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService  extends BaseService implements UserServiceInterface
{

    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var UserRepository
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
     * UserService constructor.
     * @param DatabaseManager $databaseManager
     * @param UserRepository $repository
     * @param UserRepository $userRepository
     * @param InvoiceRepository $invoiceRepository
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager $databaseManager,
        UserRepository $repository,
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
     * @return User
     *
     * @throws
     */
    public function store(array $data)
    {

        $this->beginTransaction();

        try {
            /** @var User $user */
            $user = $this->repository->newInstance();
            /** @var User $user */

            $user->full_name = Arr::get($data, 'full_name');
            $user->email = Arr::get($data, 'email');
            $user->password = Hash::make(Arr::get($data, 'password'));

            if (!$user->save()) {
                throw new \Exception('User not created');
            }

          $this->logger->info('User was successfully saved into database.');
        } catch (\Exception $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $user;
    }
}
