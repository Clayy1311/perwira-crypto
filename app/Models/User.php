<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon; // <--- PENTING: Tambahkan ini untuk menggunakan Carbon

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Hapus semua user_modules yang terkait dengan user ini
            $user->modules()->delete();
        });
    }

    // Relasi ke modul user
    public function modules()
    {
        return $this->hasMany(UserModule::class);
    }

    // Cek apakah user punya modul dengan status 'pending'
    public function hasPendingModule(): bool
    {
        return $this->modules()->where('status_approved', 'pending')->exists();
    }

    // Cek apakah user punya modul yang BENAR-BENAR AKTIF (approved DAN belum kedaluwarsa)
    public function hasActiveModule(): bool
    {
        return $this->modules()
                    ->where('status_approved', 'approved')
                    ->where(function($query) {
                        // Kondisi untuk modul Lifetime: expiry_date adalah NULL
                        $query->whereNull('expiry_date') // <-- Ubah di sini
                              // ATAU Kondisi untuk modul 1 Tahun (yearly): expiry_date di masa depan
                              ->orWhere('expiry_date', '>', Carbon::now()); // <-- Ubah di sini
                    })
                    ->exists();
    }

    // Cek role admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user sudah memverifikasi email
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    // Untuk notifikasi email
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    // Ini adalah metode tambahan yang fungsinya mirip dengan hasActiveModule,
    // tapi mungkin digunakan untuk query saja.
    public function approvedModules()
    {
        return $this->modules()
                    ->where('status_approved', 'approved')
                    ->where(function($query) {
                        $query->whereNull('expiry_date') // <-- Ubah di sini
                              ->orWhere('expiry_date', '>', Carbon::now()); // <-- Ubah di sini
                    });
    }
}