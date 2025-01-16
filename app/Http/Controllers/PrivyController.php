<?php

namespace App\Http\Controllers;

use App\Services\PrivyService;
use Illuminate\Http\JsonResponse;

class PrivyController extends Controller
{
    protected $privy;

    public function __construct(PrivyService $privy)
    {
        $this->privy = $privy;
    }

    public function getCampaigns(): JsonResponse
    {
        try {
            // Adjusted endpoint based on typical Privy API structure
            $campaigns = $this->privy->get('campaigns'); // Assuming 'campaigns' is the correct endpoint
            return response()->json($campaigns);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve campaigns: ' . $e->getMessage()], 500);
        }
    }
}
