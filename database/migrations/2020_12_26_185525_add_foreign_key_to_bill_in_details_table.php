<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToBillInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_in_details', function (Blueprint $table) {
            $table->bigInteger('bill_in_id')->unsigned()->index()->change();
            $table->foreign('bill_in_id')->references('id')->on('bill_ins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_in_details', function (Blueprint $table) {
            $table->dropForeign('bill_in_details_bill_in_id_foreign');
        });
    }
}
