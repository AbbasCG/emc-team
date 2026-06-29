@extends('layouts.admin')

@section('title', 'بطاقات الوصف الوظيفي')
@section('page-title', 'بطاقات الوصف الوظيفي')
@section('page-subtitle', 'إدارة وتصفح جميع بطاقات الوصف الوظيفي')

@section('content')

@include('admin.job-descriptions._styles')

<div class="jd-index-page">

    {{-- Compact toolbar --}}
    <form method="GET" class="jd-toolbar">
        <div class="jd-toolbar-search">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالمسمى الوظيفي...">
        </div>

        <select name="department_id" class="jd-toolbar-select" onchange="this.form.submit()">
            <option value="">كل الأقسام</option>
            @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
            @endforeach
        </select>

        <select name="sort" class="jd-toolbar-select" onchange="this.form.submit()">
            <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>الأحدث</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>الأقدم</option>
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>المسمى</option>
            <option value="volunteers" {{ request('sort') === 'volunteers' ? 'selected' : '' }}>عدد المتطوعين</option>
        </select>

        @if(request()->hasAny(['search', 'department_id', 'sort']) && (request('sort') !== 'newest' || request()->filled('search') || request()->filled('department_id')))
        <a href="{{ route('admin.job-descriptions.index') }}" class="jd-toolbar-btn jd-toolbar-btn-filter">مسح</a>
        @else
        <button type="submit" class="jd-toolbar-btn jd-toolbar-btn-filter">تصفية</button>
        @endif

        <a href="{{ route('admin.job-descriptions.create') }}" class="jd-toolbar-btn jd-toolbar-btn-create">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" d="M12 4v16m8-8H4" />
            </svg>
            بطاقة جديدة
        </a>
    </form>

    @if($jobDescriptions->count())

    <div class="jd-grid">
        @foreach($jobDescriptions as $jd)
        <article class="jd-card" onclick="window.location='{{ route('admin.job-descriptions.show', $jd) }}'">

            {{-- Top --}}
            <div class="jd-card-top">
                <div class="jd-card-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="jd-card-title">{{ $jd->title_ar ?: $jd->title }}</h3>
                <div class="jd-card-badges">
                    @if($jd->department)
                    <span class="jd-badge jd-badge-dept">
                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                        </svg>
                        {{ $jd->department->name }}
                    </span>
                    @endif
                    @if($jd->is_active && ($jd->jd_status ?? 'active') === 'active')
                    <span class="jd-badge jd-badge-active">نشط</span>
                    @else
                    <span class="jd-badge jd-badge-inactive">{{ $jd->jd_status_label ?? 'غير نشط' }}</span>
                    @endif
                </div>
            </div>

            {{-- Middle --}}
            <div class="jd-card-mid">

                {{-- Volunteer name --}}
                <div class="jd-card-row">
                    <span class="jd-card-row-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M17 20h5v-2a4 4 0 00-4-4h-1" />
                            <path d="M9 20H4v-2a4 4 0 014-4h1" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>

                    <span class="jd-card-row-label">المتطوع</span>

                    <span class="jd-card-row-value">
                        @if(isset($jd->volunteers) && $jd->volunteers->count())
                        {{ $jd->volunteers->pluck('name')->join('، ') }}
                        @elseif(isset($jd->users) && $jd->users->count())
                        {{ $jd->users->pluck('name')->join('، ') }}
                        @else
                        غير مرتبط
                        @endif
                    </span>
                </div>

                {{-- Supervisor --}}
                <div class="jd-card-row">
                    <span class="jd-card-row-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            <path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span class="jd-card-row-label">المسؤول</span>
                    <span class="jd-card-row-value">{{ $jd->direct_supervisor ?? '—' }}</span>
                </div>

                {{-- Work location --}}
                <div class="jd-card-row">
                    <span class="jd-card-row-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                    </span>
                    <span class="jd-card-row-label">مكان العمل</span>
                    <span class="jd-card-row-value">{{ $jd->work_location_label }}</span>
                </div>

                {{-- Experience --}}
                <div class="jd-card-row">
                    <span class="jd-card-row-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span class="jd-card-row-label">الخبرة</span>
                    <span class="jd-card-row-value">{{ $jd->years_experience ?? '—' }}</span>
                </div>

                {{-- Education --}}
                <div class="jd-card-row">
                    <span class="jd-card-row-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </span>
                    <span class="jd-card-row-label">التعليم</span>
                    <span class="jd-card-row-value">{{ $jd->education_requirements ?? '—' }}</span>
                </div>

            </div>

            {{-- Stats --}}
            <div class="jd-card-stats">
                <div class="jd-stat-pill">
                    <div class="jd-stat-pill-value num">{{ $jd->volunteers_count }}</div>
                    <div class="jd-stat-pill-label">متطوع مرتبط</div>
                </div>
                <div class="jd-stat-pill">
                    <div class="jd-stat-pill-value num">{{ $jd->created_at->locale('ar')->isoFormat('D MMM') }}</div>
                    <div class="jd-stat-pill-label">تاريخ الإنشاء</div>
                </div>
            </div>

            {{-- Actions — icons only --}}
            <div class="jd-card-foot" onclick="event.stopPropagation()">
                <x-icon-actions
                    :view="route('admin.job-descriptions.show', $jd)"
                    :edit="route('admin.job-descriptions.edit', $jd)"
                    :deleteAction="route('admin.job-descriptions.destroy', $jd)"
                    deleteConfirm="هل أنت متأكد من حذف هذه البطاقة؟" />
            </div>
        </article>
        @endforeach
    </div>

    @if($jobDescriptions->hasPages())
    <div class="jd-pagination">
        <span class="num" style="font-size:0.75rem;color:#94A3B8;">
            {{ $jobDescriptions->firstItem() }}–{{ $jobDescriptions->lastItem() }} من {{ $jobDescriptions->total() }}
        </span>
        <div style="display:flex;align-items:center;gap:8px;">
            @if($jobDescriptions->onFirstPage())
            <span style="padding:6px 12px;border-radius:8px;font-size:0.75rem;color:#CBD5E1;background:#F8FAFC;border:1px solid #E2E8F0;">السابق</span>
            @else
            <a href="{{ $jobDescriptions->previousPageUrl() }}" class="btn-secondary" style="padding:6px 12px;font-size:0.75rem;">السابق</a>
            @endif
            @if($jobDescriptions->hasMorePages())
            <a href="{{ $jobDescriptions->nextPageUrl() }}" class="btn-primary" style="padding:6px 12px;font-size:0.75rem;">التالي</a>
            @else
            <span style="padding:6px 12px;border-radius:8px;font-size:0.75rem;color:#CBD5E1;background:#F8FAFC;border:1px solid #E2E8F0;">التالي</span>
            @endif
        </div>
    </div>
    @endif

    @else

    <div class="jd-empty">
        <div class="jd-empty-illustration">
            <svg width="44" height="44" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                <path d="M15 3h6v6M10 14L21 3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <h2>لا توجد بطاقات وصف وظيفي</h2>
        <p>ابدأ بإنشاء أول بطاقة وصف وظيفي لتنظيم الأدوار والمهام داخل أقسام EMC.</p>
        <a href="{{ route('admin.job-descriptions.create') }}" class="jd-empty-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" d="M12 4v16m8-8H4" />
            </svg>
            إنشاء أول بطاقة
        </a>
    </div>

    @endif

</div>

@endsection