<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conntrat_partenaire;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContratPartenaireController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $items = Conntrat_partenaire::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Contrats partenaires récupérés avec succès',
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des contrats partenaires',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = Conntrat_partenaire::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Contrat partenaire créé avec succès',
                'data' => $item,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du contrat partenaire',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Conntrat_partenaire::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Contrat partenaire récupéré avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Contrat partenaire introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du contrat partenaire',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $item = Conntrat_partenaire::findOrFail($id);
            $item->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Contrat partenaire mis à jour avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Contrat partenaire introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du contrat partenaire',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Conntrat_partenaire::findOrFail($id);
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Contrat partenaire supprimé avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Contrat partenaire introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du contrat partenaire',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
