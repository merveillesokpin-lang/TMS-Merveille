<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $personnes = Personne::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Personnes récupérées avec succès',
                'data' => $personnes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des personnes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'NomPersonnel'            => 'required|string|max:255',
                'PrenomPersonnel'         => 'required|string|max:255',
                'EmailPersonnel'          => 'sometimes|email|max:255',
                'TelephonePersonnel'      => 'sometimes|string|max:20',
                'categorie_personnel_id'  => 'required|integer',
            ]);

            $personne = Personne::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Personne créée avec succès',
                'data' => $personne
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la personne',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $personne = Personne::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Personne récupérée avec succès',
                'data' => $personne
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Personne introuvable'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de la personne',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $personne = Personne::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:personnes,email,' . $id,
                'telephone' => 'sometimes|string|max:20',
                'adresse' => 'sometimes|string',
            ]);

            $personne->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Personne mise à jour avec succès',
                'data' => $personne
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Personne introuvable'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la personne',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $personne = Personne::findOrFail($id);
            $personne->delete();

            return response()->json([
                'success' => true,
                'message' => 'Personne supprimée avec succès',
                'data' => $personne
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Personne introuvable'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la personne',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
