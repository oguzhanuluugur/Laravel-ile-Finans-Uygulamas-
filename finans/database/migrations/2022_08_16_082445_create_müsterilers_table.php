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
        Schema::create('müsterilers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('musteriTipi')->default(0);
            $table->string('photo')->nullable();

            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->date('dogumTarihi')->nullable();
            $table->string('tc')->nullable();

            $table->string('firmaAdı')->nullable();
            $table->string('vergiNumarası')->nullable();
            $table->string('vergiDairesi')->nullable();
            $table->string('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();

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
        Schema::dropIfExists('müsterilers');
    }
};
