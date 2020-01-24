<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_author', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table -> integer('id_user') -> unique('id_user_unique');
            $table -> string('nama_author', 50);
            $table -> integer('jumlah_karya');
            $table -> text('deskripsi_diri');

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
        Schema::dropIfExists('info_author');
    }
}
