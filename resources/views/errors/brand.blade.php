{{-- Branded error page. Self-contained (no build assets, no database) so it still works when something is broken. --}}
@php
    $isAr = (rescue(fn () => session('locale'), null, false) ?? 'ar') !== 'en';
    $wa = rescue(fn () => \App\Models\SiteSetting::current()['whatsapp'] ?? null, null, false);
@endphp
<!DOCTYPE html>
<html lang="{{ $isAr ? 'ar' : 'en' }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('heading') - {{ $isAr ? 'مركز مطمئنة' : 'Motmaena Center' }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500;800;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; }
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px 16px; font-family: 'Tajawal', system-ui, sans-serif; background: #faf6f1; color: #1c1917; text-align: center; }
        .card { width: 100%; max-width: 440px; background: #fff; border: 1px solid #efe5e0; border-radius: 28px; padding: 36px 24px; box-shadow: 0 30px 60px -40px rgba(74,15,27,.45); }
        .logo { height: 52px; margin-bottom: 22px; }
        .code { font-size: 64px; font-weight: 900; line-height: 1; color: #c9a35c; margin-bottom: 8px; }
        h1 { font-size: 24px; font-weight: 900; margin-bottom: 10px; }
        p { color: #57534e; font-weight: 500; line-height: 1.8; margin-bottom: 26px; }
        .btns { display: flex; flex-direction: column; gap: 10px; }
        a { display: block; padding: 14px 20px; border-radius: 16px; font-weight: 900; text-decoration: none; }
        .primary { background: #6d1b2b; color: #fff; }
        .ghost { border: 1.5px solid #e7d3cc; color: #6d1b2b; }
        .wa { color: #128c4a; font-size: 14px; padding: 8px; }
        @media (prefers-color-scheme: dark) {
            body { background: #120d0e; color: #fff; }
            .card { background: #1a1415; border-color: rgba(255,255,255,.08); }
            p { color: #d6d3d1; }
            .ghost { color: #ead8b1; border-color: rgba(255,255,255,.2); }
        }
    </style>
</head>
<body>
    <main class="card">
        <img class="logo" src="/logo.png" alt="{{ $isAr ? 'مركز مطمئنة' : 'Motmaena Center' }}">
        <div class="code">@yield('code')</div>
        <h1>@yield('heading')</h1>
        <p>@yield('message')</p>
        <div class="btns">
            @yield('action')
            <a class="ghost" href="/">{{ $isAr ? 'الصفحة الرئيسية' : 'Home page' }}</a>
            @if($wa)
                <a class="wa" href="https://wa.me/{{ $wa }}" target="_blank">{{ $isAr ? 'تحتاج مساعدة؟ كلّمنا عالواتساب' : 'Need help? WhatsApp us' }}</a>
            @endif
        </div>
    </main>
</body>
</html>
