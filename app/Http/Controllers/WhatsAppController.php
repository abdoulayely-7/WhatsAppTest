<?php

namespace App\Http\Controllers;

use Twilio\Exceptions\ConfigurationException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    /**
     * @throws ConfigurationException
     */
    public function sendVoiceMessage(Request $request)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($sid, $token);

        // Utilisez l'URL publique ngrok pour le fichier audio
        $audioUrl = 'https://5b4c-2001-4278-50-5981-1c26-c9c2-7b01-79d7.ngrok-free.app/audio/test.m4a';

        try {
            $message = $client->messages->create(
                'whatsapp:' . $request->input('to'), // Numéro WhatsApp du destinataire
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'mediaUrl' => [$audioUrl], // Envoi du message vocal via l'URL publique
                ]
            );

            return response()->json(['status' => 'success', 'message' => 'Message vocal envoyé !']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
