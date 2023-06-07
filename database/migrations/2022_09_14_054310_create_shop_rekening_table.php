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
        Schema::create('shop_rekening', function (Blueprint $table) {
            $table->id();
            $table->string('name',25);
            $table->string('nomor_rekening',50);
            $table->enum('status',['Aktif','Tidak Aktif'])->default('Tidak Aktif');
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
        Schema::dropIfExists('shop_rekening');
    }
};
