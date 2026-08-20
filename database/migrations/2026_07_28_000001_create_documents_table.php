<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('type_document'); // carte_grise, permis, assurance, contrat, autre
            $table->string('fichier_path');
            $table->string('fichier_nom');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('taille_octets')->nullable();
            $table->date('date_expiration')->nullable();
            // Relations polymorphes (vehicule, personnel, partenaire...)
            $table->string('entite_type')->nullable(); // App\Models\Vehicule
            $table->unsignedBigInteger('entite_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
