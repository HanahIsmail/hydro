<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TDSData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'tds_data'; 

    protected $fillable = [
        'value',
        'sensor_id',
        'measured_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'measured_at' => 'datetime',
        'value' => 'float'
    ];

    /**
     * Scope for filtering by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('measured_at', [$startDate, $endDate]);
    }

    /**
     * Scope for hourly data
     */
    public function scopeHourly($query, $hours = 24)
    {
        return $query->where('measured_at', '>=', now()->subHours($hours))
                    ->orderBy('measured_at');
    }

    /**
     * Scope for monthly data
     */
    public function scopeMonthly($query, $months = 12)
    {
        return $query->where('measured_at', '>=', now()->subMonths($months))
                    ->orderBy('measured_at');
    }

    /**
     * Check if TDS value is in normal range
     */
    public function isNormal()
    {
        return $this->value >= 1000 && $this->value <= 1200;
    }

    /**
     * Get alert status
     */
    public function alertStatus()
    {
        if ($this->value < 1000) {
            return 'low';
        } elseif ($this->value > 1200) {
            return 'high';
        }
        return 'normal';
    }
}
