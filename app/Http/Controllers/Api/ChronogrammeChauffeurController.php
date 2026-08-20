<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chronogramme_chauffeur;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChronogrammeChauffeurController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $items = Chronogramme_chauffeur::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Chronogrammes chauffeurs récupérés avec succès',
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des chronogrammes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = Chronogramme_chauffeur::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Chronogramme créé avec succès',
                'data' => $item,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du chronogramme',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Chronogramme_chauffeur::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Chronogramme récupéré avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Chronogramme introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du chronogramme',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $item = Chronogramme_chauffeur::findOrFail($id);
            $item->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Chronogramme mis à jour avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Chronogramme introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du chronogramme',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Chronogramme_chauffeur::findOrFail($id);
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Chronogramme supprimé avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Chronogramme introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du chronogramme',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
