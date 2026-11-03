<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ExamCatalog extends Model
{
    protected $table = 'exam_catalog';

    protected $fillable = ['name', 'category', 'price'];

    protected $casts = [
        'price' => 'float',
    ];
}
