<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('transactionId');
            $table->integer('productId');
            $table->string('productName',150);
            $table->integer('variantId');
            $table->string('variantName',25);
            $table->double('price');
            $table->double('quantity')->default(1);
            $table->double('subtotal')->default(0);
            $table->double('diskon')->default(0);
            $table->double('total')->default(0);
            $table->string('created_by',50)->nullable();
            $table->string('updated_by',50)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('detail_transaction');
    }
};
