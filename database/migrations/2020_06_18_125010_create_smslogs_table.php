<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmslogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smslogs', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id");
            $table->integer("contact_id");
            $table->string("message");
            $table->float("cost", 5, 2)->nullable();
            $table->tinyInteger("status")->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('smslogs');
    }
}
