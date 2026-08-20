<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $notifications = collect();
            $today = Carbon::today();
            $seuil30 = Carbon::today()->addDays(30);
            $seuil7  = Carbon::today()->addDays(7);

            // 1. Documents expirant dans les 30 jours
            $docsExpiring = Document::whereNotNull('date_expiration')
                ->where('date_expiration', '>=', $today)
                ->where('date_expiration', '<=', $seuil30)
                ->get();

            foreach ($docsExpiring as $doc) {
                $expDate = Carbon::parse($doc->date_expiration);
                $daysLeft = $today->diffInDays($expDate);
                $niveau = $daysLeft <= 7 ? 'danger' : 'warning';
                $notifications->push([
                    'id'      => 'doc_' . $doc->id,
                    'type'    => 'document',
                    'niveau'  => $niveau,
                    'titre'   => 'Document expirant bientôt',
                    'message' => "📄 \"{$doc->titre}\" ({$doc->type_document}) expire dans {$daysLeft} jour(s) — le " . $expDate->format('d/m/Y'),
                    'date'    => $doc->date_expiration,
                    'icon'    => $niveau === 'danger' ? '🚨' : '⚠️',
                ]);
            }

            // 2. Documents déjà expirés
            $docsExpired = Document::whereNotNull('date_expiration')
                ->where('date_expiration', '<', $today)
                ->get();

            foreach ($docsExpired as $doc) {
                $notifications->push([
                    'id'      => 'doc_exp_' . $doc->id,
                    'type'    => 'document_expire',
                    'niveau'  => 'danger',
                    'titre'   => 'Document expiré',
                    'message' => "❌ \"{$doc->titre}\" ({$doc->type_document}) a expiré le " . Carbon::parse($doc->date_expiration)->format('d/m/Y'),
                    'date'    => $doc->date_expiration,
                    'icon'    => '❌',
                ]);
            }

            // 3. Véhicules disponibles sans alerte (info générale)
            try {
                $totalVehicules = DB::table('vehicules')->count();
                $vehiculesIndispo = DB::table('vehicules')
                    ->where('Statut_DisponibiliteVehicule', '!=', 'Disponible')
                    ->count();

                if ($vehiculesIndispo > 0) {
                    $notifications->push([
                        'id'      => 'fleet_status',
                        'type'    => 'fleet',
                        'niveau'  => 'warning',
                        'titre'   => 'Véhicules non disponibles',
                        'message' => "🚛 {$vehiculesIndispo}/{$totalVehicules} véhicule(s) sont actuellement hors service ou en maintenance.",
                        'date'    => now()->toDateString(),
                        'icon'    => '🚛',
                    ]);
                }
            } catch (\Exception $e) {}

            // 4. Alertes depuis la table alertes
            try {
                $alertes = DB::table('alerte')
                    ->where('DateAlerte', '>=', Carbon::now()->subDays(7))
                    ->orderByDesc('DateAlerte')
                    ->limit(5)
                    ->get();

                foreach ($alertes as $alerte) {
                    $notifications->push([
                        'id'      => 'alerte_' . $alerte->id,
                        'type'    => 'alerte',
                        'niveau'  => 'info',
                        'titre'   => 'Alerte Système',
                        'message' => '🔔 ' . ($alerte->TypeAlerte ?? 'Alerte') . ' — ' . ($alerte->DateAlerte ?? ''),
                        'date'    => $alerte->DateAlerte ?? now()->toDateString(),
                        'icon'    => '🔔',
                    ]);
                }
            } catch (\Exception $e) {}

            // Trier : danger en premier, puis warning, puis info
            $ordered = $notifications->sortBy(function($n) {
                return match($n['niveau']) {
                    'danger' => 0,
                    'warning' => 1,
                    default => 2,
                };
            })->values();

            return response()->json([
                'success' => true,
                'total'   => $ordered->count(),
                'unread'  => $ordered->where('niveau', 'danger')->count() + $ordered->where('niveau', 'warning')->count(),
                'data'    => $ordered,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'total'   => 0,
                'unread'  => 0,
                'data'    => [],
                'error'   => $e->getMessage()
            ], 200);
        }
    }
}
