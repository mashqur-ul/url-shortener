<?php

namespace App\UrlShortener\Services;

use App\UrlShortener\Interfaces\ThreatCheckerInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ThreatCheckService implements ThreatCheckerInterface
{
    private $baseUrl = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=';

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('shortener.google_lookup_api_key');
    }

    /**
     * @return string
     */
    private function buildUrl(): string
    {
        return $this->baseUrl.$this->apiKey;
    }

    /**
     * @param array $urls
     * @return array[]
     */
    private function requestData(array $urls): array
    {
        return [
            "client" => [
                "clientId" => config('google_lookup_client_id'),
                "clientVersion" => "1.5.2",
            ],
            "threatInfo" => [
                "threatTypes" => ["MALWARE", "SOCIAL_ENGINEERING"],
                "platformTypes" => ["WINDOWS", "LINUX"],
                "threatEntryTypes" => ["URL"],
                "threatEntries" => $urls,
            ],
        ];
    }

    /**
     * @param array $urls
     * @return bool
     * @throws \Exception
     */
    public function isSafe(array $urls): bool
    {
        if (empty($urls)) {
            throw new \Exception("Please set url first to check safety.");
        }

        $res = Http::post($this->buildUrl(), $this->requestData($urls));
        Log::info("Google lookup response", [$res->body()]);

        if ($res->ok() && empty($res->json())) {
            return true;
        }

        return false;
    }
}
