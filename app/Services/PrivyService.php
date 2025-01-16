<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PrivyService
{
    protected $baseUrl;
    protected $appId;
    protected $appSecret;

    public function __construct()
    {
        $this->baseUrl = env('PRIVY_API_BASE_URL');
        $this->appId = env('PRIVY_APP_ID');
        $this->appSecret = env('PRIVY_APP_SECRET');
    }

    /**
     * Make a GET request to the Privy API.
     */
    public function get($endpoint, $queryParams = [])
    {
        return $this->request('GET', $endpoint, $queryParams);
    }

    /**
     * Make a POST request to the Privy API.
     */
    public function post($endpoint, $data = [])
    {
        return $this->request('POST', $endpoint, [], $data);
    }

    /**
     * General request handler.
     */
    private function request($method, $endpoint, $queryParams = [], $data = [])
{
    $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    \Log::info("Making a {$method} request to: {$url} with params: ", $queryParams);

    // Use basic authentication for Privy API
    $response = Http::withHeaders([
        'Authorization' => 'Basic ' . base64_encode($this->appId . ':' . $this->appSecret),
        'privy-app-id' => $this->appId,
    ])->asJson()->{$method}($url, $method === 'GET' ? $queryParams : $data);

    if ($response->failed()) {
        throw new \Exception('Privy API Error: ' . $response->body());
    }

    return $response->json();
}

}
