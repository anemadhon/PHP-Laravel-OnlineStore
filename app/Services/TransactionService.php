<?php

namespace App\Services;

use Exception;
use App\Models\TransactionDetail;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Events\Transaction as EventsTransaction;

class TransactionService
{
    public function checkout(array $data)
    {
        DB::beginTransaction();

        try 
        {
            $transaction = auth()->user()->transactions()->create([
                'unique_number' => self::createUniqueNumber('STORE'),
                'status' => 'PENDING',
                'inscurance_price' => (int) $data['validated']['inscurance_price'],
                'shipping_price' => (int) $data['validated']['shipping_price'],
                'total_price' => (int) $data['validated']['total_price']
            ]);

            $dataCart = [];

            foreach ($data['carts'] as $index => $cart)
            {
                $dataCart[] = [
                    'awb_number' => self::createUniqueNumber('TRX-AWB-NUM'),
                    'shipping_status' => 'PENDING',
                    'purchase_price' => $cart->product->price,
                    'purchase_quantity' => $cart->purchase_quantity,
                    'unique_number' => self::createUniqueNumber('TRX-'.($index + 1)),
                    'transaction_id' => $transaction->id,
                    'product_id' => $cart->product->id,
                    'store_id' => $cart->product->store_id,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString()
                ];
            }

            TransactionDetail::insert($dataCart);

            event(new EventsTransaction($data['carts']));

            return (new MidtransService())->createTransaction([
                'order_id' => $transaction->unique_number,
                'gross_amount' => $data['validated']['total_price']
            ]);
        } 
        catch (Exception $error)
        {
            DB::rollback();

            return $error->getMessage();
        }
    }

    private static function createUniqueNumber(string $flag)
    {
        return $flag.'-'.mt_rand(0000,9999).'-'.time();
    }
}
