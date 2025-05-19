<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SensorData;
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

        $chartData = [
            'labels' => [],
            'averages' => [],
            'statuses' => []
        ];

        foreach ($monthlyData as $month => $data) {
            $avgTds = $data->avg('tds');

            $chartData['labels'][] = Carbon::parse($month)->isoFormat('MMM YYYY');
            $chartData['averages'][] = round($avgTds, 2);
            $chartData['statuses'][] = ($avgTds < 1000 || $avgTds > 1200) ? 'danger' : 'success';
        }

        return view('pages.pemilik.dashboard', compact(
            'managers',
            'currentData',
            'chartData'
        ));
    }

    protected function managerDashboard()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        $hourlyData = SensorData::where('measured_at', '>=', now()->subHours(24))
            ->orderBy('measured_at')
            ->get();

        $hourlyChart = [
            'labels' => $hourlyData->map(fn($item) => $item->measured_at->format('H:i')),
            'values' => $hourlyData->pluck('tds')
        ];

        return view('pages.pengelola.dashboard', compact(
            'currentData',
            'hourlyChart'
        ));
    }
}
