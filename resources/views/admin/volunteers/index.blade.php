@extends('layouts.admin')

@section('title', 'المتطوعون')
@section('page-title', 'المتطوعون')
@section('page-subtitle', 'إدارة وعرض جميع المتطوعين المسجلين')

@section('page-actions')
    <span class="num" style="font-size:0.78rem;color:#64748B;font-weight:600;background:#F8FAFC;padding:6px 14px;border-radius:8px;border:1px solid #E2E8F0;">{{ $volunteers->total() }} متطوع</span>
    <a href="{{ route('admin.volunteers.create') }}" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M12 4v16m8-8H4"/></svg>
        إضافة متطوع
    </a>
@endsection

@section('content')

<div class="emc-card filter-card">
    <form method="GET">
        <div class="emc-grid-auto" style="margin-bottom:12px;">
            <div>
                <label style="display:block;font-size:0.68rem;font-weight:700;color:#64748B;margin-bottom:5px;">البحث</label>
                <div style="position:relative;">
                    <svg style="position:absolute;right:11px;top:50%;transform:translateY(-50%);pointer-events:none;" width="14" height="14" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="الاسم أو البريد..." style="padding-right:34px;" class="emc-input">
                </div>
            </div>
            <div>
                <label style="display:block;font-size:0.68rem;font-weight:700;color:#64748B;margin-bottom:5px;">القسم</label>
                <select name="department_id" class="emc-input">
                    <option value="">كل الأقسام</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;font-size:0.68rem;font-weight:700;color:#64748B;margin-bottom:5px;">الوظيفة</label>
                <select name="job_description_id" class="emc-input">
                    <option value="">كل الوظائف</option>
                    @foreach($jobDescriptions as $jd)
                    <option value="{{ $jd->id }}" {{ request('job_description_id') == $jd->id ? 'selected' : '' }}>{{ $jd->title_ar ?: $jd->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary" style="padding:8px 18px;font-size:0.82rem;">تصفية</button>
            @if(request()->hasAny(['search', 'department_id', 'job_description_id']))
            <a href="{{ route('admin.volunteers.index') }}" class="btn-secondary" style="padding:8px 16px;font-size:0.82rem;">مسح</a>
            @endif
        </div>
    </form>
</div>

@if($volunteers->count())
<div class="volunteer-grid">
    @foreach($volunteers as $volunteer)
    @php $jd = $volunteer->jobDescription; @endphp
    <article class="vol-card" onclick="window.location='{{ route('admin.volunteers.show', $volunteer) }}'">
        <div class="vol-card-top">
            <div class="vol-card-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="vol-card-head">
                <h3 class="vol-card-name">{{ $volunteer->name }}</h3>
                <div class="vol-card-email">{{ $volunteer->email }}</div>
            </div>
        </div>

        <div class="vol-card-body">
            <div class="vol-card-field">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span class="vol-card-field-label">الهاتف</span>
                <span class="vol-card-field-value">{{ $volunteer->phone ?? '—' }}</span>
            </div>
            <div class="vol-card-field">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                <span class="vol-card-field-label">القسم</span>
                <span class="vol-card-field-value">{{ $volunteer->department?->name ?? '—' }}</span>
            </div>
            <div class="vol-card-field">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="vol-card-field-label">الوظيفة</span>
                <span class="vol-card-field-value">{{ $jd?->title_ar ?: ($jd?->title ?? '—') }}</span>
            </div>
            <div class="vol-card-field">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="vol-card-field-label">المسؤول</span>
                <span class="vol-card-field-value">{{ $jd?->direct_supervisor ?? '—' }}</span>
            </div>
        </div>

        <div class="vol-card-foot">
            <div class="vol-card-dates">
                <div>التسجيل: <strong class="num">{{ $volunteer->created_at->locale('ar')->isoFormat('D MMM YYYY') }}</strong></div>
                <div>التحديث: <strong class="num">{{ $volunteer->updated_at->locale('ar')->isoFormat('D MMM YYYY') }}</strong></div>
            </div>
            <x-icon-actions
                :view="route('admin.volunteers.show', $volunteer)"
                :edit="route('admin.volunteers.edit', $volunteer)"
                :deleteAction="route('admin.volunteers.destroy', $volunteer)"
                deleteConfirm="هل أنت متأكد من حذف المتطوع؟"
            />
        </div>
    </article>
    @endforeach
</div>

@if($volunteers->hasPages())
<div class="emc-card emc-pagination" style="margin-top:16px;border-radius:12px;">
    <span class="num" style="font-size:0.75rem;color:#94a3b8;">
        عرض {{ $volunteers->firstItem() }}–{{ $volunteers->lastItem() }} من {{ $volunteers->total() }}
    </span>
    <div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;">
        @if($volunteers->onFirstPage())
        <span style="padding:6px 12px;border-radius:7px;font-size:0.75rem;color:#CBD5E1;background:#F8FAFC;border:1px solid #E2E8F0;">السابق</span>
        @else
        <a href="{{ $volunteers->previousPageUrl() }}" class="btn-secondary" style="padding:6px 12px;font-size:0.75rem;">السابق</a>
        @endif
        @if($volunteers->hasMorePages())
        <a href="{{ $volunteers->nextPageUrl() }}" class="btn-primary" style="padding:6px 12px;font-size:0.75rem;">التالي</a>
        @else
        <span style="padding:6px 12px;border-radius:7px;font-size:0.75rem;color:#CBD5E1;background:#F8FAFC;border:1px solid #E2E8F0;">التالي</span>
        @endif
    </div>
</div>
@endif

@else
<div class="emc-card" style="padding:48px 24px;text-align:center;">
    @include('admin.partials.empty-volunteers')
</div>
@endif

@endsection
