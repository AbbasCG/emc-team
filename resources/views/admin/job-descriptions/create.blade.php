@extends('layouts.admin')

@section('title', 'بطاقة وصف وظيفي جديدة')
@section('page-title', 'بطاقة الوصف الوظيفي')
@section('page-subtitle', 'إنشاء بطاقة وصف وظيفي جديدة')

@section('page-actions')
    <a href="{{ route('admin.job-descriptions.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.job-descriptions.store') }}">
    @csrf

    {{-- Section 1: Basic Info --}}
    <div class="emc-card form-section-card">
        <div class="section-header">
            <div class="section-number">١</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">البيانات الأساسية</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الاسم <span style="color:#94a3b8;font-weight:500;">(إنجليزي — اختياري)</span></label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="Job Title in English" class="emc-input">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المسمى الوظيفي <span style="color:#DC2626;">*</span></label>
                <input type="text" name="title_ar" value="{{ old('title_ar') }}" required
                       placeholder="المسمى الوظيفي بالعربية"
                       class="emc-input @error('title_ar') border-red-400 @enderror">
                @error('title_ar')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">القسم / الإدارة <span style="color:#DC2626;">*</span></label>
                <select name="department_id" required class="emc-input @error('department_id') border-red-400 @enderror">
                    <option value="">اختر القسم...</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المسؤول المباشر</label>
                <input type="text" name="direct_supervisor" value="{{ old('direct_supervisor') }}"
                       placeholder="اسم المسؤول المباشر" class="emc-input">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">مكان العمل</label>
                <select name="work_location" class="emc-input">
                    <option value="onsite"  {{ old('work_location') === 'onsite'  ? 'selected' : '' }}>حضوري</option>
                    <option value="remote"  {{ old('work_location') === 'remote'  ? 'selected' : '' }}>عن بُعد</option>
                    <option value="hybrid"  {{ old('work_location') === 'hybrid'  ? 'selected' : '' }}>هجين</option>
                </select>
            </div>
        </div>

        <div style="margin-top:18px;">
            <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الهدف العام من الوظيفة</label>
            <textarea name="general_objective" rows="3"
                      placeholder="وصف عام لهدف هذه الوظيفة ومكانتها في المنظمة..."
                      class="emc-input" style="resize:vertical;">{{ old('general_objective') }}</textarea>
        </div>
    </div>

    {{-- Section 2: Tasks --}}
    <div class="emc-card form-section-card">
        <div class="section-header">
            <div class="section-number">٢</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">المهام والمسؤوليات</h3>
        </div>

        <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المهمة الأساسية <span style="color:#DC2626;">*</span></label>
                <textarea name="task_1" required rows="2"
                          placeholder="المهمة الأساسية الرئيسية لهذا الدور..."
                          class="emc-input @error('task_1') border-red-400 @enderror"
                          style="resize:vertical;">{{ old('task_1') }}</textarea>
                @error('task_1')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            @foreach(['task_2'=>'المهمة الثانية','task_3'=>'المهمة الثالثة','task_4'=>'المهمة الرابعة'] as $field => $lbl)
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">
                    {{ $lbl }} <span style="color:#94a3b8;font-weight:500;">(اختياري)</span>
                </label>
                <textarea name="{{ $field }}" rows="2"
                          placeholder="مهمة إضافية (اختيارية)..."
                          class="emc-input" style="resize:vertical;">{{ old($field) }}</textarea>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Section 3: Qualifications --}}
    <div class="emc-card form-section-card">
        <div class="section-header">
            <div class="section-number">٣</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">المؤهلات والمتطلبات</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">التعليم</label>
                <input type="text" name="education_requirements" value="{{ old('education_requirements') }}"
                       placeholder="مثال: بكالوريوس في إدارة الأعمال" class="emc-input">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">سنوات الخبرة</label>
                <input type="text" name="years_experience" value="{{ old('years_experience') }}"
                       placeholder="مثال: ١–٣ سنوات" class="emc-input">
            </div>
        </div>
        <div style="margin-top:18px;">
            <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الشهادات المهنية <span style="color:#94a3b8;font-weight:500;">(اختياري)</span></label>
            <input type="text" name="certifications" value="{{ old('certifications') }}"
                   placeholder="مثال: PMP، SHRM، إلخ..." class="emc-input">
        </div>
        <div style="margin-top:18px;">
            <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">اللغات</label>
            <input type="text" name="languages" value="{{ old('languages') }}"
                   placeholder="مثال: العربية (أصيل)، الإنجليزية (متقدم)" class="emc-input">
        </div>
    </div>

    {{-- Section 4: Skills --}}
    <div class="emc-card" style="padding:28px;margin-bottom:24px;">
        <div class="section-header">
            <div class="section-number">٤</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">المهارات</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المهارات التقنية <span style="font-size:0.65rem;color:#2691C2;font-weight:600;">Hard Skills</span></label>
                <textarea name="hard_skills" rows="5"
                          placeholder="اذكر المهارات التقنية المطلوبة، مهارة في كل سطر..."
                          class="emc-input" style="resize:vertical;">{{ old('hard_skills') }}</textarea>
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المهارات الشخصية <span style="font-size:0.65rem;color:#16A34A;font-weight:600;">Soft Skills</span></label>
                <textarea name="soft_skills" rows="5"
                          placeholder="اذكر المهارات الشخصية المطلوبة، مهارة في كل سطر..."
                          class="emc-input" style="resize:vertical;">{{ old('soft_skills') }}</textarea>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary" style="padding:12px 32px;font-size:0.9rem;">
            حفظ بطاقة الوصف الوظيفي
        </button>
        <a href="{{ route('admin.job-descriptions.index') }}" class="btn-secondary" style="padding:12px 24px;">إلغاء</a>
    </div>
</form>
@endsection
