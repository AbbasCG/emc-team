@extends('layouts.admin')

@section('title', 'إضافة متطوع جديد')
@section('page-title', 'المتطوعون')
@section('page-subtitle', 'إضافة متطوع جديد يدوياً')

@section('page-actions')
    <a href="{{ route('admin.volunteers.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.volunteers.store') }}">
    @csrf

    {{-- Basic Info --}}
    <div class="emc-card form-section-card">
        <div class="section-header">
            <div class="section-number">١</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">البيانات الأساسية</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الاسم الكامل <span style="color:#DC2626;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="اسم المتطوع"
                       class="emc-input @error('name') border-red-400 @enderror">
                @error('name')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">البريد الإلكتروني <span style="color:#DC2626;">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="volunteer@example.com"
                       class="emc-input @error('email') border-red-400 @enderror">
                @error('email')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">كلمة المرور <span style="color:#DC2626;">*</span></label>
                <input type="password" name="password" required
                       placeholder="8 أحرف على الأقل"
                       class="emc-input @error('password') border-red-400 @enderror">
                @error('password')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="emc-input" placeholder="+966 5X XXX XXXX">
            </div>
        </div>
    </div>

    {{-- Assignment --}}
    <div class="emc-card form-section-card">
        <div class="section-header">
            <div class="section-number">٢</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">التعيين</h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">القسم</label>
                <select name="department_id" class="emc-input">
                    <option value="">بدون قسم</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الوصف الوظيفي</label>
                <select name="job_description_id" class="emc-input">
                    <option value="">بدون وصف وظيفي</option>
                    @foreach($jobDescriptions as $jd)
                    <option value="{{ $jd->id }}" {{ old('job_description_id') == $jd->id ? 'selected' : '' }}>{{ $jd->title_ar ?: $jd->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Personal Details --}}
    <div class="emc-card form-section-card" style="margin-bottom:24px;">
        <div class="section-header">
            <div class="section-number">٣</div>
            <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">البيانات الشخصية <span style="color:#94a3b8;font-weight:400;font-size:0.8rem;">(اختيارية)</span></h3>
        </div>

        <div class="form-grid-2">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="+966 5X XXX XXXX" class="emc-input">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المدينة</label>
                <input type="text" name="city" value="{{ old('city') }}"
                       placeholder="الرياض" class="emc-input">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الجنس</label>
                <select name="gender" class="emc-input">
                    <option value="">غير محدد</option>
                    <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>ذكر</option>
                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>أنثى</option>
                </select>
            </div>
        </div>
        <div style="margin-top:18px;">
            <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">نبذة</label>
            <textarea name="bio" rows="3"
                      placeholder="نبذة مختصرة عن المتطوع..."
                      class="emc-input" style="resize:vertical;">{{ old('bio') }}</textarea>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary" style="padding:12px 32px;font-size:0.9rem;">إضافة المتطوع</button>
        <a href="{{ route('admin.volunteers.index') }}" class="btn-secondary" style="padding:12px 24px;">إلغاء</a>
    </div>
</form>
@endsection
