<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'patient_id', 'medication_id', 'dose', 'frequency',
        'duration', 'notes', 'status', 'vet', 'date',
    ];

    protected $casts = [
        'patient_id'    => 'integer',
        'medication_id' => 'integer',
        'date'          => 'date',
    ];
}
