<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voyage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VoyageController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $voyages = Voyage::paginate(15);
            return response()->json(['success' => true, 'data' => $voyages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'VilleDepart'        => 'required|string|max:255',
                'VilleArrivee'       => 'required|string|max:255',
                'DateDepart'         => 'nullable|date',
                'DateRetour'         => 'nullable|date',
                'PrixVoyage'         => 'nullable|numeric',
                'distance'           => 'nullable|numeric',
                'mouvement_id'       => 'nullable|integer',
                'reservation_id'     => 'nullable|integer',
                'personnel_id'       => 'nullable|integer',
                'bon_de_livraison_id'=> 'nullable|integer',
                'vehicule_id'        => 'nullable|integer',
            ]);

            $voyage = Voyage::create($validated);
            return response()->json(['success' => true, 'data' => $voyage], 201);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $voyage = Voyage::findOrFail($id);
            return response()->json(['success' => true, 'data' => $voyage]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Voyage introuvable'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $voyage = Voyage::findOrFail($id);
            $validated = $request->validate([
                'VilleDepart' => 'sometimes|required|string|max:255',
                'VilleArrivee' => 'sometimes|required|string|max:255',
                'DateDepart' => 'nullable|date',
                'DateRetour' => 'nullable|date',
                'PrixVoyage' => 'nullable|numeric',
                'distance' => 'nullable|numeric',
                'mouvement_id' => 'sometimes|required|integer',
                'reservation_id' => 'sometimes|required|integer',
                'personnel_id' => 'sometimes|required|integer',
                'bon_de_livraison_id' => 'sometimes|required|integer',
                'vehicule_id' => 'sometimes|required|integer',
            ]);

            $voyage->update($validated);
            return response()->json(['success' => true, 'data' => $voyage]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Voyage introuvable'], 404);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $voyage = Voyage::findOrFail($id);
            $voyage->delete();
            return response()->json(['success' => true, 'message' => 'Voyage supprimé avec succès']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Voyage introuvable'], 404);
        }
    }
}
