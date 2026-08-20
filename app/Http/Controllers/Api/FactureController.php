<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FactureController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $factures = Facture::paginate(15);
            return response()->json(['success' => true, 'data' => $factures]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'NumeroFacture' => 'required|string|max:255',
                'DateFacture' => 'required|date',
                'MontantFacture' => 'nullable|numeric',
                'partenaire_id'  => 'nullable|integer',
                'reglement_id'   => 'nullable|integer',
                'reservation_id' => 'nullable|integer',
            ]);

            $facture = Facture::create($validated);
            return response()->json(['success' => true, 'data' => $facture], 201);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $facture = Facture::findOrFail($id);
            return response()->json(['success' => true, 'data' => $facture]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Facture introuvable'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $facture = Facture::findOrFail($id);
            $validated = $request->validate([
                'NumeroFacture' => 'sometimes|required|string|max:255',
                'DateFacture' => 'sometimes|required|date',
                'MontantFacture' => 'nullable|numeric',
                'partenaire_id' => 'sometimes|required|integer',
                'reglement_id' => 'sometimes|required|integer',
                'reservation_id' => 'sometimes|required|integer',
            ]);

            $facture->update($validated);
            return response()->json(['success' => true, 'data' => $facture]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Facture introuvable'], 404);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $facture = Facture::findOrFail($id);
            $facture->delete();
            return response()->json(['success' => true, 'message' => 'Facture supprimée avec succès']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Facture introuvable'], 404);
        }
    }
}
