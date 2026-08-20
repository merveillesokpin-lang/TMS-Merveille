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
        Schema::create('equipement_geoloc', function (Blueprint $table) {
            $table->id();
            $table->string('Tracker_IMEI');
            $table->string('latitude_Atuelle');
            $table->string('longitude_Atuelle');
            $table->string('Carbrat_Restant');
            $table->string('Dernier_Arrêt');
            $table->string('Est_Immobilisé');
            $table->foreignId('vehicules_id')->constrained('vehicules')->onDelete('cascade');
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
        Schema::dropIfExists('equipement_geoloc');
    }
};
