<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationBooking;

class ConsultationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'phone'        => 'required|string|max:20',
            'problem_type' => 'required|string|max:80',
            'notes'        => 'nullable|string|max:300',
        ]);

        ConsultationBooking::create($data);

        $type  = $data['problem_type'];
        $phone = $data['phone'];
        $notes = $data['notes'] ?? '';

        $msg = "مرحباً مركز مطمئنة،\nأريد حجز استشارة\n\n📱 رقم التواصل: {$phone}\n📋 نوع الاستشارة: {$type}";
        if ($notes) {
            $msg .= "\n📝 تفاصيل إضافية: {$notes}";
        }

        return redirect('https://wa.me/96555665161?text=' . urlencode($msg));
    }

    public function admin(Request $request)
    {
        $key = env('ADMIN_KEY', 'motmaena-admin-2025');

        if ($request->get('key') === $key) {
            session(['admin_auth' => true]);
        }

        if (!session('admin_auth')) {
            return view('admin.login');
        }

        $bookings = ConsultationBooking::latest()->get();

        $stats = [
            'total'     => $bookings->count(),
            'pending'   => $bookings->where('status', 'pending')->count(),
            'contacted' => $bookings->where('status', 'contacted')->count(),
            'done'      => $bookings->where('status', 'done')->count(),
        ];

        return view('admin.consultations', compact('bookings', 'stats'));
    }

    public function updateStatus(Request $request, ConsultationBooking $booking)
    {
        $request->validate(['status' => 'required|in:pending,contacted,done']);
        $booking->update(['status' => $request->status]);
        return back();
    }
}
