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
        Schema::create('voyage', function (Blueprint $table) {
            $table->id();
            $table->string('VilleDepart');
            $table->string('VilleArrivee');
            $table->date('DateDepart')->nullable();
            $table->date('DateRetour')->nullable();
            $table->decimal('PrixVoyage', 10, 2)->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            $table->unsignedBigInteger('mouvement_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->unsignedBigInteger('personnel_id')->nullable();
            $table->unsignedBigInteger('bon_de_livraison_id')->nullable();
            $table->unsignedBigInteger('vehicule_id')->nullable();
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
        Schema::dropIfExists('voyage');
    }
};
