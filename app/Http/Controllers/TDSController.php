<?php

namespace App\Http\Controllers;

use App\Models\TDSData;
use Illuminate\Http\Request;

class TDSController extends Controller
{
    /**
     * Display current TDS reading
     */
    public function current()
    {
        $currentTDS = TDSData::latest('measured_at')->first();

        return view('pages.pengelola.tds-current', [
            'currentTDS' => $currentTDS,
            'alert' => $currentTDS ? $this->checkTDSAlert($currentTDS->value) : null
        ]);
    }

    /**
     * Check if TDS value is out of range
     */
    protected function checkTDSAlert($value)
    {
        if ($value < 1000) {
            return [
                'type' => 'danger',
                'message' => 'Nilai TDS terlalu rendah (minimal 1000)'
            ];
        } elseif ($value > 1200) {
            return [
                'type' => 'danger',
                'message' => 'Nilai TDS terlalu tinggi (maksimal 1200)'
            ];
        }

        return [
            'type' => 'success',
            'message' => 'Nilai TDS dalam rentang normal'
        ];
    }

    /**
     * Store new TDS reading (for API)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|numeric|min:0|max:2000',
            'sensor_id' => 'nullable|string'
        ]);

        $tdsData = TDSData::create([
            'value' => $validated['value'],
            'sensor_id' => $validated['sensor_id'] ?? 'default',
            'measured_at' => now()
        ]);

        // Check for alert condition
        if (!$tdsData->isNormal()) {
            // You could trigger notifications here
        }

        return response()->json([
            'status' => 'success',
            'data' => $tdsData,
            'alert' => $tdsData->alertStatus()
        ]);
    }
}
