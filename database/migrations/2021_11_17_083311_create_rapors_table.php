<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('student_id');
            $table->enum('kelas', ['X', 'XI', 'XII'])->nullable();
            $table->text('spiritual')->nullable();
            $table->text('sosial')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('sakit')->nullable();
            $table->integer('izin')->nullable();
            $table->integer('alpa')->nullable();
            $table->text('catatan_pesantren')->nullable();
            $table->string('kelakuan')->nullable();
            $table->string('disiplin')->nullable();
            $table->string('rapih')->nullable();
            $table->integer('sakit_pesantren')->nullable();
            $table->integer('izin_pesantren')->nullable();
            $table->integer('alpa_pesantren')->nullable();
            $table->enum('ket_naik', ['Naik', 'Tidak Naik', 'Tetap'])->nullable();
            $table->enum('ke_kelas', ['X', 'XI', 'XII'])->nullable();
            $table->text('catatan_ortu')->nullable();
            $table->timestamps();

            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapors');
    }
}
