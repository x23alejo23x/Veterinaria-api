<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaHospitalization extends Model
{
    protected $table = 'consulta_hospitalizations';

    protected $fillable = [
        'consulta_id',
        'days',
        'price_per_day',
        'notes',
    ];

    protected $casts = [
        'price_per_day' => 'float',
    ];
}
