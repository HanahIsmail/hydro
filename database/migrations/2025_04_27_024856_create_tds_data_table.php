<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('temperature');
            $table->float('humidity');
            $table->float('tds');
            $table->timestamp('measured_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_data');
    }
};
