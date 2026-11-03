<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'name', 'category', 'stock', 'unit',
        'price', 'supplier', 'expiry_date', 'status',
    ];

    protected $casts = [
        'stock'       => 'integer',
        'price'       => 'float',
        'expiry_date' => 'date',
    ];
}
