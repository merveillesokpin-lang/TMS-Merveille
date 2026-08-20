<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pierce_rechange;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PierceRechangeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $items = Pierce_rechange::paginate(15);
            return response()->json([
                'success' => true,
                'message' => 'Pièces de rechange récupérées avec succès',
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des pièces de rechange',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'NomPiece'      => 'required|string|max:255',
                'ReferencePiece'=> 'required|string|max:255',
                'LibellePiece'  => 'nullable|string|max:255',
                'PrixPiece'     => 'required|string',
                'PrixVente'     => 'nullable|numeric',
                'neuf/use'      => 'nullable|string',
                'QuantiteStock' => 'nullable|integer',
            ]);
            // Default values for nullable required columns
            $validated['LibellePiece'] = $validated['LibellePiece'] ?? $validated['NomPiece'];
            $validated['neuf/use']     = $validated['neuf/use'] ?? 'neuf';

            $item = Pierce_rechange::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Pièce de rechange créée avec succès',
                'data'    => $item,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la pièce de rechange',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = Pierce_rechange::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Pièce de rechange récupérée avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pièce de rechange introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de la pièce de rechange',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $item = Pierce_rechange::findOrFail($id);
            $item->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pièce de rechange mise à jour avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pièce de rechange introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la pièce de rechange',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $item = Pierce_rechange::findOrFail($id);
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pièce de rechange supprimée avec succès',
                'data' => $item,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pièce de rechange introuvable',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la pièce de rechange',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
