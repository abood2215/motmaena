<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationBooking;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $msg  = "مرحباً مركز مطمئنة،\n";
        $msg .= "أريد حجز استشارة\n\n";
        $msg .= "*رقم التواصل:* {$phone}\n";
        $msg .= "*نوع الاستشارة:* {$type}";
        if ($notes) {
            $msg .= "\n*ملاحظات:* {$notes}";
        }

        return redirect('https://wa.me/96555665161?text=' . rawurlencode($msg));
    }

    public function adminLogin(Request $request)
    {
        $key = env('ADMIN_KEY', 'motmaena-admin-2025');

        if ($request->input('password') === $key) {
            session(['admin_auth' => true]);
            return redirect()->route('admin.consultations');
        }

        return back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
    }

    public function admin(Request $request)
    {
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

        // Chart data: bookings per day for last 14 days
        $chartData = ConsultationBooking::selectRaw("date(created_at) as day, count(*) as cnt")
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('cnt', 'day');

        $days = collect();
        for ($i = 13; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $days[$d] = $chartData[$d] ?? 0;
        }

        // Type breakdown
        $typeBreakdown = ConsultationBooking::selectRaw("problem_type, count(*) as cnt")
            ->groupBy('problem_type')
            ->orderByDesc('cnt')
            ->get();

        return view('admin.consultations', compact('bookings', 'stats', 'days', 'typeBreakdown'));
    }

    public function adminLogout()
    {
        session()->forget('admin_auth');
        return redirect()->route('admin.consultations');
    }

    public function updateStatus(Request $request, ConsultationBooking $booking)
    {
        if (!session('admin_auth')) abort(403);
        $request->validate(['status' => 'required|in:pending,contacted,done']);
        $booking->update(['status' => $request->status]);
        return back();
    }

    public function updateNotes(Request $request, ConsultationBooking $booking)
    {
        if (!session('admin_auth')) abort(403);
        $request->validate(['admin_notes' => 'nullable|string|max:1000']);
        $booking->update(['admin_notes' => $request->admin_notes]);
        return response()->json(['ok' => true]);
    }

    public function exportCsv()
    {
        if (!session('admin_auth')) abort(403);

        $bookings = ConsultationBooking::latest()->get();

        $response = new StreamedResponse(function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['#', 'رقم الهاتف', 'نوع الاستشارة', 'الملاحظات', 'ملاحظات الإدارة', 'الحالة', 'التاريخ']);
            foreach ($bookings as $b) {
                fputcsv($handle, [
                    $b->id,
                    $b->phone,
                    $b->problem_type,
                    $b->notes,
                    $b->admin_notes,
                    $b->status,
                    $b->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="consultations-' . now()->format('Y-m-d') . '.csv"');
        return $response;
    }

    public function diag()
    {
        $e1 = '%F0%9F%93%B1';
        $e2 = '%F0%9F%93%8B';
        $gitHash = trim(shell_exec('git -C ' . base_path() . ' rev-parse --short HEAD') ?? 'unknown');
        $phpVer  = PHP_VERSION;
        $emoji   = "\xF0\x9F\x93\xB1";
        $mbEmoji = mb_convert_encoding(pack('N', 0x1F4F1), 'UTF-8', 'UCS-4BE');
        $testUrl = 'https://wa.me/96555665161?text=' . $e1 . '%20' . rawurlencode('رقم: 12345') . '%0A' . $e2 . '%20' . rawurlencode('نوع: اختبار');
        echo "<meta charset='utf-8'><style>body{font-family:monospace;padding:20px;direction:rtl}</style>";
        echo "<h2>تشخيص الموقع</h2>";
        echo "<p><b>Git hash:</b> {$gitHash}</p>";
        echo "<p><b>PHP:</b> {$phpVer}</p>";
        echo "<p><b>\\xF0\\x9F\\x93\\xB1 hex escape:</b> " . mb_strlen($emoji) . " char(s) — hex: " . bin2hex($emoji) . "</p>";
        echo "<p><b>mb_convert_encoding:</b> " . bin2hex($mbEmoji) . "</p>";
        echo "<p><b>رابط الاختبار:</b> <a href='{$testUrl}' target='_blank'>افتح واتساب</a></p>";
        echo "<p><b>URL كامل:</b> <code>" . htmlspecialchars($testUrl) . "</code></p>";
        echo "<p>إذا فتح واتساب وظهرت الإيموجي → الكود صح والمشكلة في المتصفح/الجهاز</p>";
    }

    public function newCount()
    {
        if (!session('admin_auth')) abort(403);
        $count = ConsultationBooking::where('status', 'pending')
            ->where('created_at', '>=', now()->subHour())
            ->count();
        return response()->json(['count' => $count]);
    }
}
