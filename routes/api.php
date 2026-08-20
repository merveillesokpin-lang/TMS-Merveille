<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AlerteController;
use App\Http\Controllers\Api\BonLivraisonController;
use App\Http\Controllers\Api\BonTravailController;
use App\Http\Controllers\Api\CategoriePersonneController;
use App\Http\Controllers\Api\CategorieVehiculeController;
use App\Http\Controllers\Api\ChronogrammeChauffeurController;
use App\Http\Controllers\Api\ContratPartenaireController;
use App\Http\Controllers\Api\ContratTravailController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EquipementGeolocController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\IndicentController;
use App\Http\Controllers\Api\IntervenentionController;
use App\Http\Controllers\Api\LogsystemController;
use App\Http\Controllers\Api\MouvementParcController;
use App\Http\Controllers\Api\PartenaireController;
use App\Http\Controllers\Api\PierceRechangeController;
use App\Http\Controllers\Api\PrestataireExterneController;
use App\Http\Controllers\Api\ReglementController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\VehiculeController;
use App\Http\Controllers\Api\VoyageController;
use App\Http\Controllers\Api\FactureController;
use App\Http\Controllers\Api\PersonneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as RouteFacade;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

RouteFacade::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

RouteFacade::get('/message', function () {
    return response()->json([
        'message' => 'Bonjour depuis Laravel !'
    ]);
});

// Auth Routes
RouteFacade::post('/register', [AuthController::class, 'register']);
RouteFacade::post('/login', [AuthController::class, 'login']);

RouteFacade::middleware('auth:sanctum')->group(function () {
    RouteFacade::get('/user', [AuthController::class, 'user']);
    RouteFacade::post('/logout', [AuthController::class, 'logout']);

    // General resources (Accessible by all roles, read-only logic handled in frontend/controllers)
    RouteFacade::apiResource('vehicules', VehiculeController::class);
    RouteFacade::apiResource('personnes', PersonneController::class);
    RouteFacade::apiResource('partenaires', PartenaireController::class);
    RouteFacade::apiResource('categorie-vehicules', CategorieVehiculeController::class);
    RouteFacade::apiResource('categorie-personnes', CategoriePersonneController::class);
    RouteFacade::apiResource('contrat-partenaires', ContratPartenaireController::class);
    RouteFacade::apiResource('contrat-travails', ContratTravailController::class);
    RouteFacade::apiResource('equipement-geolocs', EquipementGeolocController::class);
    RouteFacade::apiResource('chronogramme-chauffeurs', ChronogrammeChauffeurController::class);

    // Mouvements & Voyages (admin, gerant)
    RouteFacade::middleware('role:admin,gerant')->group(function () {
        RouteFacade::apiResource('voyages', VoyageController::class);
        RouteFacade::apiResource('mouvement-parcs', MouvementParcController::class);
        RouteFacade::apiResource('reservations', ReservationController::class);
        RouteFacade::apiResource('bon-livraisons', BonLivraisonController::class);
    });

    // Maintenance (admin, chef_garage)
    RouteFacade::middleware('role:admin,chef_garage')->group(function () {
        RouteFacade::apiResource('bon-travails', BonTravailController::class);
        RouteFacade::apiResource('interventions', IntervenentionController::class);
        RouteFacade::apiResource('pieces-rechanges', PierceRechangeController::class);
        RouteFacade::apiResource('prestataires-externes', PrestataireExterneController::class);
        RouteFacade::apiResource('incidents', IndicentController::class);
        RouteFacade::apiResource('alertes', AlerteController::class);
    });

    // Comptabilité & Facturation (admin, comptable)
    RouteFacade::middleware('role:admin,comptable')->group(function () {
        RouteFacade::apiResource('factures', FactureController::class);
        RouteFacade::apiResource('reglements', ReglementController::class);
        RouteFacade::apiResource('log-systems', LogsystemController::class);
    });

    // Documents (tous rôles)
    RouteFacade::get('documents', [DocumentController::class, 'index']);
    RouteFacade::post('documents', [DocumentController::class, 'store']);
    RouteFacade::get('documents/{id}', [DocumentController::class, 'show']);
    RouteFacade::delete('documents/{id}', [DocumentController::class, 'destroy']);

    // Statistiques (admin, gerant, comptable)
    RouteFacade::get('stats', [StatsController::class, 'index']);

    // Notifications (tous rôles)
    RouteFacade::get('notifications', [NotificationController::class, 'index']);

    // Envoi de fiches par email (tous rôles)
    RouteFacade::post('mail/send-fiche', [MailController::class, 'sendFiche']);
});
