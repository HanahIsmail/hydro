<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';
    protected $fillable = ['temperature', 'humidity', 'tds', 'measured_at'];
    protected $casts = [
        'measured_at' => 'datetime',
        'tds' => 'float',
        'temperature' => 'float',
        'humidity' => 'float'
    ];


    public function getStatusAttribute()
    {
        if ($this->tds < 1000) return 'danger';
        if ($this->tds > 1200) return 'danger';
        return 'success';
    }

    public function getStatusTextAttribute()
    {
        if ($this->tds < 1000) return 'Rendah';
        if ($this->tds > 1200) return 'Tinggi';
        return 'Normal';
    }

    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('measured_at', [$start, $end]);
    }

    public function scopeLast24Hours($query)
    {
        return $query->where('measured_at', '>=', now()->subHours(24));
    }
}
