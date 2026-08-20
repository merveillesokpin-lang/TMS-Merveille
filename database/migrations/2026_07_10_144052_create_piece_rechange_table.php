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
        Schema::create('piece_rechange', function (Blueprint $table) {
            $table->id();
            $table->string('NomPiece');
            $table->string('ReferencePiece');
            $table->string('LibellePiece');
            $table->string('PrixPiece');
            $table->decimal('PrixVente', 10, 2)->nullable();
            $table->string('neuf/use');
            $table->integer('QuantiteStock')->default(0);
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
        Schema::dropIfExists('piece_rechange');
    }
};
