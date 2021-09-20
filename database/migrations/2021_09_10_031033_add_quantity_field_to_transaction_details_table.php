<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityFieldToTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->integer('purchase_quantity')->default(0)->nullable()->after('purchase_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('purchase_quantity');
        });
    }
}
