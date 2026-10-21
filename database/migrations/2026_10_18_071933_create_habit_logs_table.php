<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('habit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habit_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->date('log_date');
            $table->boolean('is_done')->default(false);
            $table->text('note')->nullable();
            $table->timestamps();


            //UNIQUE contraint: satu habit hanya boleh punya Satu log per tanggal
            //ini mencegah duplikasi data keluar kalauser klik toggle berkali - kali

            $table->unique(['habit_id', 'log_date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_logs');
    }
};
