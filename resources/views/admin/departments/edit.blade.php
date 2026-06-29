@extends('layouts.admin')

@section('title', 'تعديل: ' . $department->name)
@section('page-title', 'تعديل القسم')
@section('page-subtitle', $department->name)

@section('page-actions')
    <a href="{{ route('admin.departments.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
<div class="form-page-narrow">
    <form method="POST" action="{{ route('admin.departments.update', $department) }}">
        @csrf @method('PATCH')
        <div class="emc-card form-section-card">
            <div style="margin-bottom:22px;padding-bottom:16px;border-bottom:1px solid #E2E8F0;">
                <h3 style="font-size:1rem;font-weight:900;color:#22334A;margin:0;">بيانات القسم</h3>
            </div>

            <div class="form-grid-2" style="margin-bottom:18px;">
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الاسم <span style="color:#DC2626;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $department->name) }}" required
                           class="emc-input @error('name') border-red-400 @enderror">
                    @error('name')<p style="color:#DC2626;font-size:0.72rem;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الاسم بالعربية</label>
                    <input type="text" name="name_ar" value="{{ old('name_ar', $department->name_ar) }}"
                           class="emc-input">
                </div>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">الوصف</label>
                <textarea name="description" rows="3"
                          class="emc-input" style="resize:vertical;">{{ old('description', $department->description) }}</textarea>
            </div>

            <div class="form-grid-2" style="margin-bottom:18px;">
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">اللون التمييزي</label>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <input type="color" name="color" value="{{ old('color', $department->color ?? '#2691C2') }}"
                               style="width:44px;height:44px;border-radius:8px;border:1px solid #E2E8F0;cursor:pointer;padding:4px;background:#fff;">
                        <span style="font-size:0.78rem;color:#64748B;">اختر اللون</span>
                    </div>
                </div>
                <div>
                    <label style="display:block;font-size:0.72rem;font-weight:700;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">أيقونة</label>
                    <input type="text" name="icon" value="{{ old('icon', $department->icon) }}"
                           class="emc-input" placeholder="مثال: 🎯">
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:#EC943C;cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:#475569;font-weight:600;cursor:pointer;">قسم نشط</label>
            </div>
        </div>

        <div class="form-actions" style="margin-top:20px;">
            <button type="submit" class="btn-primary" style="padding:11px 28px;">حفظ التغييرات</button>
            <a href="{{ route('admin.departments.index') }}" class="btn-secondary" style="padding:11px 28px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
