<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Services\Account\AccountServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
    public function show(Request $request)
    {
        try {
            $accountId = $request->has('account_id') ? $request->get('account_id') : null;

            return response()->json($this->accountService->getAccountBalanceByAccountId($accountId), Response::HTTP_OK);

            // test this better response
            // return (new AccountResource($this->accountService->getAccountByAccountId($accountId)))->response()->setStatusCode(Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(0, Response::HTTP_NOT_FOUND);

            // test this better response
            // return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return response()->json(0, Response::HTTP_NOT_FOUND);

            // test this better response
            // $errorCode = $exception->getCode() ? $exception->getCode() : Response::HTTP_NOT_FOUND;
            // return response()->json(['message' => $exception->getMessage()], $errorCode);
        }
    }
}
