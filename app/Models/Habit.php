<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'color',
        'icon',
        'frequency',
        'is_active',
        'sort_order',
        'reminder_time',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    
}
