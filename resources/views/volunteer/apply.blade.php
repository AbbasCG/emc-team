<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استمارة بيانات المتطوع — EMC</title>
    <meta name="description" content="استمارة تعبئة البيانات الوظيفية للمتطوعين في مركز EMC.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html {
            overflow-x: hidden;
            max-width: 100%;
        }

        :root {
            --deep: #22334A;
            --blue: #2691C2;
            --orange: #EC943C;
            --bg: #F8FAFC;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --text: #0F172A;
            --muted: #64748B;
            --success: #16A34A;
            --danger: #DC2626;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            direction: rtl;
            overflow-x: hidden;
            max-width: 100%;
            -webkit-font-smoothing: antialiased;
        }

        input, select, textarea, button {
            font-family: 'Tajawal', sans-serif;
        }

        /* ── Header ── */
        .apply-header {
            background: var(--deep);
            padding: 0;
        }

        .apply-header-inner {
            max-width: 820px;
            margin: 0 auto;
            padding: 28px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .apply-logo {
            width: 44px; height: 44px;
            /* background: var(--orange); */
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(236,148,60,0.4);
            overflow: hidden;
        }

        .apply-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .apply-header-text h1 {
            font-size: 1.1rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .apply-header-text p {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            margin-top: 2px;
        }

        /* ── Hero strip ── */
        .apply-hero {
            background: linear-gradient(135deg, #22334A 0%, #1a2d42 60%, #162438 100%);
            padding: 48px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .apply-hero::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 500px; height: 300px;
            background: radial-gradient(ellipse, rgba(38,145,194,0.15), transparent 70%);
            pointer-events: none;
        }

        .apply-hero h2 {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
            position: relative;
        }

        .apply-hero p {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.62);
            max-width: 460px;
            margin: 0 auto;
            line-height: 1.7;
            position: relative;
        }

        .apply-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(38,145,194,0.15);
            border: 1px solid rgba(38,145,194,0.3);
            color: #7DD3FC;
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }

        /* ── Main form area ── */
        .apply-body {
            max-width: 820px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── Sections ── */
        .form-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            animation: fadeUp 0.35s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-section:nth-child(2) { animation-delay: 0.06s; }
        .form-section:nth-child(3) { animation-delay: 0.12s; }
        .form-section:nth-child(4) { animation-delay: 0.18s; }
        .form-section:nth-child(5) { animation-delay: 0.24s; }
        .form-section:nth-child(6) { animation-delay: 0.30s; }

        .section-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .section-num {
            width: 30px; height: 30px;
            background: var(--blue);
            color: #fff;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        .section-head h3 {
            font-size: 1rem;
            font-weight: 900;
            color: var(--deep);
        }

        .section-head p {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 1px;
        }

        /* ── Fields ── */
        .field-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        label {
            font-size: 0.73rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        label .req {
            color: var(--danger);
            margin-right: 2px;
        }

        label .opt {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.68rem;
            text-transform: none;
            letter-spacing: 0;
        }

        .field-input {
            width: 100%;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 0.9rem;
            color: var(--text);
            transition: border-color 0.18s, box-shadow 0.18s;
            outline: none;
            font-family: 'Tajawal', sans-serif;
        }

        .field-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(38,145,194,0.14);
        }

        .field-input::placeholder { color: #94a3b8; }

        textarea.field-input {
            resize: vertical;
            min-height: 80px;
        }

        .field-error {
            font-size: 0.73rem;
            color: var(--danger);
            font-weight: 600;
            margin-top: 2px;
        }

        .field-input.has-error { border-color: var(--danger); }

        /* ── Task rows ── */
        .task-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .task-num {
            width: 28px; height: 28px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900;
            font-size: 0.72rem;
            flex-shrink: 0;
            margin-top: 12px;
        }

        .task-num.primary { background: #EFF6FF; border: 1px solid #BFDBFE; color: var(--blue); }
        .task-num.secondary { background: #F8FAFC; border: 1px solid var(--border); color: var(--muted); }

        /* ── Alert ── */
        .form-alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #B91C1C;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        /* ── Submit ── */
        .submit-bar {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 36px;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s, transform 0.15s;
        }

        .submit-btn:hover {
            background: #1d7aab;
            box-shadow: 0 6px 20px rgba(38,145,194,0.35);
            transform: translateY(-1px);
        }

        .submit-btn:active { transform: translateY(0); box-shadow: none; }

        /* ── Footer ── */
        .apply-footer {
            text-align: center;
            padding: 20px 24px;
            color: #94a3b8;
            font-size: 0.72rem;
            border-top: 1px solid var(--border);
        }

        /* ── Mobile ── */
        @media (max-width: 767px) {
            .apply-header-inner { padding: 20px 16px; }
            .apply-hero { padding: 32px 16px; }
            .apply-hero h2 { font-size: 1.45rem; }
            .apply-body { padding: 24px 16px 60px; }
            .form-section { padding: 20px 16px; }
            .field-grid-2 { grid-template-columns: 1fr; }
            .submit-bar { flex-direction: column; align-items: stretch; }
            .submit-btn { justify-content: center; width: 100%; }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .apply-body { padding: 32px 20px 72px; }
            .form-section { padding: 24px 26px; }
        }

        /* ── Reduced motion ── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>

{{-- Header --}}
<header class="apply-header">
    <div class="apply-header-inner">
        <div class="apply-logo">
            <img src="{{ asset('images/emcLogo.png') }}" alt="EMC Logo" loading="lazy">
        </div>
        <div class="apply-header-text">
            <h1>نظام إدارة المتطوعين</h1>
            <p>EMC Volunteer Management System</p>
        </div>
    </div>
</header>

{{-- Hero --}}
<div class="apply-hero">
    <div class="apply-hero-badge">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        استمارة بيانات المتطوعين
    </div>
    <h2>تعبئة البيانات الوظيفية</h2>
    <p>يرجى تعبئة بياناتك الوظيفية والتنظيمية لتحديث سجلات المتطوعين داخل نظام EMC.</p>
</div>

{{-- Form --}}
<div class="apply-body">

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="form-alert-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <div style="font-weight:800;margin-bottom:4px;">يرجى تصحيح الأخطاء التالية:</div>
            <ul style="margin:0;padding-right:16px;font-weight:500;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('volunteer.apply.store') }}">
        @csrf

        {{-- Section 1: Personal Info --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">١</div>
                <div>
                    <h3>البيانات الشخصية</h3>
                    <p>معلوماتك الأساسية لتحديد السجل في النظام</p>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>الاسم الكامل <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="اسمك الكامل"
                           class="field-input {{ $errors->has('name') ? 'has-error' : '' }}">
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field-group">
                    <label>البريد الإلكتروني <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="your@email.com"
                           class="field-input {{ $errors->has('email') ? 'has-error' : '' }}">
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field-group">
                    <label>رقم الهاتف <span class="req">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                           placeholder="+966 5X XXX XXXX"
                           class="field-input {{ $errors->has('phone') ? 'has-error' : '' }}">
                    @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field-group">
                    <label>القسم / الإدارة <span class="req">*</span></label>
                    <select name="department_id" required
                            class="field-input {{ $errors->has('department_id') ? 'has-error' : '' }}">
                        <option value="">اختر القسم المناسب...</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Role Info --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">٢</div>
                <div>
                    <h3>بيانات المنصب الوظيفي</h3>
                    <p>تفاصيل الدور الذي تشغله داخل المنظمة</p>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>المسمى الوظيفي <span class="req">*</span></label>
                    <input type="text" name="title_ar" value="{{ old('title_ar') }}" required
                           placeholder="مثال: منسق تطوعي"
                           class="field-input {{ $errors->has('title_ar') ? 'has-error' : '' }}">
                    @error('title_ar')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field-group">
                    <label>المسؤول المباشر <span class="opt">(اختياري)</span></label>
                    <input type="text" name="direct_supervisor" value="{{ old('direct_supervisor') }}"
                           placeholder="اسم المسؤول"
                           class="field-input">
                </div>

                <div class="field-group">
                    <label>مكان العمل <span class="req">*</span></label>
                    <select name="work_location" required
                            class="field-input {{ $errors->has('work_location') ? 'has-error' : '' }}">
                        <option value="onsite" {{ old('work_location','onsite') === 'onsite' ? 'selected' : '' }}>حضوري</option>
                        <option value="remote" {{ old('work_location') === 'remote' ? 'selected' : '' }}>عن بُعد</option>
                        <!-- <option value="hybrid" {{ old('work_location') === 'hybrid' ? 'selected' : '' }}>هجين</option> -->
                    </select>
                </div>

                <div class="field-group field-full">
                    <label>الهدف العام من الوظيفة <span class="opt">(اختياري)</span></label>
                    <textarea name="general_objective" rows="3"
                              placeholder="وصف مختصر لهدف هذا الدور داخل المنظمة..."
                              class="field-input">{{ old('general_objective') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 3: Tasks --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">٣</div>
                <div>
                    <h3>المهام والمسؤوليات</h3>
                    <p>المهام الفعلية التي تؤديها في هذا المنصب</p>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:14px;">
                <div>
                    <div class="task-row">
                        <div class="task-num primary">١</div>
                        <div class="field-group" style="flex:1;">
                            <label>المهمة الأساسية <span class="req">*</span></label>
                            <textarea name="task_1" rows="2" required
                                      placeholder="المهمة الرئيسية لهذا المنصب..."
                                      class="field-input {{ $errors->has('task_1') ? 'has-error' : '' }}">{{ old('task_1') }}</textarea>
                            @error('task_1')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                @foreach(['task_2'=>'المهمة الثانية','task_3'=>'المهمة الثالثة','task_4'=>'المهمة الرابعة'] as $f => $lbl)
                <div class="task-row">
                    <div class="task-num secondary">{{ ['task_2'=>'٢','task_3'=>'٣','task_4'=>'٤'][$f] }}</div>
                    <div class="field-group" style="flex:1;">
                        <label>{{ $lbl }} <span class="opt">(اختياري)</span></label>
                        <textarea name="{{ $f }}" rows="2"
                                  placeholder="مهمة إضافية اختيارية..."
                                  class="field-input">{{ old($f) }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Section 4: Qualifications --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">٤</div>
                <div>
                    <h3>المؤهلات والخبرات</h3>
                    <p>خلفيتك التعليمية والمهنية</p>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>التعليم <span class="opt">(اختياري)</span></label>
                    <input type="text" name="education_requirements" value="{{ old('education_requirements') }}"
                           placeholder="مثال: بكالوريوس إدارة أعمال"
                           class="field-input">
                </div>

                <div class="field-group">
                    <label>سنوات الخبرة <span class="opt">(اختياري)</span></label>
                    <input type="text" name="years_experience" value="{{ old('years_experience') }}"
                           placeholder="مثال: ١–٣ سنوات"
                           class="field-input">
                </div>

                <div class="field-group field-full">
                    <label>الشهادات المهنية <span class="opt">(اختياري)</span></label>
                    <input type="text" name="certifications" value="{{ old('certifications') }}"
                           placeholder="مثال: PMP، SHRM..."
                           class="field-input">
                </div>

                <div class="field-group field-full">
                    <label>اللغات <span class="opt">(اختياري)</span></label>
                    <input type="text" name="languages" value="{{ old('languages') }}"
                           placeholder="مثال: العربية (أصيل)، الإنجليزية (متقدم)"
                           class="field-input">
                </div>
            </div>
        </div>

        {{-- Section 5: Skills --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">٥</div>
                <div>
                    <h3>المهارات</h3>
                    <p>مهاراتك التقنية والشخصية</p>
                </div>
            </div>

            <div class="field-grid-2">
                <div class="field-group">
                    <label>
                        المهارات التقنية
                        <span style="font-size:0.65rem;color:#2691C2;font-weight:600;letter-spacing:0;text-transform:none;margin-right:4px;">Hard Skills</span>
                        <span class="opt">(اختياري)</span>
                    </label>
                    <textarea name="hard_skills" rows="5"
                              placeholder="اذكر مهاراتك التقنية، مهارة في كل سطر..."
                              class="field-input">{{ old('hard_skills') }}</textarea>
                </div>

                <div class="field-group">
                    <label>
                        المهارات الشخصية
                        <span style="font-size:0.65rem;color:#16A34A;font-weight:600;letter-spacing:0;text-transform:none;margin-right:4px;">Soft Skills</span>
                        <span class="opt">(اختياري)</span>
                    </label>
                    <textarea name="soft_skills" rows="5"
                              placeholder="اذكر مهاراتك الشخصية، مهارة في كل سطر..."
                              class="field-input">{{ old('soft_skills') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Submit bar --}}
        <div class="submit-bar">
            <div>
                <div style="font-size:0.85rem;font-weight:700;color:#22334A;">مراجعة البيانات قبل الحفظ</div>
                <div style="font-size:0.75rem;color:#64748B;margin-top:2px;">ستُحفظ بياناتك مباشرةً في سجلات المتطوعين وتُعرض على الإدارة.</div>
            </div>
            <button type="submit" class="submit-btn">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                حفظ البيانات
            </button>
        </div>

    </form>
</div>

<footer class="apply-footer">
    &copy; {{ date('Y') }} EMC — جميع الحقوق محفوظة
</footer>

</body>
</html>
