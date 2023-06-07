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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('email',255)->unique();
            $table->string('name',150);
            $table->string('phone_no',25);
            $table->enum('gender',['Male','Female'])->default('Male');
            $table->text('profile_picture')->nullable();
            $table->date('dob')->nullable();
            $table->string('password',255);
            $table->enum('status',['Active','Not Active'])->default('Active');
            $table->string('created_by',50)->nullable();
            $table->string("updated_by",50)->nullable();
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
        Schema::dropIfExists('customer');
    }
};
