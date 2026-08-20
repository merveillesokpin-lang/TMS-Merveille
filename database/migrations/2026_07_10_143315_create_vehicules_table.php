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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('ImmatriculationVehicule');
            $table->string('NumerochassisVehicule');
            $table->date('DateMiseEnCirculationVehicule');
            $table->date('DateReformeVehicule');
            $table->string('Statut_DisponibiliteVehicule');
            $table->string('Kilometrage_Atuel_Vehicule');
            $table->string('Consommation_Moyenne_Vehicule');
            $table->string('MotorisationVehicule');
            $table->string('PneumatiqueVehicule');
            $table->string('DimensionVehicule');
            $table->string('TypeVehicule');
            $table->foreignId('categorie_vehicule_id')->constrained('categorie_vehicule')->onDelete('cascade');
            
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
        Schema::dropIfExists('vehicules');
    }
};
