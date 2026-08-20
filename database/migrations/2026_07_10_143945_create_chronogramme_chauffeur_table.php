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
        Schema::create('chronogramme_chauffeur', function (Blueprint $table) {
            $table->id();
            $table->date('Date_Debut');
            $table->date('Date_Fin');
            $table->string('Type_horaire');
            $table->string('PrenomChaufeur');
            $table->foreignId('personnel_id')->constrained('personnel')->onDelete('cascade');
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
        Schema::dropIfExists('chronogramme_chauffeur');
    }
};
