<?php

namespace App\Http\Controllers;

use App\Services\PrivyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class PrivyController extends Controller
{
    protected $privy;

    public function __construct(PrivyService $privy)
    {
        $this->privy = $privy;
    }

    public function getCampaigns()
    {
        // Get the API URL from the environment variable
        $apiUrl = env('PRIVY_API_URL'); // Ensure this is set as 'https://api.privy.io'
    
        // Log the full URL for debugging purposes
        \Log::info('API URL:', [$apiUrl . '/campaigns']);
    
        // Correctly formed endpoint for campaigns
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PRIVY_CLIENT_ID')
        ])->get($apiUrl . '/campaigns'); // Make sure there is a slash before 'campaigns'
    
        dd($response);
        }
}
