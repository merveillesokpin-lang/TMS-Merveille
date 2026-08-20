<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bon_livraison;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BonLivraisonController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $items = Bon_livraison::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Bons de livraison récupérés avec succès',
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des bons de livraison',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = Bon_livraison::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Bon de livraison créé avec succès',
                'data' => $item,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du bon de livraison',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Bon_livraison::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Bon de livraison récupéré avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bon de livraison introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du bon de livraison',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $item = Bon_livraison::findOrFail($id);
            $item->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Bon de livraison mis à jour avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bon de livraison introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du bon de livraison',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Bon_livraison::findOrFail($id);
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Bon de livraison supprimé avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bon de livraison introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du bon de livraison',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
