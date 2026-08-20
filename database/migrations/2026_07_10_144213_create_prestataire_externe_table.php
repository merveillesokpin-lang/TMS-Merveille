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
        Schema::create('prestataire_externe', function (Blueprint $table) {
            $table->id();
            $table->string('NomPrestataire');
            $table->string('ContactPrestataire');
            $table->string('EmailPrestataire');
            $table->string('AdressePrestataire');
            $table->string('TypePrestataire');
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
        Schema::dropIfExists('prestataire_externe');
    }
};
