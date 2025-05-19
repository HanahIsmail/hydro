<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;

class ThingSpeakService
{
    protected $client;
    protected $apiKey;
    protected $channelId;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.thingspeak.api_key');
        $this->channelId = config('services.thingspeak.channel_id');
    }

    public function getLatestData()
    {
        try {
            $response = $this->client->get("https://api.thingspeak.com/channels/{$this->channelId}/feeds/last.json?api_key={$this->apiKey}");
            $data = json_decode($response->getBody(), true);

            return [
                'temperature' => $data['field1'] ?? 0,
                'humidity' => $data['field2'] ?? 0,
                'tds' => $data['field3'] ?? 0,
                'measured_at' => Carbon::parse($data['created_at'])->setTimezone(config('app.timezone'))
            ];
        } catch (\Exception $e) {
            return [
                'temperature' => 0,
                'humidity' => 0,
                'tds' => 0,
                'measured_at' => now()
            ];
        }
    }
}
