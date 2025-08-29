<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // Insert default values
        DB::table('settings')->insert([
            ['key' => 'tds_min', 'value' => '1000'],
            ['key' => 'tds_max', 'value' => '1200']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
