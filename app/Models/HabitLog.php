<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'habit_id',
        'user_id',
        'log_date',
        'is_done',
        'note',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'log_date' => 'date', //otomatis jadi objek Carbon saat diakses
    ];

    //HabitLog MILIK satu habit
    public function habit () {
        return $this->belongsTo(Habit::class);
    }

    //HabitLog MILIK satu User
    public function user () {
        return $this->belongsTo(User::class);
    }

}


//kenapa 'log_date' => 'date' di casts ?
// kalau tidak di-cast, log_date yang dari database akan terbaca
// sebagai string biasa '2024-10-18'. Dengan cast 'date',
// laravel otomatis mengubahnya jadi objek Carbon - Library tanggal super
// powerful yang bisa anda pakai untuk perhitungan seperti
// $log->log_date->format('d M Y') atau $log->log_date->isToday().