@extends('layouts.admin')

@section('title', $department->name)
@section('page-title', $department->name_ar ?: $department->name)
@section('page-subtitle')
    @if($department->name_ar && $department->name_ar !== $department->name)
        {{ $department->name }}
    @else
        تفاصيل القسم
    @endif
@endsection

@section('page-actions')
    <a href="{{ route('admin.departments.edit', $department) }}" class="btn-primary" title="تعديل القسم" aria-label="تعديل">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        تعديل
    </a>
    <a href="{{ route('admin.departments.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')
<div class="detail-page">

    {{-- Department header --}}
    <div class="detail-hero" style="margin-bottom:16px;">
        <div class="detail-hero-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="detail-hero-body">
            <h1 class="detail-hero-title" style="font-size:1.15rem;">{{ $department->name_ar ?: $department->name }}</h1>
            @if($department->name_ar && $department->name && $department->name_ar !== $department->name)
            <p class="detail-hero-sub">{{ $department->name }}</p>
            @endif
            @if($department->description)
            <p style="font-size:0.82rem;color:#64748B;line-height:1.6;margin:0;">{{ $department->description }}</p>
            @endif
        </div>
    </div>

    {{-- Overview KPIs --}}
    <div class="kpi-grid kpi-grid-4" style="margin-bottom:20px;">
        <div class="emc-stat-card">
            <div class="kpi-icon kpi-icon-blue">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="kpi-label">عدد الأعضاء</div>
            <div class="kpi-value num">{{ $department->volunteers_count }}</div>
        </div>
        <div class="emc-stat-card">
            <div class="kpi-icon kpi-icon-orange">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="kpi-label">بطاقات الوصف الوظيفي</div>
            <div class="kpi-value num">{{ $department->job_descriptions_count }}</div>
        </div>
        <div class="emc-stat-card">
            <div class="kpi-icon kpi-icon-deep">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="kpi-label">قائد القسم / المسؤول</div>
            <div class="kpi-value-text">{{ $leaderName ?? '—' }}</div>
            @if($leaderContact && ($leaderContact['email'] || $leaderContact['phone']))
            <div class="kpi-sub">{{ $leaderContact['email'] ?? $leaderContact['phone'] }}</div>
            @endif
        </div>
        <div class="emc-stat-card">
            <div class="kpi-icon kpi-icon-green">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="kpi-label">آخر تحديث</div>
            @if($latestVolunteer)
            <div class="kpi-value-text">{{ $latestVolunteer->name }}</div>
            <div class="kpi-sub">{{ $latestVolunteer->updated_at->locale('ar')->diffForHumans() }}</div>
            @else
            <div class="kpi-value-text" style="color:#94a3b8;">—</div>
            @endif
        </div>
    </div>

    {{-- Unified member cards --}}
    <div class="section-block">
        <div class="section-block-head">
            <h3>أعضاء القسم</h3>
            <span class="section-block-count num">{{ $volunteers->count() }}</span>
        </div>

        @if($volunteers->count())
        <div class="member-grid">
            @foreach($volunteers as $v)
            @php $jd = $v->jobDescription; @endphp
            <article class="member-card" onclick="window.location='{{ route('admin.volunteers.show', $v) }}'">
                <div class="member-card-header">
                    <div class="member-card-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h4 class="member-card-title">{{ $v->name }}</h4>
                        <div class="member-card-sub">{{ $v->email }}</div>
                        @if($jd)
                        <span class="member-card-job">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ $jd->title_ar ?: $jd->title }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="member-card-grid">
                    <div>
                        <div class="member-field-label">الهاتف</div>
                        <div class="member-field-value">{{ $v->phone ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="member-field-label">المسؤول المباشر</div>
                        <div class="member-field-value">{{ $jd?->direct_supervisor ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="member-field-label">مكان العمل</div>
                        <div class="member-field-value">{{ $jd?->work_location_label ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="member-field-label">التعليم</div>
                        <div class="member-field-value">{{ $jd?->education_requirements ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="member-field-label">سنوات الخبرة</div>
                        <div class="member-field-value">{{ $jd?->years_experience ?? '—' }}</div>
                    </div>
                    @if($jd?->hard_skills || $jd?->soft_skills)
                    <div class="member-field-span">
                        <div class="member-field-label">المهارات</div>
                        <div class="member-field-value">
                            @if($jd->hard_skills){{ $jd->hard_skills }}@endif
                            @if($jd->hard_skills && $jd->soft_skills) · @endif
                            @if($jd->soft_skills){{ $jd->soft_skills }}@endif
                        </div>
                    </div>
                    @endif
                    @if($jd?->languages)
                    <div class="member-field-span">
                        <div class="member-field-label">اللغات</div>
                        <div class="member-field-value">{{ $jd->languages }}</div>
                    </div>
                    @endif
                </div>

                <div class="member-card-foot">
                    <div class="member-card-meta">
                        <span>التسجيل: {{ $v->created_at->locale('ar')->isoFormat('D MMM YYYY') }}</span>
                        ·
                        <span>التحديث: {{ $v->updated_at->locale('ar')->isoFormat('D MMM YYYY') }}</span>
                    </div>
                    <x-icon-actions
                        :view="route('admin.volunteers.show', $v)"
                        :edit="route('admin.volunteers.edit', $v)"
                        :deleteAction="route('admin.volunteers.destroy', $v)"
                        deleteConfirm="هل أنت متأكد من حذف المتطوع؟"
                    />
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="emc-card detail-empty" style="padding:36px 24px;">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p>لا يوجد أعضاء في هذا القسم بعد</p>
        </div>
        @endif
    </div>

</div>
@endsection
