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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');

            $table->boolean('is_active')->default(1);

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('admin_category_id')->nullable();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('admin_category_id')->references('id')->on('admin_categories');
            
            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};