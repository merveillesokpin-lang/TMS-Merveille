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
        Schema::create('bon_travail', function (Blueprint $table) {
            $table->id();
            $table->string('NumeroBonTravail');
            $table->date('DateBonTravail');
            $table->string('DescriptionTravail');
            $table->unsignedBigInteger('InventaireId')->nullable();
            $table->unsignedBigInteger('VehiculeId')->nullable();
            $table->unsignedBigInteger('PersonnelId')->nullable();
            $table->unsignedBigInteger('CategorieVehiculeId')->nullable();
            $table->unsignedBigInteger('PieceRechangeId')->nullable();
            $table->string('StatutBonTravail');
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
        Schema::dropIfExists('bon_travail');
    }
};
