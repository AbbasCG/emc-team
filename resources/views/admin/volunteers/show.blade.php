@extends('layouts.admin')

@section('title', $volunteer->name)
@section('page-title', $volunteer->name)
@section('page-subtitle', 'ملف المتطوع')

@section('page-actions')
    <a href="{{ route('admin.volunteers.edit', $volunteer) }}" class="btn-primary" title="تعديل" aria-label="تعديل">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        تعديل
    </a>
    <a href="{{ route('admin.volunteers.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
@php $jd = $volunteer->jobDescription; @endphp

<div class="detail-page-narrow">

    {{-- Hero --}}
    <div class="profile-hero">
        <div class="profile-hero-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div class="profile-hero-body">
            <h1 class="profile-hero-name">{{ $volunteer->name }}</h1>
            <p class="profile-hero-email">{{ $volunteer->email }}</p>
            <div class="profile-chips">
                @if($volunteer->department)
                <span class="profile-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                    {{ $volunteer->department->name }}
                </span>
                @endif
                @if($jd)
                <span class="profile-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    {{ $jd->title_ar ?: $jd->title }}
                </span>
                @endif
                @if($volunteer->phone)
                <span class="profile-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $volunteer->phone }}
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="profile-layout">

        {{-- Main column: job content --}}
        <div class="profile-main">

            @if($jd)
            <div class="profile-section">
                <div class="profile-section-title">الوصف الوظيفي</div>
                <h2>{{ $jd->title_ar ?: $jd->title }}</h2>
                @if($jd->general_objective)
                <p class="profile-text">{{ $jd->general_objective }}</p>
                @endif
                <a href="{{ route('admin.job-descriptions.show', $jd) }}" class="profile-link">
                    عرض البطاقة الوظيفية
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
            </div>

            @php $hasTasks = collect(['task_1','task_2','task_3','task_4'])->contains(fn($f) => $jd->$f); @endphp
            @if($hasTasks)
            <div class="profile-section">
                <div class="profile-section-title">المهام والمسؤوليات</div>
                @foreach(['task_1','task_2','task_3','task_4'] as $field)
                @if($jd->$field)
                <p class="detail-task" style="margin-bottom:6px;">{{ $jd->$field }}</p>
                @endif
                @endforeach
            </div>
            @endif

            @if($jd->education_requirements || $jd->years_experience || $jd->certifications)
            <div class="profile-section">
                <div class="profile-section-title">المؤهلات</div>
                <div class="emc-grid-auto">
                    @if($jd->education_requirements)
                    <div>
                        <div class="profile-meta-label">التعليم</div>
                        <div class="profile-meta-value">{{ $jd->education_requirements }}</div>
                    </div>
                    @endif
                    @if($jd->years_experience)
                    <div>
                        <div class="profile-meta-label">سنوات الخبرة</div>
                        <div class="profile-meta-value">{{ $jd->years_experience }}</div>
                    </div>
                    @endif
                    @if($jd->certifications)
                    <div>
                        <div class="profile-meta-label">الشهادات</div>
                        <div class="profile-meta-value">{{ $jd->certifications }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($jd->hard_skills || $jd->soft_skills)
            <div class="profile-section">
                <div class="profile-section-title">المهارات</div>
                @if($jd->hard_skills)
                <div style="margin-bottom:12px;">
                    <div class="profile-meta-label">المهارات التقنية</div>
                    <p class="profile-text" style="white-space:pre-line;margin-top:4px;">{{ $jd->hard_skills }}</p>
                </div>
                @endif
                @if($jd->soft_skills)
                <div>
                    <div class="profile-meta-label">المهارات الشخصية</div>
                    <p class="profile-text" style="white-space:pre-line;margin-top:4px;">{{ $jd->soft_skills }}</p>
                </div>
                @endif
            </div>
            @endif

            @if($jd->languages)
            <div class="profile-section">
                <div class="profile-section-title">اللغات</div>
                <p class="profile-text">{{ $jd->languages }}</p>
            </div>
            @endif

            @else
            <div class="profile-section">
                <div class="detail-empty" style="padding:20px 0;">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p>لا يوجد وصف وظيفي مرتبط</p>
                </div>
            </div>
            @endif

            @if($volunteer->bio)
            <div class="profile-section">
                <div class="profile-section-title">النبذة الشخصية</div>
                <p class="profile-text">{{ $volunteer->bio }}</p>
            </div>
            @endif

        </div>

        {{-- Side column: contact & meta --}}
        <div class="profile-aside">
            <div class="profile-section">
                <div class="profile-section-title">معلومات التواصل</div>

                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">البريد</div>
                        <div class="profile-meta-value">{{ $volunteer->email }}</div>
                    </div>
                </div>

                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">الهاتف</div>
                        <div class="profile-meta-value">{{ $volunteer->phone ?? '—' }}</div>
                    </div>
                </div>

                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg></div>
                    <div>
                        <div class="profile-meta-label">القسم</div>
                        <div class="profile-meta-value">
                            @if($volunteer->department)
                            <a href="{{ route('admin.departments.show', $volunteer->department) }}">{{ $volunteer->department->name }}</a>
                            @else — @endif
                        </div>
                    </div>
                </div>

                @if($jd?->direct_supervisor)
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">المسؤول المباشر</div>
                        <div class="profile-meta-value">{{ $jd->direct_supervisor }}</div>
                    </div>
                </div>
                @endif

                @if($jd?->work_location)
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">مكان العمل</div>
                        <div class="profile-meta-value">{{ $jd->work_location_label }}</div>
                    </div>
                </div>
                @endif

                @if($volunteer->city)
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">المدينة</div>
                        <div class="profile-meta-value">{{ $volunteer->city }}</div>
                    </div>
                </div>
                @endif

                @if($volunteer->gender)
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">الجنس</div>
                        <div class="profile-meta-value">{{ $volunteer->gender === 'male' ? 'ذكر' : 'أنثى' }}</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="profile-section">
                <div class="profile-section-title">السجل</div>
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">تاريخ التسجيل</div>
                        <div class="profile-meta-value">{{ $volunteer->created_at->locale('ar')->isoFormat('D MMM YYYY') }}</div>
                    </div>
                </div>
                <div class="profile-meta-row">
                    <div class="profile-meta-icon"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div>
                        <div class="profile-meta-label">آخر تحديث</div>
                        <div class="profile-meta-value">{{ $volunteer->updated_at->locale('ar')->isoFormat('D MMM YYYY') }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Danger zone --}}
    <div class="profile-danger">
        <div>
            <h4>حذف المتطوع</h4>
            <p>حذف نهائي من النظام</p>
        </div>
        <form method="POST" action="{{ route('admin.volunteers.destroy', $volunteer) }}" onsubmit="return confirm('هل أنت متأكد؟')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-sm" title="حذف" aria-label="حذف">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                حذف
            </button>
        </form>
    </div>

</div>
@endsection
