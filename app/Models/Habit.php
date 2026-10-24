<?php

namespace App\Models;

use App\Models\Category;
use App\Models\HabitLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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


    //$casts = instruksi kek laravel tentang tipe data setiap kolom
    // tanpa ini, kolom boolean dari DB akan terbaca sebagai string "0" atau "1"
    //dengan casts, larabel otomatis konversi ke true/false

    protected $casts = [
        'is_active' => 'boolean',
    ];


    //relasi


    //relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relasi ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //relasi ke habitlog
    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }




    //======================================================
    //HELPER METHOD - LOGIKA YANG SERNG DIPAKI BERULANG ULANG, SEHINGGA LEBIH BAIK DIBUATKAN METHOD SENDIRI
    //======================================================



    //cek apakah habit ini sudah di-done pada tanggal tertentu
    // contoh penggunaan: $habit->isDoneOn('2024-10-18')
    public function isDoneOn(string $date): bool
    {
        return $this->logs()
                    ->where('log_date', $date)
                    ->where('is_done', true)
                    ->exists(); //exist() lebih efisien dari count() >0
    }

    
    //ambil log untuk tanggal tertentu
    //Contoh Penggunaan: $habit-?logForDate('2024-10-18)
    public function logForDate(string $date)
    {
        return $this->logs()
                    ->where('log_date', $date)
                    ->first(); // first() = ambil satu record pertama, atau null jika tidak ada record
    }
    

    //hitung streak saat ini (berapa hari ini berturut-turut selesai)
    public function currentStreak(): int
    {
        $streak = 0;
        //mulai dari kemarin (bukan hari ini, karena hari ini mungkin belum selesai)
        $date = now()->subDay()->toDateString();

        //kalau hari ini sudah done, mulai hitungan dari hari ini
        if ($this->isDoneOn(now()->toDateString())) {
            $date = now()->toDateString();
        }

        // loop mundur selama masih ada log yang done
        while ($this->isDoneOn($date)) {
            $streak++;
            // kurangi satu hari, pakai Carbon (library tanggal bawaan laravel)
            $date = \Carbon\Carbon::parse($date)->subDay()->toDateString();
        }

        return $streak;

    }

}



//apa itu helper method?
// helper method adalah funsi tambahan yang kita tulis sendiri dalam
// modeluntuk memudahkan pekerjaan berulang
// isDoneOn(), logForDate(), dan currentStreak() adalah logika yang akan
// kitapakai berkali - kali di controller dan view - jadi lebik baik
// ditulis sekali di model daripada copy-paste di mana - mana
