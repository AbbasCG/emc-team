@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'نظرة شاملة على نظام إدارة المتطوعين')

@section('page-actions')
    <a href="{{ route('admin.volunteers.create') }}" class="btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M12 4v16m8-8H4"/></svg>
        إضافة متطوع
    </a>
@endsection

@section('content')
<div class="detail-page">
{{-- KPI Grid — full width, 6 columns on desktop --}}
<div class="kpi-grid">

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-blue">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div class="kpi-label">إجمالي المتطوعين</div>
        <div class="kpi-value num">{{ number_format($totalVolunteers) }}</div>
    </div>

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-orange">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="kpi-label">إجمالي الأقسام</div>
        <div class="kpi-value num">{{ number_format($totalDepartments) }}</div>
    </div>

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-deep">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div class="kpi-label">بطاقات الوصف الوظيفي</div>
        <div class="kpi-value num">{{ number_format($totalJobDescriptions) }}</div>
    </div>

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-green">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="kpi-label">المتطوعون هذا الشهر</div>
        <div class="kpi-value num">{{ number_format($newThisMonth) }}</div>
    </div>

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-blue">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
        </div>
        <div class="kpi-label">أقسام تحتوي على متطوعين</div>
        <div class="kpi-value num">{{ number_format($departmentsWithVolunteers) }}</div>
    </div>

    <div class="emc-stat-card">
        <div class="kpi-icon kpi-icon-deep">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6"/></svg>
        </div>
        <div class="kpi-label">الوظائف المسجلة</div>
        <div class="kpi-value num">{{ number_format($registeredJobs) }}</div>
    </div>

</div>

{{-- Charts Row --}}
<div class="emc-grid-2 mb">

    {{-- Monthly submissions --}}
    <div class="emc-card" style="padding:22px;">
        <h3 style="font-size:0.88rem;font-weight:900;color:#22334A;margin:0 0 2px;">التسجيلات الشهرية</h3>
        <p style="font-size:0.72rem;color:#64748B;margin:0 0 18px;">آخر 6 أشهر</p>
        @php $maxCount = $monthlyTrend->max('count') ?: 1; @endphp
        <div style="display:flex;align-items:flex-end;gap:8px;height:130px;">
            @foreach($monthlyTrend as $point)
            @php $h = max(4, ($point['count'] / $maxCount) * 100); @endphp
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;height:100%;justify-content:flex-end;">
                <span class="num" style="font-size:0.65rem;font-weight:700;color:{{ $point['count'] > 0 ? '#22334A' : '#CBD5E1' }};">{{ $point['count'] ?: '' }}</span>
                <div style="width:100%;border-radius:4px 4px 0 0;background:{{ $point['count'] > 0 ? '#2691C2' : '#E2E8F0' }};height:{{ $h }}px;min-height:4px;"></div>
                <span style="font-size:0.6rem;color:#94a3b8;">{{ $point['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Department coverage --}}
    <div class="emc-card" style="padding:22px;">
        <h3 style="font-size:0.88rem;font-weight:900;color:#22334A;margin:0 0 2px;">تغطية الأقسام</h3>
        <p style="font-size:0.72rem;color:#64748B;margin:0 0 18px;">نسبة الأقسام التي تحتوي على متطوعين</p>
        <div style="display:flex;align-items:center;gap:20px;">
            <div style="position:relative;width:100px;height:100px;flex-shrink:0;">
                <svg viewBox="0 0 36 36" style="transform:rotate(-90deg);">
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#E2E8F0" stroke-width="3"/>
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#2691C2" stroke-width="3"
                            stroke-dasharray="{{ $departmentCoverage }} {{ 100 - $departmentCoverage }}"
                            stroke-linecap="round"/>
                </svg>
                <div class="num" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;color:#22334A;">{{ $departmentCoverage }}%</div>
            </div>
            <div>
                <div style="font-size:0.82rem;color:#475569;margin-bottom:6px;"><strong class="num">{{ $departmentsWithVolunteers }}</strong> من <strong class="num">{{ $totalDepartments }}</strong> قسم</div>
                <div style="font-size:0.75rem;color:#94a3b8;">أقسام بها متطوعون مسجلون</div>
            </div>
        </div>
    </div>

</div>

{{-- Department charts --}}
<div class="emc-grid-2 mb">

    {{-- Volunteers per department --}}
    <div class="emc-card" style="padding:22px;">
        <h3 style="font-size:0.88rem;font-weight:900;color:#22334A;margin:0 0 2px;">المتطوعون حسب القسم</h3>
        <p style="font-size:0.72rem;color:#64748B;margin:0 0 16px;">توزيع الأعضاء</p>
        @if($byDepartment->where('volunteers_count','>',0)->count())
        @php $maxVol = $byDepartment->max('volunteers_count') ?: 1; @endphp
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($byDepartment->where('volunteers_count','>',0)->take(6) as $dept)
            @php $pct = round($dept->volunteers_count / $maxVol * 100); @endphp
            <a href="{{ route('admin.departments.show', $dept) }}" style="text-decoration:none;">
                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:0.78rem;font-weight:600;color:#475569;">{{ $dept->name }}</span>
                    <span class="num" style="font-size:0.78rem;font-weight:800;color:#22334A;">{{ $dept->volunteers_count }}</span>
                </div>
                <div class="emc-progress-track">
                    <div class="emc-progress-fill" style="width:{{ $pct }}%;background:#2691C2;"></div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p style="font-size:0.82rem;color:#94a3b8;padding:20px 0;text-align:center;">لا يوجد متطوعون في الأقسام بعد</p>
        @endif
    </div>

    {{-- Job descriptions per department --}}
    <div class="emc-card" style="padding:22px;">
        <h3 style="font-size:0.88rem;font-weight:900;color:#22334A;margin:0 0 2px;">الوظائف حسب القسم</h3>
        <p style="font-size:0.72rem;color:#64748B;margin:0 0 16px;">بطاقات الوصف الوظيفي</p>
        @if($jobsByDepartment->count())
        @php $maxJobs = $jobsByDepartment->max('job_descriptions_count') ?: 1; @endphp
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($jobsByDepartment->take(6) as $dept)
            @php $pct = round($dept->job_descriptions_count / $maxJobs * 100); @endphp
            <a href="{{ route('admin.departments.show', $dept) }}" style="text-decoration:none;">
                <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:0.78rem;font-weight:600;color:#475569;">{{ $dept->name }}</span>
                    <span class="num" style="font-size:0.78rem;font-weight:800;color:#22334A;">{{ $dept->job_descriptions_count }}</span>
                </div>
                <div class="emc-progress-track">
                    <div class="emc-progress-fill orange" style="width:{{ $pct }}%;"></div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p style="font-size:0.82rem;color:#94a3b8;padding:20px 0;text-align:center;">لا توجد وظائف مسجلة بعد</p>
        @endif
    </div>

</div>

{{-- Departments list + Recent volunteers --}}
<div class="emc-grid-2-3 mb">

    <div class="emc-card" style="overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;">
            <h3 style="font-size:0.85rem;font-weight:900;color:#22334A;margin:0;">الأقسام</h3>
            <a href="{{ route('admin.departments.index') }}" style="font-size:0.72rem;font-weight:700;color:#2691C2;text-decoration:none;">عرض الكل</a>
        </div>
        @if($byDepartment->count())
        @foreach($byDepartment->take(6) as $dept)
        <a href="{{ route('admin.departments.show', $dept) }}" class="clickable-row" style="display:flex;align-items:center;gap:12px;padding:10px 20px;text-decoration:none;border-bottom:1px solid #F1F5F9;">
            <div style="width:32px;height:32px;border-radius:8px;background:#F8FAFC;border:1px solid #E2E8F0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="15" height="15" fill="none" stroke="#64748B" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.8rem;font-weight:700;color:#22334A;">{{ $dept->name }}</div>
            </div>
            <span class="num" style="font-size:0.75rem;color:#64748B;">{{ $dept->volunteers_count }} · {{ $dept->job_descriptions_count }}</span>
        </a>
        @endforeach
        @else
        <p style="font-size:0.82rem;color:#94a3b8;padding:24px;text-align:center;">لا توجد أقسام</p>
        @endif
    </div>

    <div class="emc-card" style="overflow:hidden;">
        <div style="padding:14px 20px;border-bottom:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;">
            <h3 style="font-size:0.85rem;font-weight:900;color:#22334A;margin:0;">أحدث المتطوعين</h3>
            <a href="{{ route('admin.volunteers.index') }}" style="font-size:0.72rem;font-weight:700;color:#2691C2;text-decoration:none;">عرض الكل</a>
        </div>
        @if($recentVolunteers->count())
        <div class="table-desktop">
        <table class="emc-table">
            <thead>
                <tr>
                    <th style="padding-right:20px;">المتطوع</th>
                    <th>القسم</th>
                    <th>الوظيفة</th>
                    <th style="width:50px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentVolunteers as $v)
                <tr class="clickable-row" onclick="window.location='{{ route('admin.volunteers.show', $v) }}'">
                    <td style="padding-right:20px;">
                        <div style="font-weight:700;color:#22334A;font-size:0.82rem;">{{ $v->name }}</div>
                        <div style="color:#94a3b8;font-size:0.7rem;">{{ $v->email }}</div>
                    </td>
                    <td style="font-size:0.78rem;color:#64748B;">{{ $v->department?->name ?? '—' }}</td>
                    <td style="font-size:0.78rem;color:#64748B;max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $v->jobDescription?->title_ar ?? '—' }}</td>
                    <td onclick="event.stopPropagation()">
                        <x-icon-actions :view="route('admin.volunteers.show', $v)" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mobile-cards">
            @foreach($recentVolunteers as $v)
            <div class="mobile-card clickable" onclick="window.location='{{ route('admin.volunteers.show', $v) }}'">
                <div class="mobile-card-head">
                    <div>
                        <div class="mobile-card-title">{{ $v->name }}</div>
                        <div class="mobile-card-sub">{{ $v->email }}</div>
                    </div>
                </div>
                <div class="mobile-card-rows">
                    <div class="mobile-card-row"><span>القسم</span><span>{{ $v->department?->name ?? '—' }}</span></div>
                    <div class="mobile-card-row"><span>الوظيفة</span><span>{{ $v->jobDescription?->title_ar ?? '—' }}</span></div>
                </div>
                <div class="mobile-card-foot" onclick="event.stopPropagation()">
                    <x-icon-actions :view="route('admin.volunteers.show', $v)" />
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="font-size:0.82rem;color:#94a3b8;padding:24px;text-align:center;">لا يوجد متطوعون بعد</p>
        @endif
    </div>

</div>
</div>

@endsection
