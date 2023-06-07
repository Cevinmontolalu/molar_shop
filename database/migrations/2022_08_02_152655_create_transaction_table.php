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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('code',5);
            $table->integer('customerId');
            $table->integer('addressId');
            $table->double('subtotal')->default(0);
            $table->double('quantity')->default(0);
            $table->double('diskon')->default(0);
            $table->double('total')->default(0);
            $table->enum('status',['New','On Process','Delivary','Cart','Canceled','Finish','Rejected'])->default('Cart');
            $table->text('transfer_prove')->nullable();
            $table->integer('rekeningId',3)->nullable();
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
        Schema::dropIfExists('transaction');
    }
};
