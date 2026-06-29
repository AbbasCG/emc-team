<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') — EMC Volunteer System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #F8FAFC;
            color: #0F172A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .error-container {
            text-align: center;
            max-width: 480px;
        }
        .error-code {
            font-size: 7rem;
            font-weight: 900;
            color: #E2E8F0;
            line-height: 1;
            margin-bottom: 8px;
            letter-spacing: -4px;
        }
        .error-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 900;
            color: #22334A;
            margin-bottom: 12px;
        }
        .error-description {
            font-size: 0.9rem;
            color: #64748B;
            line-height: 1.7;
            margin-bottom: 32px;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: #2691C2;
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-home:hover { background: #1a7a9e; }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: #F1F5F9;
            color: #475569;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            margin-right: 10px;
            transition: background 0.15s;
        }
        .btn-back:hover { background: #E2E8F0; }
        .emc-logo {
            margin-bottom: 32px;
        }
        .emc-logo span {
            font-size: 1.1rem;
            font-weight: 900;
            color: #22334A;
            letter-spacing: -0.5px;
        }
        .emc-logo span em {
            color: #EC943C;
            font-style: normal;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="emc-logo">
            <span>EMC <em>Volunteers</em></span>
        </div>

        <div class="error-code">@yield('code')</div>

        <div class="error-icon" style="background:@yield('icon-bg','#F1F5F9');">
            @yield('icon')
        </div>

        <h1 class="error-title">@yield('title')</h1>
        <p class="error-description">@yield('description')</p>

        <div>
            <a href="javascript:history.back()" class="btn-back">← رجوع</a>
            <a href="{{ url('/') }}" class="btn-home">الصفحة الرئيسية</a>
        </div>
    </div>
</body>
</html>
