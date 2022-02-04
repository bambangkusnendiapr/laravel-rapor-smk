<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporEskulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_eskuls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rapor_id');
            $table->unsignedBigInteger('extracurricular_id');
            $table->integer('nilai');
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
        Schema::dropIfExists('rapor_eskuls');
    }
}
