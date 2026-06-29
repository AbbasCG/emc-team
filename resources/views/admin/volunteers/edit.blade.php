@extends('layouts.admin')

@section('title', 'تعديل: ' . $volunteer->name)
@section('page-title', 'تعديل المتطوع')
@section('page-subtitle', $volunteer->name)

@section('page-actions')
    <a href="{{ route('admin.volunteers.show', $volunteer) }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
<div class="form-page">
    <form method="POST" action="{{ route('admin.volunteers.update', $volunteer) }}">
        @csrf @method('PATCH')

        <div class="emc-card form-section-card">
            <div style="margin-bottom:22px;padding-bottom:16px;border-bottom:1px solid #E2E8F0;">
                <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">البيانات الأساسية</h3>
            </div>

            <div class="form-grid-2">
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الاسم الكامل <span style="color:#DC2626;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $volunteer->name) }}" required
                           class="emc-input @error('name') border-red-400 @enderror">
                    @error('name')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">البريد الإلكتروني <span style="color:#DC2626;">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $volunteer->email) }}" required
                           class="emc-input @error('email') border-red-400 @enderror">
                    @error('email')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">رقم الهاتف</label>
                    <input type="text" name="phone" value="{{ old('phone', $volunteer->phone) }}" class="emc-input" placeholder="+966 5X XXX XXXX">
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">المدينة</label>
                    <input type="text" name="city" value="{{ old('city', $volunteer->city) }}" class="emc-input" placeholder="مثال: الرياض">
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الجنس</label>
                    <select name="gender" class="emc-input">
                        <option value="">غير محدد</option>
                        <option value="male"   {{ old('gender', $volunteer->gender) === 'male'   ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $volunteer->gender) === 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">القسم</label>
                    <select name="department_id" class="emc-input">
                        <option value="">بدون قسم</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $volunteer->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الوصف الوظيفي</label>
                    <select name="job_description_id" class="emc-input">
                        <option value="">بدون وصف وظيفي</option>
                        @foreach($jobDescriptions as $jd)
                        <option value="{{ $jd->id }}" {{ old('job_description_id', $volunteer->job_description_id) == $jd->id ? 'selected' : '' }}>{{ $jd->title_ar ?: $jd->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top:18px;">
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">النبذة الشخصية</label>
                <textarea name="bio" rows="3" placeholder="نبذة قصيرة عن المتطوع..."
                          class="emc-input" style="resize:vertical;">{{ old('bio', $volunteer->bio) }}</textarea>
            </div>
        </div>

        <div class="form-actions" style="margin-top:20px;">
            <button type="submit" class="btn-primary" style="padding:11px 28px;">حفظ التغييرات</button>
            <a href="{{ route('admin.volunteers.show', $volunteer) }}" class="btn-secondary" style="padding:11px 28px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
