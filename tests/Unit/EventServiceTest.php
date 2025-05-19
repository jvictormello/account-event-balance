<?php

namespace Tests\Unit;

use App\Services\Event\EventService;
use Tests\TestCase;
use Mockery;
use App\Models\Account;
use App\Services\Account\AccountService;
use App\Repositories\Account\AccountRepositoryEloquentContract;
use Exception;

class EventServiceTest extends TestCase
{
    protected $eventService;
    protected $accountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = Mockery::mock(AccountRepositoryEloquentContract::class);
        $accountService = new AccountService($this->accountRepository);
        $this->eventService = new EventService($accountService);
    }

    /** @test */
    public function it_can_process_a_deposit_event()
    {
        $this->accountRepository
            ->shouldReceive('getById')
            ->once()
            ->with(100)
            ->andReturn(null);

        $this->accountRepository
            ->shouldReceive('store')
            ->once()
            ->with(['id' => 100, 'balance' => 50])
            ->andReturn(new Account(['id' => 100, 'balance' => 50]));

        $result = $this->eventService->executeEvent([
            'type' => 'deposit',
            'destination' => 100,
            'amount' => 50
        ]);

        $this->assertEquals(50, $result['destination']['balance']);
    }

    /** @test */
    public function it_cannot_transfer_with_insufficient_balance()
    {
        $this->accountRepository
            ->shouldReceive('getById')
            ->with(100)
            ->andReturn(new Account(['id' => 100, 'balance' => 10]));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insufficient balance.');

        $this->eventService->executeEvent([
            'type' => 'transfer',
            'origin' => 100,
            'destination' => 200,
            'amount' => 20
        ]);
    }
}
