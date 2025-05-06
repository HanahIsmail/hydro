<?php

namespace Database\Seeders;

use App\Models\TDSData;
use Illuminate\Database\Seeder;

class TDSDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 1000 random TDS readings
        // TDSData::factory()->count(1000)->create();
    }
}
