<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spl', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->string('jam_masuk');
            $table->string('jam_keluar');
            $table->text('pekerjaan');
            $table->string('tanggal');
            $table->string('penanggung_jawab');
            $table->string('pin');
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
        Schema::dropIfExists('spl');
    }

}
