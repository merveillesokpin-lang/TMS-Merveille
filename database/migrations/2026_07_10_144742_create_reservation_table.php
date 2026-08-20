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
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string('TypeReservation');
            $table->date('Date_debutReservation');
            $table->date('Date_finReservation')->nullable();
            $table->decimal('FraisReservation', 10, 2)->nullable();
            $table->unsignedBigInteger('partenaire_id')->nullable();
            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->unsignedBigInteger('personnel_id')->nullable();
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
        Schema::dropIfExists('reservation');
    }
};
