<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Services\Account\AccountServiceContract;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountServiceContract $accountServiceContract)
    {
        $this->accountService = $accountServiceContract;
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountRequest $request): JsonResponse
    {
        $accountId = $request->validated()['account_id'];

        $balance = $this->accountService->getAccountBalanceByAccountId($accountId);

        return response()->json($balance, Response::HTTP_OK);
    }
}
