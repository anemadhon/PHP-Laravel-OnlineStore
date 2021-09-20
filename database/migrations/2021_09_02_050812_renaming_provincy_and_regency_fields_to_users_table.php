<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamingProvincyAndRegencyFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('provincy_id', 'provincy');
            $table->renameColumn('regency_id', 'regency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('provincy', 'provincy_id');
            $table->renameColumn('regency', 'regency_id');
        });
    }
}
