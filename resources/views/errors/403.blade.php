@extends('errors.layout')

@section('code', '403')
@section('title', 'غير مصرح لك بالدخول')
@section('description', 'ليس لديك صلاحية للوصول إلى هذه الصفحة. إذا كنت تعتقد أن هذا خطأ، تواصل مع مدير النظام.')
@section('icon-bg', '#FEF2F2')
@section('icon')
<svg width="32" height="32" fill="none" stroke="#DC2626" viewBox="0 0 24 24" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
</svg>
@endsection
