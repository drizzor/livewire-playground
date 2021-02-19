<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'amount', 'status'
    ];

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
}
