<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ThingSpeakService;
use App\Models\SensorData;
use Carbon\Carbon;

class SyncThingSpeak extends Command
{
    protected $signature = 'sync:thingspeak';
    protected $description = 'Sync data from ThingSpeak to local database';

    public function handle()
    {
        $service = new ThingSpeakService();
        $data = $service->getLatestData();

        SensorData::updateOrCreate(
            ['measured_at' => $data['measured_at']],
            [
                'temperature' => $data['temperature'],
                'humidity' => $data['humidity'],
                'tds' => $data['tds']
            ]
        );

        $this->info('Data berhasil disinkronisasi: ' . $data['measured_at']);
    }
}
