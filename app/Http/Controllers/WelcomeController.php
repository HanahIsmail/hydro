<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ThingSpeakService;

class WelcomeController extends Controller
{
    public function index()
    {
        $service = new ThingSpeakService();
        $currentData = $service->getLatestData();

        return view('welcome', [
            'currentData' => $currentData,
            'location' => [
                'name' => 'Panti Asuhan Al Inayah, Gorontalo',
                'address' => 'Jl. Sapta Marga, Timbuolo Tim., Kec. Botupingge, Kabupaten Bone Bolango, Gorontalo 96112',
                'maps_url' => 'https://www.google.com/maps/place/Panti+Asuhan+Al+Inayah,+Gorontalo/@0.5232751,123.1084125,17z/data=!3m1!4b1!4m6!3m5!1s0x327ed513dd588afb:0xa630247b9a87388a!8m2!3d0.5232751!4d123.1084125!16s%2Fg%2F11c6q8cx_8?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D'
            ]
        ]);
    }
}
