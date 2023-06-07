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
        Schema::create('shop_profile', function (Blueprint $table) {
            $table->id();
            $table->string('name',30);
            $table->string('email',150);
            $table->string('phone_no',25)->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->text('address');
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
        Schema::dropIfExists('shop_profile');
    }
};
