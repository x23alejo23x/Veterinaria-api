<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalHistory extends Model
{
    protected $table = 'medical_histories';

    protected $fillable = [
        'patient_id', 'vet_id', 'date', 'type',
        'diagnosis', 'treatment', 'notes', 'weight', 'temperature',
    ];

    protected $casts = [
        'date'        => 'date',
        'weight'      => 'float',
        'temperature' => 'float',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
