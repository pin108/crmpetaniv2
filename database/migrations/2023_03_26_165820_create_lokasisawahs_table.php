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
        Schema::create('lokasisawahs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('iot_id')->nullable();
            $table->float('lokasisawah_latitude')->nullable();
            $table->float('lokasisawah_longitude')->nullable();
            $table->bigInteger('kabupaten_id');
            $table->string('lokasisawah_keterangan')->nullable();
            $table->integer('lokasisawah_status')->nullable();
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
        Schema::dropIfExists('lokasisawahs');
    }
};
