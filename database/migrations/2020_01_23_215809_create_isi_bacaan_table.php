<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsiBacaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_bacaan', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table -> integer('id_author') -> unique('id_author_unique');
            $table -> integer('id_daftar_bacaan') -> unique('id_daftar_bacaan_unique');
            $table -> integer('chapter');
            $table -> longText('isi_cerita');

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
        Schema::dropIfExists('isi_bacaan');
    }
}
