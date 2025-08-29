<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $tdsMin = Setting::where('key', 'tds_min')->first()->value ?? 1000;
        $tdsMax = Setting::where('key', 'tds_max')->first()->value ?? 1200;

        return view('pages.settings.index', compact('tdsMin', 'tdsMax'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tds_min' => 'required|numeric',
            'tds_max' => 'required|numeric|gt:tds_min',
        ]);

        Setting::updateOrCreate(
            ['key' => 'tds_min'],
            ['value' => $request->tds_min]
        );

        Setting::updateOrCreate(
            ['key' => 'tds_max'],
            ['value' => $request->tds_max]
        );

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan TDS berhasil diperbarui!');
    }
}
