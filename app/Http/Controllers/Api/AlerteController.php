<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alerte;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AlerteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $alertes = Alerte::paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Alertes récupérées avec succès',
                'data' => $alertes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des alertes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'TypeAlerte' => 'required|string|max:255',
                'vehicule_id' => 'required|integer',
            ]);

            $alerte = Alerte::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Alerte créée avec succès',
                'data' => $alerte,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'alerte',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $alerte = Alerte::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Alerte récupérée avec succès',
                'data' => $alerte,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alerte introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'alerte',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $alerte = Alerte::findOrFail($id);

            $validated = $request->validate([
                'TypeAlerte' => 'sometimes|required|string|max:255',
                'vehicule_id' => 'sometimes|required|integer',
            ]);

            $alerte->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Alerte mise à jour avec succès',
                'data' => $alerte,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alerte introuvable',
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'alerte',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $alerte = Alerte::findOrFail($id);
            $alerte->delete();

            return response()->json([
                'success' => true,
                'message' => 'Alerte supprimée avec succès',
                'data' => $alerte,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alerte introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'alerte',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
