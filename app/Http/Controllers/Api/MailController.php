<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendFiche(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'to'      => 'required|email',
                'subject' => 'required|string|max:255',
                'titre'   => 'required|string',
                'fields'  => 'required|array',
                'ref'     => 'nullable|string',
            ]);

            $to      = $request->to;
            $subject = $request->subject;
            $titre   = $request->titre;
            $fields  = $request->fields;
            $ref     = $request->ref ?? 'N/A';
            $date    = now()->format('d/m/Y');

            // Build HTML body
            $rows = '';
            foreach ($fields as $field) {
                $label = htmlspecialchars($field['label'] ?? '');
                $value = htmlspecialchars($field['value'] ?? '—');
                $rows .= "<tr>
                    <td style='padding:8px 12px;font-size:12px;font-weight:700;color:#495057;width:35%;background:#f8f9fa;text-transform:uppercase;border-bottom:1px solid #e9ecef;'>{$label}</td>
                    <td style='padding:8px 12px;font-size:13px;color:#212529;border-bottom:1px solid #e9ecef;font-weight:500;'>{$value}</td>
                </tr>";
            }

            $html = "
            <!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    * { font-family: Arial, sans-serif; }
                    body { background: #f5f5f5; margin: 0; padding: 20px; }
                    .wrapper { max-width: 680px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
                    .top-bar { background: #0d1b2a; color: #fff; padding: 20px 28px; display: flex; justify-content: space-between; align-items: center; }
                    .brand { font-size: 24px; font-weight: 900; }
                    .brand span { color: #00b4d8; }
                    .badge-titre { background: #00b4d8; color: #0d1b2a; font-weight: 700; font-size: 13px; padding: 5px 14px; border-radius: 4px; }
                    .meta-bar { background: #f8f9fa; padding: 10px 28px; font-size: 12px; color: #6c757d; border-bottom: 2px solid #00b4d8; }
                    .content { padding: 0 28px 28px; }
                    .fiche-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                    .sig-section { display: flex; gap: 16px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #dee2e6; }
                    .sig-block { flex: 1; text-align: center; }
                    .sig-line { border-bottom: 1px solid #0d1b2a; margin: 0 10px 6px; padding-top: 36px; }
                    .sig-label { font-size: 11px; color: #adb5bd; margin-top: 4px; }
                    .footer { background: #0d1b2a; color: #6c757d; font-size: 11px; text-align: center; padding: 14px; }
                    .footer a { color: #00b4d8; }
                </style>
            </head>
            <body>
                <div class='wrapper'>
                    <div class='top-bar'>
                        <div class='brand'>AKASI<span>TMS</span></div>
                        <div class='badge-titre'>{$titre}</div>
                    </div>
                    <div class='meta-bar'>
                        <strong>Réf:</strong> #{$ref} &nbsp;|&nbsp;
                        <strong>Date d'émission:</strong> {$date} &nbsp;|&nbsp;
                        AKASI GROUP — Transport &amp; Logistique Internationale
                    </div>
                    <div class='content'>
                        <table class='fiche-table'>
                            <tbody>{$rows}</tbody>
                        </table>
                        <div style='display:flex;gap:20px;margin-top:24px;padding-top:16px;border-top:1px solid #dee2e6;'>
                            <div style='flex:1;text-align:center;'>
                                <div style='padding-top:36px;border-bottom:1px solid #0d1b2a;margin:0 10px 6px;'></div>
                                <p style='font-size:12px;color:#6c757d;margin:0;'>Établi par</p>
                                <p style='font-size:11px;color:#adb5bd;margin:0;'>Signature &amp; Cachet</p>
                            </div>
                            <div style='flex:1;text-align:center;'>
                                <div style='padding-top:36px;border-bottom:1px solid #0d1b2a;margin:0 10px 6px;'></div>
                                <p style='font-size:12px;color:#6c757d;margin:0;'>Validé par</p>
                                <p style='font-size:11px;color:#adb5bd;margin:0;'>Direction Générale</p>
                            </div>
                            <div style='flex:1;text-align:center;'>
                                <div style='padding-top:36px;border-bottom:1px solid #0d1b2a;margin:0 10px 6px;'></div>
                                <p style='font-size:12px;color:#6c757d;margin:0;'>Reçu par</p>
                                <p style='font-size:11px;color:#adb5bd;margin:0;'>Bénéficiaire</p>
                            </div>
                        </div>
                    </div>
                    <div class='footer'>
                        Document généré automatiquement par <strong style='color:#00b4d8;'>AKASI TMS</strong> — Tous droits réservés © " . now()->year . "
                    </div>
                </div>
            </body>
            </html>
            ";

            Mail::html($html, function($message) use ($to, $subject) {
                $message->to($to)
                        ->subject($subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return response()->json([
                'success' => true,
                'message' => "Fiche envoyée avec succès à {$to}",
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Erreur lors de l\'envoi : ' . $e->getMessage()
            ], 500);
        }
    }
}
