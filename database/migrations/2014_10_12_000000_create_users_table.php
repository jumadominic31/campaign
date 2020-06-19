<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('username')->unique();
            $table->integer('customer_id');
            $table->string('title')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique()->nullable();
            $table->integer('usertype_id');
            $table->tinyInteger('status');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
