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
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->string('NomPersonnel');
            $table->string('PrenomPersonnel');
            $table->string('EmailPersonnel');
            $table->string('TelephonePersonnel');
            $table->unsignedBigInteger('intervention_id')->nullable();
            $table->foreignId('categorie_personnel_id')->constrained('equipement_categorie_personnel')->onDelete('cascade');
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
        Schema::dropIfExists('personnel');
    }
};
