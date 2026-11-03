<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaExam extends Model
{
    protected $table = 'consulta_exams';

    protected $fillable = [
        'consulta_id',
        'name',
        'category',
        'unit_price',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'float',
    ];
}
