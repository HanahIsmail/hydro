<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\TDSData;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan role user
     */
    public function index()
    {
        if (auth()->user()->roles == 'Pemilik') {
            return $this->ownerDashboard();
        } else {
            return $this->managerDashboard();
        }
    }

    /**
     * Dashboard untuk Pemilik
     */
    protected function ownerDashboard()
    {
        // Data pengelola
        $managers = User::where('roles', 'Pengelola')->get();

        // Data statistik TDS
        $currentTDS = TDSData::latest('measured_at')->first();

        // Data bulanan untuk chart
        $monthlyData = TDSData::where('measured_at', '>=', now()->subMonths(12))
            ->get()
            ->groupBy(function($item) {
                return $item->measured_at->format('Y-m');
            });

        $chartData = [
            'labels' => [],
            'averages' => [],
            'colors' => []
        ];

        foreach ($monthlyData as $month => $data) {
            $avg = $data->avg('value');

            $chartData['labels'][] = \Carbon\Carbon::parse($month)->isoFormat('MMM YYYY');
            $chartData['averages'][] = round($avg, 2);
            $chartData['colors'][] = $avg < 1000 || $avg > 1200 ? '#fc544b' : '#6777ef';
        }

        return view('pages.pemilik.dashboard', compact(
            'managers',
            'currentTDS',
            'chartData'
        ));
    }

    /**
     * Dashboard untuk Pengelola
     */
    protected function managerDashboard()
    {
        $currentTDS = TDSData::latest('measured_at')->first();
        $hourlyData = TDSData::where('measured_at', '>=', now()->subHours(24))
            ->orderBy('measured_at')
            ->get();

        $hourlyChart = [
            'labels' => $hourlyData->map(fn($item) => $item->measured_at->format('H:i')),
            'values' => $hourlyData->pluck('value')
        ];

        return view('pages.pengelola.dashboard', compact('currentTDS', 'hourlyChart'));
    }
}
