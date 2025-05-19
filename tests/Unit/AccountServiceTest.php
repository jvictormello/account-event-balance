<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Account;
use App\Services\Account\AccountService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $accountService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountService = app(AccountService::class);
    }

    /** @test */
    public function it_can_deposit_to_a_new_account()
    {
        $response = $this->accountService->deposit([
            'destination' => 100,
            'amount' => 20
        ]);

        $this->assertEquals('100', $response['destination']['id']);
        $this->assertEquals(20, $response['destination']['balance']);

        $this->assertDatabaseHas('accounts', [
            'id' => 100,
            'balance' => 20
        ]);
    }

    /** @test */
    public function it_can_withdraw_from_an_existing_account()
    {
        Account::create(['id' => 100, 'balance' => 20]);

        $response = $this->accountService->withdraw([
            'origin' => 100,
            'amount' => 5
        ]);

        $this->assertEquals('100', $response['origin']['id']);
        $this->assertEquals(15, $response['origin']['balance']);

        $this->assertDatabaseHas('accounts', [
            'id' => 100,
            'balance' => 15
        ]);
    }

    /** @test */
    public function it_cannot_withdraw_with_insufficient_balance()
    {
        Account::create(['id' => 100, 'balance' => 10]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insufficient balance.');

        $this->accountService->withdraw([
            'origin' => 100,
            'amount' => 20
        ]);
    }

    /** @test */
    public function it_can_transfer_between_accounts()
    {
        Account::create(['id' => 100, 'balance' => 20]);

        $response = $this->accountService->transfer([
            'origin' => 100,
            'destination' => 200,
            'amount' => 10
        ]);

        $this->assertEquals('100', $response['origin']['id']);
        $this->assertEquals(10, $response['origin']['balance']);
        $this->assertEquals('200', $response['destination']['id']);
        $this->assertEquals(10, $response['destination']['balance']);

        $this->assertDatabaseHas('accounts', [
            'id' => 100,
            'balance' => 10
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => 200,
            'balance' => 10
        ]);
    }
}
