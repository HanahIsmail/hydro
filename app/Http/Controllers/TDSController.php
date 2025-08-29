<?php

namespace App\Http\Controllers;

use App\Services\ThingSpeakService;
use App\Models\Setting;

class TDSController extends Controller
{
    public function current()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        // Ambil nilai TDS dari database
        $tdsMin = Setting::where('key', 'tds_min')->first()->value ?? 1000;
        $tdsMax = Setting::where('key', 'tds_max')->first()->value ?? 1200;

        return view('pages.pengelola.tds-current', [
            'currentData' => $currentData,
            'alert' => $this->checkTDSAlert($currentData['tds'], $tdsMin, $tdsMax),
            'tdsMin' => $tdsMin,
            'tdsMax' => $tdsMax
        ]);
    }

    private function checkTDSAlert($value, $tdsMin, $tdsMax)
    {
        if ($value < $tdsMin) {
            return ['type' => 'danger', 'message' => 'Nilai TDS terlalu rendah'];
        }
        if ($value > $tdsMax) {
            return ['type' => 'danger', 'message' => 'Nilai TDS terlalu tinggi'];
        }
        return ['type' => 'success', 'message' => 'Nilai TDS normal'];
    }
}
