<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_active', function (Blueprint $table) {
            // $table->id();
            $table->increments('id');
            $table->string('uid',255);
            $table->string('ticket',255)->nullable();
            $table->string('nd',255)->nullable();
            $table->string('nd_number',255)->nullable();
            $table->string('ip_addr',255)->nullable();
            $table->string('framed_ip_address',255)->nullable();
            $table->string('onu_rx_pwr',255)->nullable();
            $table->string('package_name',255)->nullable();
            $table->string('quota_used',255)->nullable();
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
        Schema::dropIfExists('task_active');
    }
}
