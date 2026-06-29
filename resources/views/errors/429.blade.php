@extends('errors.layout')

@section('code', '429')
@section('title', 'طلبات كثيرة جداً')
@section('description', 'لقد أرسلت طلبات كثيرة في وقت قصير. يرجى الانتظار قليلاً ثم المحاولة مجدداً.')
@section('icon-bg', '#FFF7ED')
@section('icon')
<svg width="32" height="32" fill="none" stroke="#EC943C" viewBox="0 0 24 24" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
</svg>
@endsection
