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
        Schema::create('teklifs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId');
            $table->integer('musteriId');
            $table->double('fiyat');
            $table->double('aciklama')->nullable();
            $table->integer('status');//0 ise Açık 1 ise Kapalı Onaylanmış Teklif
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
        Schema::dropIfExists('teklifs');
    }
};
