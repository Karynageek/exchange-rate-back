<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EmailSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmailSubscriptionController extends Controller
{
    /**
     * Subscribe email to newsletter
     *
     * @param Request $request
     * @param EmailSubscriptionService $emailSubscriptionService
     * @return JsonResponse
     */
    public function subscribe(Request $request, EmailSubscriptionService $emailSubscriptionService): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
            $emailSubscriptionService->subscribe($request->get('email'));
            return response()->json([
                'message' => 'Email subscribed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Send emails to subscribed users
     *
     * @param EmailSubscriptionService $emailSubscriptionService
     * @return JsonResponse
     */
    public function sendEmails(EmailSubscriptionService $emailSubscriptionService): JsonResponse
    {
        try {
            $emailSubscriptionService->sendEmails();
            return response()->json([
                'message' => 'Emails sent'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
