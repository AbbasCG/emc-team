<svg width="36" height="36" fill="none" stroke="#CBD5E1" viewBox="0 0 24 24" stroke-width="1.5" style="margin:0 auto 10px;display:block;"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
<div style="font-size:0.9rem;font-weight:700;color:#64748B;margin-bottom:4px;">لا يوجد متطوعون مطابقون</div>
@if(request()->hasAny(['search', 'department_id', 'job_description_id']))
<a href="{{ route('admin.volunteers.index') }}" class="btn-secondary" style="margin-top:10px;padding:7px 18px;font-size:0.8rem;display:inline-flex;">مسح الفلتر</a>
@else
<a href="{{ route('admin.volunteers.create') }}" class="btn-primary" style="margin-top:10px;padding:8px 20px;font-size:0.82rem;display:inline-flex;">إضافة أول متطوع</a>
@endif
