<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use App\Models\Personne;
use App\Models\Voyage;
use App\Models\Facture;
use App\Models\Reservation;
use App\Models\Reglement;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // Counts
            $totalVehicules  = DB::table('vehicules')->count();
            $totalPersonnes  = DB::table('personnel')->count();
            $totalVoyages    = DB::table('voyage')->count();
            $totalFactures   = DB::table('facture')->count();
            $totalReservations = DB::table('reservation')->count();
            $totalReglements = DB::table('reglement')->count();

            // Revenue total
            $caTotal = DB::table('facture')->sum('MontantFacture') ?? 0;
            $caMois  = DB::table('facture')
                ->whereYear('DateFacture', now()->year)
                ->whereMonth('DateFacture', now()->month)
                ->sum('MontantFacture') ?? 0;

            // Voyages par mois (12 derniers mois)
            $voyagesParMois = DB::table('voyage')
                ->select(DB::raw("DATE_FORMAT(DateDepart, '%Y-%m') as mois"), DB::raw('COUNT(*) as total'))
                ->whereNotNull('DateDepart')
                ->where('DateDepart', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('mois')
                ->orderBy('mois')
                ->get();

            // Vehicules par statut
            $vehiculesStatut = DB::table('vehicules')
                ->select('Statut_DisponibiliteVehicule as statut', DB::raw('COUNT(*) as total'))
                ->groupBy('statut')
                ->get();

            // CA par mois (6 derniers mois)
            $caParMois = DB::table('facture')
                ->select(DB::raw("DATE_FORMAT(DateFacture, '%Y-%m') as mois"), DB::raw('SUM(MontantFacture) as total'))
                ->whereNotNull('DateFacture')
                ->where('DateFacture', '>=', now()->subMonths(5)->startOfMonth())
                ->groupBy('mois')
                ->orderBy('mois')
                ->get();

            // Top voyages (villes les plus desservies)
            $topDestinations = DB::table('voyage')
                ->select('VilleArrivee as ville', DB::raw('COUNT(*) as total'))
                ->groupBy('VilleArrivee')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'kpis' => [
                        'totalVehicules'    => $totalVehicules,
                        'totalPersonnes'    => $totalPersonnes,
                        'totalVoyages'      => $totalVoyages,
                        'totalFactures'     => $totalFactures,
                        'totalReservations' => $totalReservations,
                        'totalReglements'   => $totalReglements,
                        'caTotal'           => $caTotal,
                        'caMois'            => $caMois,
                    ],
                    'voyagesParMois'   => $voyagesParMois,
                    'vehiculesStatut'  => $vehiculesStatut,
                    'caParMois'        => $caParMois,
                    'topDestinations'  => $topDestinations,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
