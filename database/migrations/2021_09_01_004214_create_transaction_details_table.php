<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('awb_number')->unique();
            $table->string('shipping_status');
            $table->integer('purchase_price');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
