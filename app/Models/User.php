<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // <-- Implement interface
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_approved' // <-- Tambahkan jika menggunakan approval manual
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
            'is_approved' => 'boolean', // <-- Tambahkan casting
        ];
    }
    protected static function booted()
    {
        static::deleting(function ($user) {
            // Hapus semua user_modules yang terkait dengan user ini
            $user->modules()->delete();
            // Anda bisa juga menghapus relasi lain jika ada, misal:
            // $user->posts()->delete();
            // $user->payments()->delete();
        });
    }
    
    public function hasPendingModule(): bool
    {
        // Asumsi 'status_approved' di tabel user_modules bisa bernilai 'pending'
        return $this->modules()->where('status_approved', 'pending')->exists();
    }
    // Relasi ke modul user
    public function modules()
    {
        return $this->hasMany(UserModule::class);
    }

    // Cek modul aktif
    public function hasActiveModule()
    {
        return $this->modules()->where('status_approved', 'approved')->exists();
    }

    // Cek role admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ===== Tambahan Baru =====
    
    // Cek apakah user sudah verified email
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    // Untuk notifikasi
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    // Cek apakah punya modul approved (alternatif)
    public function approvedModules()
    {
        return $this->modules()->where('status_approved', 'approved');
    }
}