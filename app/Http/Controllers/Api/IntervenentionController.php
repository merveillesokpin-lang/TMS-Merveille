<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Intervetion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntervenentionController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $items = Intervetion::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Interventions récupérées avec succès',
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des interventions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = Intervetion::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Intervention créée avec succès',
                'data' => $item,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'intervention',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Intervetion::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Intervention récupérée avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Intervention introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de l\'intervention',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $item = Intervetion::findOrFail($id);
            $item->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Intervention mise à jour avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Intervention introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'intervention',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Intervetion::findOrFail($id);
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Intervention supprimée avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Intervention introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'intervention',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
