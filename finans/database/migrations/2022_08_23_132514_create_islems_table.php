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
        Schema::create('islems', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tip')->default(0);
            $table->integer('musteriId');
            $table->integer('faturaId')->default(0);
            $table->double('fiyat');
            $table->date('tarih');
            $table->integer('bankaId');
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
        Schema::dropIfExists('islems');
    }
};
