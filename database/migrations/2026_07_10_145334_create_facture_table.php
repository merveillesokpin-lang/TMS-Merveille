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
        Schema::create('facture', function (Blueprint $table) {
            $table->id();
            $table->string('NumeroFacture');
            $table->date('DateFacture');
            $table->decimal('MontantFacture', 10, 2)->nullable();
            $table->unsignedBigInteger('partenaire_id')->nullable();
            $table->unsignedBigInteger('reglement_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
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
        Schema::dropIfExists('facture');
    }
};
