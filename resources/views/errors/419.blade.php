@extends('errors.layout')

@section('code', '419')
@section('title', 'انتهت صلاحية الجلسة')
@section('description', 'انتهت صلاحية الصفحة بسبب انتهاء مهلة الجلسة. يرجى العودة والمحاولة مجدداً.')
@section('icon-bg', '#FFFBEB')
@section('icon')
<svg width="32" height="32" fill="none" stroke="#F59E0B" viewBox="0 0 24 24" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>
@endsection
