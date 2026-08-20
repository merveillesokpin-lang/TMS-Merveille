<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed Catégories Véhicules
        \App\Models\Categorie_Vehicule::updateOrCreate(
            ['id' => 1],
            [
                'LibelleCategorieVehicule' => 'Tracteur Routier',
                'FonctionCategorieVehicule' => 'Tracter les remorques',
            ]
        );
        \App\Models\Categorie_Vehicule::updateOrCreate(
            ['id' => 2],
            [
                'LibelleCategorieVehicule' => 'Remorque Benne',
                'FonctionCategorieVehicule' => 'Transporter les matières',
            ]
        );

        // Seed Catégories Personnel
        \App\Models\Categorie_Personnne::updateOrCreate(
            ['id' => 1],
            [
                'LibelleCategoriePersonnel' => 'Chauffeur',
            ]
        );
        \App\Models\Categorie_Personnne::updateOrCreate(
            ['id' => 2],
            [
                'LibelleCategoriePersonnel' => 'Mécanicien',
            ]
        );
        \App\Models\Categorie_Personnne::updateOrCreate(
            ['id' => 3],
            [
                'LibelleCategoriePersonnel' => 'Comptable',
            ]
        );

        // Administrateur
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@tms.com'],
            [
                'name' => 'Administrateur TMS',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );

        // Comptable
        \App\Models\User::updateOrCreate(
            ['email' => 'comptable@tms.com'],
            [
                'name' => 'Comptable TMS',
                'password' => bcrypt('password'),
                'role' => 'comptable'
            ]
        );

        // Gérant transport
        \App\Models\User::updateOrCreate(
            ['email' => 'gerant@tms.com'],
            [
                'name' => 'Gérant Transport TMS',
                'password' => bcrypt('password'),
                'role' => 'gerant'
            ]
        );

        // Chef garage
        \App\Models\User::updateOrCreate(
            ['email' => 'chef@tms.com'],
            [
                'name' => 'Chef Garage TMS',
                'password' => bcrypt('password'),
                'role' => 'chef_garage'
            ]
        );
    }
}
