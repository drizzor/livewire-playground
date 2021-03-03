<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    const STATUSES = [
        'processing' => 'Processing',
        'failed' => 'Failed',
        'success' => 'Success',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $guarded = [];

    public function getStatusColorAttribute()
    {
        return [
            'processing' => 'yellow',
            'success' => 'green',
            'failed' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function getDateForHumansAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->translatedFormat('d M Y');
    }

    /**
     * Pour l'affichage de la date au format souhaité dans la boite modal
     */
    public function getCreatedAtForEditingAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * Transformation automatique de la date au format par défaut (Y-m-d H:i:s) lorsque je l'enregistre
     */
    public function setCreatedAtForEditingAttribute($value)
    {
        $this->created_at = Carbon::parse($value);
    }
}
