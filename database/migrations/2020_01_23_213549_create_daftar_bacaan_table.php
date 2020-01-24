<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarBacaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_bacaan', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table -> string('cover_buku', 100);
            $table -> integer('id_author') -> unique('id_author_unique');
            $table -> text('sinopsis');

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
        Schema::dropIfExists('daftar_bacaan');
    }
}
