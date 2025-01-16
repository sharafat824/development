<?php

namespace App;

use Illuminate\Support\Facades\Http;

trait PrivyService
{
    protected $baseUrl;
    protected $appId;
    protected $appSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.privy.base_url', env('PRIVY_API_BASE_URL'));
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
        $response = Http::withBasicAuth($this->appId, $this->appSecret)
            ->baseUrl($this->baseUrl)
            ->asJson()
            ->{$method}($endpoint, $method === 'GET' ? $queryParams : $data);

        if ($response->failed()) {
            throw new \Exception('Privy API Error: ' . $response->body());
        }

        return $response->json();
    }
}
