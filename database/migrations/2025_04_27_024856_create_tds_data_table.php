<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tds_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 8, 2); // TDS value with 2 decimal places
            $table->string('sensor_id')->nullable(); // For multiple sensors
            $table->timestamp('measured_at')->useCurrent(); // When measurement was taken
            $table->timestamps();

            // Indexes for better performance
            $table->index('measured_at');
            $table->index('sensor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tds_data');
    }
};
