<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Document::query();
            if ($request->has('entite_type') && $request->has('entite_id')) {
                $query->where('entite_type', $request->entite_type)
                      ->where('entite_id', $request->entite_id);
            }
            $docs = $query->orderByDesc('created_at')->paginate(20);
            return response()->json(['success' => true, 'data' => $docs], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'fichier'        => 'required|file|max:10240', // 10MB max
                'titre'          => 'required|string|max:255',
                'type_document'  => 'required|string|max:100',
                'date_expiration'=> 'nullable|date',
                'entite_type'    => 'nullable|string',
                'entite_id'      => 'nullable|integer',
            ]);

            $file = $request->file('fichier');
            $path = $file->store('documents', 'public');

            $doc = Document::create([
                'titre'          => $request->titre,
                'type_document'  => $request->type_document,
                'fichier_path'   => $path,
                'fichier_nom'    => $file->getClientOriginalName(),
                'mime_type'      => $file->getMimeType(),
                'taille_octets'  => $file->getSize(),
                'date_expiration'=> $request->date_expiration,
                'entite_type'    => $request->entite_type,
                'entite_id'      => $request->entite_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploadé avec succès',
                'data'    => $doc,
                'url'     => Storage::url($path),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $doc = Document::findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => $doc,
                'url'     => Storage::url($doc->fichier_path),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $doc = Document::findOrFail($id);
            Storage::disk('public')->delete($doc->fichier_path);
            $doc->delete();
            return response()->json(['success' => true, 'message' => 'Document supprimé'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
