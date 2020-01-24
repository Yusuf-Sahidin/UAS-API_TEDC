<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBacaNantiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baca_nanti', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table -> integer('id_user') -> unique('id_user_unique');
            $table -> integer('id_daftar_bacaan') -> unique('id_daftar_bacaan_unique');

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
        Schema::dropIfExists('baca_nanti');
    }
}
