@extends('layouts.admin')

@section('title', 'الأقسام')
@section('page-title', 'الأقسام')
@section('page-subtitle', 'إدارة أقسام ووحدات المنظمة')

@section('page-actions')
    <a href="{{ route('admin.departments.create') }}" class="btn-primary">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><path d="M12 4v16m8-8H4"/></svg>
        قسم جديد
    </a>
@endsection

@section('content')

<div class="stats-bar">
    <span style="font-size:0.8rem;font-weight:700;color:#22334A;">{{ $departments->count() }} قسم</span>
    <div class="stats-bar-divider"></div>
    <span class="num" style="font-size:0.8rem;color:#64748B;">{{ $departments->sum('volunteers_count') }} متطوع</span>
    <div class="stats-bar-divider"></div>
    <span class="num" style="font-size:0.8rem;color:#64748B;">{{ $departments->sum('job_descriptions_count') }} وظيفة</span>
</div>

<div class="emc-grid-cards">
    @forelse($departments as $dept)

    <div class="emc-card dept-card" style="padding:0;overflow:hidden;display:flex;flex-direction:column;">

        <a href="{{ route('admin.departments.show', $dept) }}" class="clickable-card" style="padding:18px 20px 14px;flex:1;">

            <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#F8FAFC;border:1px solid #E2E8F0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="18" height="18" fill="none" stroke="#2691C2" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <h3 style="font-size:0.88rem;font-weight:900;color:#22334A;margin:0;line-height:1.3;">{{ $dept->name_ar ?: $dept->name }}</h3>
                    @if($dept->name_ar && $dept->name && $dept->name_ar !== $dept->name)
                    <p style="font-size:0.7rem;color:#94a3b8;margin:2px 0 0;">{{ $dept->name }}</p>
                    @endif
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                <div style="padding:8px 10px;background:#F8FAFC;border-radius:8px;border:1px solid #E2E8F0;">
                    <div class="num" style="font-size:1.2rem;font-weight:900;color:#22334A;">{{ $dept->volunteers_count }}</div>
                    <div style="font-size:0.65rem;color:#64748B;">متطوع</div>
                </div>
                <div style="padding:8px 10px;background:#F8FAFC;border-radius:8px;border:1px solid #E2E8F0;">
                    <div class="num" style="font-size:1.2rem;font-weight:900;color:#22334A;">{{ $dept->job_descriptions_count }}</div>
                    <div style="font-size:0.65rem;color:#64748B;">وظيفة</div>
                </div>
            </div>

            @if($dept->leader_name)
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                <svg width="13" height="13" fill="none" stroke="#64748B" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span style="font-size:0.75rem;color:#64748B;">{{ $dept->leader_name }}</span>
            </div>
            @endif

            <div style="font-size:0.68rem;color:#94a3b8;">
                آخر تحديث {{ $dept->updated_at->locale('ar')->diffForHumans() }}
            </div>
        </a>

        <div style="padding:10px 16px;border-top:1px solid #F1F5F9;background:#FAFAFA;display:flex;align-items:center;justify-content:flex-end;gap:6px;" onclick="event.stopPropagation()">
            <a href="{{ route('admin.departments.show', $dept) }}" class="icon-btn icon-btn-view" title="عرض التفاصيل" aria-label="عرض التفاصيل">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </a>
            <a href="{{ route('admin.departments.edit', $dept) }}" class="icon-btn icon-btn-edit" title="تعديل القسم" aria-label="تعديل">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
            <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" onsubmit="return confirm('هل أنت متأكد من حذف قسم «{{ $dept->name }}»؟')">
                @csrf @method('DELETE')
                <button type="submit" class="icon-btn icon-btn-delete" title="حذف القسم" aria-label="حذف">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
    </div>

    @empty
    <div style="grid-column:1/-1;">
        <div class="emc-card" style="padding:48px 24px;text-align:center;">
            <svg width="40" height="40" fill="none" stroke="#CBD5E1" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 12px;"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
            <h3 style="font-size:0.95rem;font-weight:700;color:#64748B;margin:0 0 6px;">لا توجد أقسام بعد</h3>
            <p style="font-size:0.82rem;color:#94a3b8;margin:0 0 16px;">أنشئ أول قسم للبدء في تنظيم المتطوعين</p>
            <a href="{{ route('admin.departments.create') }}" class="btn-primary" style="padding:8px 20px;font-size:0.82rem;">إنشاء أول قسم</a>
        </div>
    </div>
    @endforelse
</div>

<style>
    .dept-card { transition: box-shadow 0.2s; }
    .dept-card:hover { box-shadow: 0 4px 16px rgba(34,51,74,0.07); }
</style>

@endsection
