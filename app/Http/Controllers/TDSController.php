<?php

namespace App\Http\Controllers;

use App\Services\ThingSpeakService;

class TDSController extends Controller
{
    public function current()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        return view('pages.pengelola.tds-current', [
            'currentData' => $currentData,
            'alert' => $this->checkTDSAlert($currentData['tds'])
        ]);
    }

    private function checkTDSAlert($value)
    {
        if ($value < 1000) {
            return ['type' => 'danger', 'message' => 'Nilai TDS terlalu rendah'];
        }
        if ($value > 1200) {
            return ['type' => 'danger', 'message' => 'Nilai TDS terlalu tinggi'];
        }
        return ['type' => 'success', 'message' => 'Nilai TDS normal'];
    }
}
