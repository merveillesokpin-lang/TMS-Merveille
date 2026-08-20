<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehiculeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $vehicules = Vehicule::paginate(15);
            return response()->json([
                'success' => true,
                'data' => $vehicules,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'ImmatriculationVehicule' => 'required|string|max:255',
                'NumerochassisVehicule' => 'required|string|max:255',
                'DateMiseEnCirculationVehicule' => 'required|date',
                'DateReformeVehicule' => 'required|date',
                'Statut_DisponibiliteVehicule' => 'required|string|max:255',
                'Kilometrage_Atuel_Vehicule' => 'required',
                'Consommation_Moyenne_Vehicule' => 'required',
                'MotorisationVehicule' => 'required|string',
                'PneumatiqueVehicule' => 'required|string',
                'DimensionVehicule' => 'required|string',
                'TypeVehicule' => 'required|string',
                'categorie_vehicule_id' => 'required|integer',
            ]);

            $vehicule = Vehicule::create($validated);
            return response()->json(['success' => true, 'data' => $vehicule], 201);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $vehicule = Vehicule::findOrFail($id);
            return response()->json(['success' => true, 'data' => $vehicule]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Véhicule introuvable'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $vehicule = Vehicule::findOrFail($id);
            $validated = $request->validate([
                'ImmatriculationVehicule' => 'sometimes|required|string|max:255',
                'NumerochassisVehicule' => 'sometimes|required|string|max:255',
                'DateMiseEnCirculationVehicule' => 'sometimes|required|date',
                'DateReformeVehicule' => 'sometimes|required|date',
                'Statut_DisponibiliteVehicule' => 'sometimes|required|string|max:255',
                'Kilometrage_Atuel_Vehicule' => 'sometimes|required|string',
                'Consommation_Moyenne_Vehicule' => 'sometimes|required|string',
                'MotorisationVehicule' => 'sometimes|required|string',
                'PneumatiqueVehicule' => 'sometimes|required|string',
                'DimensionVehicule' => 'sometimes|required|string',
                'TypeVehicule' => 'sometimes|required|string',
                'categorie_vehicule_id' => 'sometimes|required|integer',
            ]);

            $vehicule->update($validated);
            return response()->json(['success' => true, 'data' => $vehicule]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Véhicule introuvable'], 404);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $vehicule = Vehicule::findOrFail($id);
            $vehicule->delete();
            return response()->json(['success' => true, 'message' => 'Véhicule supprimé avec succès']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Véhicule introuvable'], 404);
        }
    }
}
