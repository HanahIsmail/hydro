<?php

use App\Models\Setting;

if (!function_exists('getTdsMin')) {
    function getTdsMin()
    {
        return Setting::where('key', 'tds_min')->first()->value ?? 1000;
    }
}

if (!function_exists('getTdsMax')) {
    function getTdsMax()
    {
        return Setting::where('key', 'tds_max')->first()->value ?? 1200;
    }
}
