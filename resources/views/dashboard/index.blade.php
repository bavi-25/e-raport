@extends('layouts.admin')
@section('title', 'E-Raport | Dashboard')

@section('content')
@includeWhen(in_array('super_admin', $roles), 'dashboard.partials.super_admin')
@includeWhen(in_array('admin', $roles), 'dashboard.partials.admin')
@includeWhen(in_array('kepala_sekolah', $roles), 'dashboard.partials.headmaster')
@includeWhen(in_array('wali_kelas', $roles), 'dashboard.partials.wali_kelas')
@includeWhen(in_array('guru', $roles), 'dashboard.partials.guru')
@includeWhen(in_array('siswa', $roles), 'dashboard.partials.student')
@endsection