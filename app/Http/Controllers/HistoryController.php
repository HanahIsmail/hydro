<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function monthly(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));

        $monthlyData = SensorData::whereYear('measured_at', $selectedYear)
            ->get()
            ->groupBy(function($item) {
                return $item->measured_at->format('Y-m');
            });

        $availableYears = SensorData::selectRaw('YEAR(measured_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->pluck('year');

        $chartData = [
            'labels' => [],
            'averages' => [],
            'minimums' => [],
            'maximums' => [],
            'statuses' => []
        ];

        foreach ($monthlyData as $month => $data) {
            $avg = $data->avg('tds');

            $chartData['labels'][] = Carbon::parse($month)->isoFormat('MMM YYYY');
            $chartData['averages'][] = round($avg, 2);
            $chartData['minimums'][] = $data->min('tds');
            $chartData['maximums'][] = $data->max('tds');
            $chartData['statuses'][] = ($avg < 1000 || $avg > 1200) ? 'danger' : 'success';
        }

        return view('pages.pemilik.history-monthly', compact(
            'monthlyData',
            'chartData',
            'availableYears',
            'selectedYear'
        ));
    }

    public function hourly(Request $request)
    {
        $selectedDate = Carbon::parse($request->get('date', now()->format('Y-m-d')));

        $hourlyData = SensorData::whereDate('measured_at', $selectedDate)
            ->orderBy('measured_at')
            ->get();

        $chartData = [
            'labels' => $hourlyData->map(fn($item) => $item->measured_at->format('H:i')),
            'values' => $hourlyData->pluck('tds')
        ];

        return view('pages.pengelola.history-hourly', compact(
            'hourlyData',
            'chartData',
            'selectedDate'
        ));
    }
}
