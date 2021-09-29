<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    public function test_user_can_checkout_transaction()
    {
        $user = User::factory()->create();

        $transaction = (new TransactionService())->checkout([
            'user_id' => $user->id,
            'validated' => [
                'inscurance_price' => 300000,
                'shipping_price' => 100000,
                'total_price' => 2500000
            ],
            'carts' => $user->carts->load('product')
        ]);

        $this->assertInstanceOf(Transaction::class, $transaction);
    }
}
