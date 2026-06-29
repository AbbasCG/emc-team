@extends('layouts.admin')

@section('title', $jobDescription->title_ar ?: $jobDescription->title)
@section('page-title', 'بطاقة الوصف الوظيفي')
@section('page-subtitle')
    @if($linkedVolunteers->isNotEmpty())
        {{ $linkedVolunteers->first()->name }}
    @else
        {{ $jobDescription->title_ar ?: $jobDescription->title }}
    @endif
@endsection

@section('page-actions')
    <a href="{{ route('admin.job-descriptions.edit', $jobDescription) }}" class="btn-primary" title="تعديل" aria-label="تعديل">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        تعديل
    </a>
    <a href="{{ route('admin.job-descriptions.index') }}" class="btn-secondary">← العودة</a>
@endsection

@section('content')

@include('admin.job-descriptions._styles')

@php
    $primaryVolunteer = $linkedVolunteers->first();
    $otherVolunteers = $linkedVolunteers->skip(1);
    $hasTasks = collect(['task_1','task_2','task_3','task_4'])->contains(fn($f) => $jobDescription->$f);
    $hardChips = $jobDescription->hard_skills
        ? array_filter(array_map('trim', preg_split('/[,،\n]+/u', $jobDescription->hard_skills)))
        : [];
    $softChips = $jobDescription->soft_skills
        ? array_filter(array_map('trim', preg_split('/[,،\n]+/u', $jobDescription->soft_skills)))
        : [];
    $isActive = $jobDescription->is_active && ($jobDescription->jd_status ?? 'active') === 'active';
    $jobTitle = $jobDescription->title_ar ?: $jobDescription->title;
@endphp

<div class="jd-show-page">

    {{-- Hero: volunteer identity → job title → metadata --}}
    <div class="jd-hero">

        {{-- 1. Volunteer identity header --}}
        <div class="jd-vol-identity">
            @if($primaryVolunteer)
            <div class="jd-vol-identity-row">
                <div class="jd-vol-identity-avatar">
                    <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="jd-vol-identity-body">
                    <div class="jd-vol-identity-eyebrow">المتطوع المرتبط</div>
                    <h1 class="jd-vol-identity-name">
                        <a href="{{ route('admin.volunteers.show', $primaryVolunteer) }}">{{ $primaryVolunteer->name }}</a>
                    </h1>
                    <div class="jd-vol-identity-contact">
                        <span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $primaryVolunteer->email }}
                        </span>
                        <span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $primaryVolunteer->phone ?? '—' }}
                        </span>
                    </div>
                    <div class="jd-vol-identity-badges">
                        @if($primaryVolunteer->department)
                        <span class="jd-badge jd-badge-dept">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                            {{ $primaryVolunteer->department->name }}
                        </span>
                        @elseif($jobDescription->department)
                        <span class="jd-badge jd-badge-dept">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                            {{ $jobDescription->department->name }}
                        </span>
                        @endif
                        @if($linkedVolunteers->count() > 1)
                        <span class="jd-vol-chip-count">{{ $linkedVolunteers->count() }} متطوعين</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.volunteers.show', $primaryVolunteer) }}" class="jd-vol-identity-view">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    عرض الملف
                </a>
            </div>

            @if($otherVolunteers->isNotEmpty())
            <div class="jd-vol-identity-chips">
                <span style="font-size:0.68rem;font-weight:700;color:#94A3B8;align-self:center;">متطوعون آخرون:</span>
                @foreach($otherVolunteers as $v)
                <a href="{{ route('admin.volunteers.show', $v) }}" class="jd-vol-chip">{{ $v->name }}</a>
                @endforeach
            </div>
            @endif

            @else
            <div class="jd-vol-identity-empty">
                <div class="jd-vol-identity-empty-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <p class="jd-vol-identity-empty-text">لا يوجد متطوع مرتبط بهذه البطاقة</p>
            </div>
            @endif
        </div>

        <div class="jd-hero-divider"></div>

        {{-- 2. Job title --}}
        <div class="jd-job-title-block">
            <div class="jd-job-title-label">المسمى الوظيفي</div>
            <h2 class="jd-hero-title">{{ $jobTitle }}</h2>
            @if($jobDescription->title && $jobDescription->title_ar && $jobDescription->title !== $jobDescription->title_ar)
            <p class="jd-hero-sub">{{ $jobDescription->title }}</p>
            @endif
            @if($jobDescription->direct_supervisor)
            <div class="jd-hero-supervisor">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                المسؤول المباشر: {{ $jobDescription->direct_supervisor }}
            </div>
            @endif
        </div>

        <div class="jd-hero-divider"></div>

        {{-- 3. Job metadata grid --}}
        <div class="jd-hero-meta-wrap">
            <div class="jd-hero-grid">
                <div>
                    <div class="jd-hero-item-label">القسم</div>
                    <div class="jd-hero-item-value">
                        @if($jobDescription->department)
                        <a href="{{ route('admin.departments.show', $jobDescription->department) }}">{{ $jobDescription->department->name }}</a>
                        @else — @endif
                    </div>
                </div>
                <div>
                    <div class="jd-hero-item-label">مكان العمل</div>
                    <div class="jd-hero-item-value">{{ $jobDescription->work_location_label }}</div>
                </div>
                <div>
                    <div class="jd-hero-item-label">التعليم</div>
                    <div class="jd-hero-item-value">{{ $jobDescription->education_requirements ?? '—' }}</div>
                </div>
                <div>
                    <div class="jd-hero-item-label">الخبرة</div>
                    <div class="jd-hero-item-value">{{ $jobDescription->years_experience ?? '—' }}</div>
                </div>
                <div>
                    <div class="jd-hero-item-label">الحالة</div>
                    <div class="jd-hero-item-value">
                        @if($isActive)
                        <span class="jd-badge jd-badge-active">نشط</span>
                        @else
                        <span class="jd-badge jd-badge-inactive">{{ $jobDescription->jd_status_label }}</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="jd-hero-item-label">تاريخ الإنشاء</div>
                    <div class="jd-hero-item-value">{{ $jobDescription->created_at->locale('ar')->isoFormat('D MMM YYYY') }}</div>
                </div>
                <div>
                    <div class="jd-hero-item-label">آخر تحديث</div>
                    <div class="jd-hero-item-value">{{ $jobDescription->updated_at->locale('ar')->isoFormat('D MMM YYYY') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- General description --}}
    @if($jobDescription->general_objective)
    <div class="jd-section">
        <div class="jd-section-head">الوصف العام</div>
        <div class="jd-block">
            <p class="jd-block-text">{{ $jobDescription->general_objective }}</p>
        </div>
    </div>
    @endif

    {{-- Responsibilities --}}
    @if($hasTasks)
    <div class="jd-section">
        <div class="jd-section-head">المسؤوليات</div>
        <div class="jd-task-list">
            @foreach(['task_1','task_2','task_3','task_4'] as $field)
            @if($jobDescription->$field)
            <div class="jd-task-item">
                <span class="jd-task-check">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </span>
                <p class="jd-task-text">{{ $jobDescription->$field }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Qualifications --}}
    @if($jobDescription->education_requirements || $jobDescription->years_experience || $jobDescription->certifications || $jobDescription->languages)
    <div class="jd-section">
        <div class="jd-section-head">المؤهلات</div>
        <div class="jd-qual-grid">
            @if($jobDescription->education_requirements)
            <div class="jd-qual-item">
                <div class="jd-qual-label">التعليم</div>
                <div class="jd-qual-value">{{ $jobDescription->education_requirements }}</div>
            </div>
            @endif
            @if($jobDescription->years_experience)
            <div class="jd-qual-item">
                <div class="jd-qual-label">سنوات الخبرة</div>
                <div class="jd-qual-value">{{ $jobDescription->years_experience }}</div>
            </div>
            @endif
            @if($jobDescription->certifications)
            <div class="jd-qual-item">
                <div class="jd-qual-label">الشهادات</div>
                <div class="jd-qual-value">{{ $jobDescription->certifications }}</div>
            </div>
            @endif
            @if($jobDescription->languages)
            <div class="jd-qual-item">
                <div class="jd-qual-label">اللغات</div>
                <div class="jd-qual-value">{{ $jobDescription->languages }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Skills --}}
    @if(count($hardChips) || count($softChips) || ($jobDescription->hard_skills && !count($hardChips)) || ($jobDescription->soft_skills && !count($softChips)))
    <div class="jd-section">
        <div class="jd-section-head">المهارات</div>
        <div class="jd-block">
            @if(count($softChips))
            <div class="jd-skills-group">
                <div class="jd-skills-label">المهارات الشخصية</div>
                <div class="jd-chips">
                    @foreach($softChips as $chip)
                    <span class="jd-chip jd-chip-soft">{{ $chip }}</span>
                    @endforeach
                </div>
            </div>
            @elseif($jobDescription->soft_skills)
            <div class="jd-skills-group">
                <div class="jd-skills-label">المهارات الشخصية</div>
                <p class="jd-block-text">{{ $jobDescription->soft_skills }}</p>
            </div>
            @endif

            @if(count($hardChips))
            <div class="jd-skills-group">
                <div class="jd-skills-label">المهارات التقنية</div>
                <div class="jd-chips">
                    @foreach($hardChips as $chip)
                    <span class="jd-chip">{{ $chip }}</span>
                    @endforeach
                </div>
            </div>
            @elseif($jobDescription->hard_skills)
            <div class="jd-skills-group">
                <div class="jd-skills-label">المهارات التقنية</div>
                <p class="jd-block-text">{{ $jobDescription->hard_skills }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Multiple volunteers only — single volunteer is fully shown in hero --}}
    @if($linkedVolunteers->count() > 1)
    <div class="jd-section">
        <div class="jd-section-head">جميع المتطوعين المرتبطين ({{ $linkedVolunteers->count() }})</div>
        <div class="jd-vol-grid">
            @foreach($linkedVolunteers as $v)
            <div class="jd-vol-card">
                <div class="jd-vol-card-head">
                    <div class="jd-vol-avatar">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h4 class="jd-vol-name">{{ $v->name }}</h4>
                        <div class="jd-vol-role">{{ $jobTitle }}</div>
                    </div>
                </div>
                <div class="jd-vol-rows">
                    <div class="jd-vol-row">
                        <span class="jd-vol-row-label">القسم</span>
                        <span class="jd-vol-row-value">{{ $v->department?->name ?? '—' }}</span>
                    </div>
                    <div class="jd-vol-row">
                        <span class="jd-vol-row-label">البريد</span>
                        <span class="jd-vol-row-value">{{ $v->email }}</span>
                    </div>
                    <div class="jd-vol-row">
                        <span class="jd-vol-row-label">الهاتف</span>
                        <span class="jd-vol-row-value">{{ $v->phone ?? '—' }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.volunteers.show', $v) }}" class="jd-vol-view">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    عرض الملف
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection
