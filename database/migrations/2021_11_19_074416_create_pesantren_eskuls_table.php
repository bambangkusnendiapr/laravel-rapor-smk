<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesantrenEskulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesantren_eskuls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rapor_id');
            $table->unsignedBigInteger('extracurricular_id');
            $table->string('predikat');
            $table->text('ket')->nullable();
            $table->timestamps();

            $table->foreign('rapor_id')->references('id')->on('rapors')->onDelete('cascade');
            $table->foreign('extracurricular_id')->references('id')->on('extracurriculars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesantren_eskuls');
    }
}
