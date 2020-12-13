<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id',50);
            $table->string('name');
            $table->integer('unit_price')->nullable();
            $table->integer('promotion_price')->nullable();
            $table->string('image');
            $table->text('description');
            $table->json('specifications');
            $table->integer('product_type_id');
            $table->integer('user_id');
            $table->string('publisher');
            $table->softDeletes();
            $table->primary('id');
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
        Schema::dropIfExists('products');
    }
}
