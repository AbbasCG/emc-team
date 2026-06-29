<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم حفظ بياناتك — EMC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; max-width: 100%; }
        body {
            font-family: 'Tajawal', sans-serif;
            background: #F8FAFC;
            color: #0F172A;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            direction: rtl;
            padding: 24px;
        }
        .success-card {
            background: #fff;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 44px 40px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            box-shadow: 0 4px 24px rgba(34,51,74,0.06);
        }
        .success-icon {
            width: 64px; height: 64px;
            background: #16A34A;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        h1 {
            font-size: 1.45rem;
            font-weight: 900;
            color: #22334A;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 0.88rem;
            color: #64748B;
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .info-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 28px;
            text-align: right;
        }
        .info-box p {
            font-size: 0.82rem;
            color: #475569;
            font-weight: 500;
            line-height: 1.7;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: #22334A;
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Tajawal', sans-serif;
            transition: background 0.18s;
        }
        .back-btn:hover { background: #1a2d42; }
        .footer-note {
            margin-top: 18px;
            font-size: 0.7rem;
            color: #94a3b8;
        }

        @media (max-width: 767px) {
            body { padding: 16px; }
            .success-card { padding: 32px 22px; }
            h1 { font-size: 1.25rem; }
            .back-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="success-icon">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1>تم حفظ بياناتك بنجاح</h1>
    <p class="subtitle">
        شكراً لك. تم تسجيل بياناتك وإضافتك مباشرةً للقسم المختار في نظام المتطوعين.
    </p>

    <div class="info-box">
        <p>تم حفظ بياناتك الشخصية والوظيفية.</p>
        <p>تم تعيينك للقسم الذي اخترته.</p>
        <p>يمكنك تحديث بياناتك في أي وقت بتعبئة الاستمارة مجدداً.</p>
    </div>

    <a href="{{ route('volunteer.apply') }}" class="back-btn">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 19l-7-7 7-7M19 12H5"/></svg>
        تعبئة استمارة أخرى
    </a>

    <p class="footer-note">&copy; {{ date('Y') }} EMC</p>
</div>

</body>
</html>
