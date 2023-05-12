<?php

namespace App\Http\Controllers;

use App\Services\Account\AccountServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ResetController extends Controller
{
    protected $accountService;

    public function __construct(AccountServiceContract $accountServiceContract)
    {
        $this->accountService = $accountServiceContract;
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        try {
            DB::table('accounts')->truncate();
            DB::table('events')->truncate();

            return response('OK', 200)->header('Content-Type', 'text/plain');
        } catch (Exception $exception) {
            return response()->json(0, Response::HTTP_NOT_FOUND);
        }
    }
}
