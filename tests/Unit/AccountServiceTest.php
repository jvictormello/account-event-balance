<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\Account;
use App\Services\Account\AccountService;
use App\Repositories\Account\AccountRepositoryEloquentContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountServiceTest extends TestCase
{
    protected $accountService;
    protected $accountRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountRepository = Mockery::mock(AccountRepositoryEloquentContract::class);
        $this->accountService = new AccountService($this->accountRepository);
    }

    /** @test */
    public function it_can_deposit_to_a_new_account()
    {
        $this->accountRepository
            ->shouldReceive('getById')
            ->once()
            ->with(100)
            ->andReturn(null);

        $this->accountRepository
            ->shouldReceive('store')
            ->once()
            ->with(['id' => 100, 'balance' => 10])
            ->andReturn(new Account(['id' => 100, 'balance' => 10]));

        $result = $this->accountService->deposit([
            'destination' => 100,
            'amount' => 10
        ]);

        $this->assertEquals(10, $result['destination']['balance']);
    }

    /** @test */
    public function it_can_withdraw_from_an_existing_account()
    {
        $this->accountRepository
            ->shouldReceive('getById')
            ->once()
            ->with(100)
            ->andReturn(new Account(['id' => 100, 'balance' => 20]));

        $this->accountRepository
            ->shouldReceive('store') // Garantindo que o saldo é atualizado
            ->once()
            ->with(['id' => 100, 'balance' => 15]);

        $result = $this->accountService->withdraw([
            'origin' => 100,
            'amount' => 5
        ]);

        $this->assertEquals(15, $result['origin']['balance']);
    }

    /** @test */
    public function it_cannot_withdraw_with_insufficient_balance()
    {
        $this->accountRepository
            ->shouldReceive('getById')
            ->once()
            ->with(100)
            ->andReturn(new Account(['id' => 100, 'balance' => 5]));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insufficient balance.');

        $this->accountService->withdraw([
            'origin' => 100,
            'amount' => 10
        ]);
    }
}
