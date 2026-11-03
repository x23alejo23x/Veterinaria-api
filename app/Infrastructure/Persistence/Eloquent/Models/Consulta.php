<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'patient_id',
        'appointment_id',
        'vet',
        'chief_complaint',
        'diagnosis',
        'base_fee',
        'status',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'base_fee'   => 'float',
        'opened_at'  => 'datetime',
        'closed_at'  => 'datetime',
    ];
}
