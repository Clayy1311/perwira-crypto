<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    public function status()
    {
        $latestPayment = auth()->user()->modules()->latest()->first();
        
        return view('user.payment-status', [
            'payment' => $latestPayment,
            'is_approved' => $latestPayment?->status === 'active' && 
                             $latestPayment?->status_approved === 'approved'
        ]);
    }
}