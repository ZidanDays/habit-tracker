<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReflection extends Model
{
    //

    protected $fillable = [
        'user_id',
        'reflection_date',
        'content'
    ];

    // $casts = instruksi ke laravel tentang tipe data setiap kolom
    // tanpa ini, kolom boolean dari DB akan terbaca sebagai string "0" atau "1"
    // Dengan casts, Laravel otomatis konversi ke true/false
    protected $casts = [
        'reflection_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
