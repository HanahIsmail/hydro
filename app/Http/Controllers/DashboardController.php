<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SensorData;
use App\Models\Setting;
use App\Services\ThingSpeakService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->roles == 'Pemilik') {
            return $this->ownerDashboard();
        }
        return $this->managerDashboard();
    }

    protected function ownerDashboard()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        $managers = User::where('roles', 'Pengelola')->get();

        $monthlyData = SensorData::where('measured_at', '>=', now()->subMonths(12))
            ->get()
            ->groupBy(function ($item) {
                return $item->measured_at->format('Y-m');
            });

        // Ambil nilai TDS dari database
        $tdsMin = Setting::where('key', 'tds_min')->first()->value ?? 1000;
        $tdsMax = Setting::where('key', 'tds_max')->first()->value ?? 1200;

        $chartData = [
            'labels' => [],
            'averages' => [],
            'statuses' => []
        ];

        foreach ($monthlyData as $month => $data) {
            $avgTds = $data->avg('tds');

            $chartData['labels'][] = Carbon::parse($month)->isoFormat('MMM YYYY');
            $chartData['averages'][] = round($avgTds, 2);
            $chartData['statuses'][] = ($avgTds < $tdsMin || $avgTds > $tdsMax) ? 'danger' : 'success';
        }

        return view('pages.pemilik.dashboard', compact(
            'managers',
            'currentData',
            'chartData',
            'tdsMin',
            'tdsMax'
        ));
    }

    protected function managerDashboard()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        $hourlyData = SensorData::where('measured_at', '>=', now()->subHours(24))
            ->orderBy('measured_at')
            ->get();

        // Ambil nilai TDS dari database
        $tdsMin = Setting::where('key', 'tds_min')->first()->value ?? 1000;
        $tdsMax = Setting::where('key', 'tds_max')->first()->value ?? 1200;

        $hourlyChart = [
            'labels' => $hourlyData->map(fn($item) => $item->measured_at->format('H:i')),
            'values' => $hourlyData->pluck('tds')
        ];

        return view('pages.pengelola.dashboard', compact(
            'currentData',
            'hourlyChart',
            'tdsMin',
            'tdsMax'
        ));
    }
}
