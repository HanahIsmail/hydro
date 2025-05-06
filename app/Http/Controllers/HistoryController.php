<?php

namespace App\Http\Controllers;

use App\Models\TDSData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function monthly(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));

        $monthlyData = TDSData::whereYear('measured_at', $selectedYear)
            ->get()
            ->groupBy(function($item) {
                return $item->measured_at->format('Y-m');
            });

        $availableYears = TDSData::selectRaw('YEAR(measured_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->pluck('year');

        $chartData = [
            'labels' => [],
            'averages' => [],
            'minimums' => [],
            'maximums' => [],
            'colors' => []
        ];

        foreach ($monthlyData as $month => $data) {
            $avg = $data->avg('value');

            $chartData['labels'][] = \Carbon\Carbon::parse($month)->isoFormat('MMM YYYY');
            $chartData['averages'][] = round($avg, 2);
            $chartData['minimums'][] = $data->min('value');
            $chartData['maximums'][] = $data->max('value');
            $chartData['colors'][] = $avg < 1000 || $avg > 1200 ? '#fc544b' : '#6777ef';
        }

        return view('pages.pemilik.history-monthly', compact('monthlyData', 'chartData', 'availableYears', 'selectedYear'));
    }

    public function hourly(Request $request)
    {
        $selectedDate = Carbon::parse($request->get('date', now()->format('Y-m-d')));

        $hourlyData = TDSData::whereDate('measured_at', $selectedDate)
            ->orderBy('measured_at')
            ->get();

        $chartData = [
            'labels' => $hourlyData->map(fn($item) => $item->measured_at->format('H:i')),
            'values' => $hourlyData->pluck('value')
        ];

        return view('pages.pengelola.history-hourly', compact('hourlyData', 'chartData', 'selectedDate'));
    }
}
