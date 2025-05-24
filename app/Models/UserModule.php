<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_type',
        'expiry_date',
        'payment_method',
        'amount',
        'status',          // existing (active/inactive)
        'status_approved', // baru (pending/approved/rejected)
        'admin_notes'
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'string',          // tambahkan ini
        'status_approved' => 'string',
        'is_admin' => 'boolean'   // tambahkan ini
    ];

    // Scope untuk status existing
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Scope untuk status approval
    public function scopePendingApproval($query)
    {
        return $query->where('status_approved', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_approved', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_approved', 'rejected');
    }

    // Helper method
    public function isActiveAndApproved()
    {
        return $this->status === 'active' && $this->status_approved === 'approved';
    }
    public function user()
    {
        // Asumsi kolom foreign key di tabel 'user_modules' adalah 'user_id'
        // dan model user adalah App\Models\User
        return $this->belongsTo(User::class);
    }

}