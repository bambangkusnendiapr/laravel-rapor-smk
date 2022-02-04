<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporPrestasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_prestasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rapor_id');
            $table->string('prestasi');
            $table->text('ket');
            $table->timestamps();

            $table->foreign('rapor_id')->references('id')->on('rapors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapor_prestasis');
    }
}
