@extends('layouts.admin')
@section('title', 'E-Raport | Dashboard')
@section('content')
@if(in_array('super_admin', $roles))
@include('dashboard.partials.super_admin')
@endif

{{-- dashboard untuk guru --}}
@if(in_array('teacher', $roles))
@include('dashboard.partials.teacher')
@endif

{{-- dashboard untuk siswa --}}
@if(in_array('siswa', $roles))
@include('dashboard.partials.student')
@endif
@endsection