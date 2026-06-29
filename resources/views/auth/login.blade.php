<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول — نظام إدارة المتطوعين EMC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            background: #F8FAFC;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Tajawal', 'Cairo', sans-serif;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        input, button { font-family: 'Tajawal', sans-serif; }

        .login-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 20px;
            padding: 40px 44px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 40px rgba(34,51,74,0.10);
            animation: fadeUp 0.35s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-logo {
            width: 52px;
            height: 52px;
            background: #EC943C;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 6px 20px rgba(236,148,60,0.35);
        }

        .login-input {
            width: 100%;
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 0.9rem;
            color: #0F172A;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .login-input:focus {
            border-color: #2691C2;
            box-shadow: 0 0 0 3px rgba(38,145,194,0.15);
        }
        .login-input::placeholder { color: #94a3b8; }

        .login-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            letter-spacing: 0.03em;
        }

        .login-btn {
            width: 100%;
            background: #EC943C;
            color: #fff;
            border: none;
            border-radius: 9px;
            padding: 13px;
            font-size: 0.9rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 4px;
        }
        .login-btn:hover {
            background: #d4822e;
            box-shadow: 0 6px 20px rgba(236,148,60,0.4);
            transform: translateY(-1px);
        }
        .login-btn:active { transform: translateY(0); }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .sidebar-strip {
            position: fixed;
            top: 0; right: 0;
            width: 6px; height: 100vh;
            background: linear-gradient(180deg, #EC943C 0%, #2691C2 100%);
        }

        @media (max-width: 767px) {
            body { padding: 16px; align-items: flex-start; padding-top: 32px; }
            .login-card { padding: 28px 22px; border-radius: 16px; }
            .sidebar-strip { width: 4px; }
        }
    </style>
</head>
<body>
    <div class="sidebar-strip"></div>

    <div class="login-card">
        {{-- Logo + Title --}}
        <div style="text-align:center; margin-bottom:28px;">
            <div class="login-logo">
                <svg width="26" height="26" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h1 style="font-size:1.3rem;font-weight:900;color:#22334A;margin:0 0 6px;">نظام إدارة المتطوعين</h1>
            <p style="font-size:0.78rem;color:#64748B;margin:0;">EMC Volunteer Management System</p>
        </div>

        {{-- Alerts --}}
        @if(session('status'))
        <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom:18px;">
                <label class="login-label">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="login-input" placeholder="admin@emc.org">
            </div>

            <div style="margin-bottom:18px;">
                <label class="login-label">كلمة المرور</label>
                <input type="password" name="password" required
                       class="login-input" placeholder="••••••••">
            </div>

            <div style="display:flex;align-items:center;gap:8px;margin-bottom:22px;">
                <input type="checkbox" name="remember" id="remember"
                       style="width:16px;height:16px;accent-color:#EC943C;cursor:pointer;">
                <label for="remember" style="font-size:0.82rem;color:#64748B;cursor:pointer;font-weight:500;">تذكّرني</label>
            </div>

            <button type="submit" class="login-btn">
                دخول إلى لوحة التحكم
            </button>
        </form>

        {{-- Divider --}}
        <div style="display:flex;align-items:center;gap:12px;margin:20px 0 0;">
            <div style="flex:1;height:1px;background:#E2E8F0;"></div>
            <span style="font-size:0.72rem;color:#94a3b8;white-space:nowrap;">أو</span>
            <div style="flex:1;height:1px;background:#E2E8F0;"></div>
        </div>

        {{-- Public form link --}}
        <a href="{{ route('volunteer.apply') }}"
           style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:14px;padding:11px;border:1.5px solid #E2E8F0;border-radius:9px;color:#22334A;font-size:0.855rem;font-weight:700;text-decoration:none;transition:all 0.18s;background:#fff;"
           onmouseover="this.style.background='#F8FAFC';this.style.borderColor='#2691C2';this.style.color='#2691C2';"
           onmouseout="this.style.background='#fff';this.style.borderColor='#E2E8F0';this.style.color='#22334A';">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
            استمارة بيانات المتطوعين
        </a>

        <p style="text-align:center;margin-top:20px;font-size:0.68rem;color:#cbd5e1;">
            &copy; {{ date('Y') }} EMC — جميع الحقوق محفوظة
        </p>
    </div>
</body>
</html>
