@extends('errors.layout')

@section('code', '404')
@section('title', 'الصفحة غير موجودة')
@section('description', 'الصفحة التي تبحث عنها غير موجودة أو ربما تم نقلها أو حذفها.')
@section('icon-bg', '#FFF7ED')
@section('icon')
<svg width="32" height="32" fill="none" stroke="#EC943C" viewBox="0 0 24 24" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>
@endsection
