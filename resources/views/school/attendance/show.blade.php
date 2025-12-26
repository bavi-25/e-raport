@extends('layouts.admin')

@section('title', 'E-Report | Attendance Details')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ route('school.attendance.history', $attendance->class_subject_id) }}"
                        class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Class</strong><br>
                        {{ $attendance->classSubject->class->name }}
                    </div>
                    <div class="col-md-4">
                        <strong>Subject</strong><br>
                        {{ $attendance->classSubject->subject->name }}
                    </div>
                    <div class="col-md-4">
                        <strong>Date</strong><br>
                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Present</span>
                <span class="info-box-number">{{ $summary['present'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-thermometer-half"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sick</span>
                <span class="info-box-number">{{ $summary['sick'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-envelope"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Excused</span>
                <span class="info-box-number">{{ $summary['excused'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="fas fa-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Absent</span>
                <span class="info-box-number">{{ $summary['absent'] }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Student ID (NIS/NISN)</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendance->entries as $entry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $entry->student->name ?? 'Student Not Found' }}</td>
                            <td>{{ $entry->student->nip_nis ?? '-' }}</td>
                            <td>
                                @switch($entry->status)
                                @case('present')
                                <span class="badge badge-success">Present</span>
                                @break
                                @case('sick')
                                <span class="badge badge-warning">Sick</span>
                                @break
                                @case('excused')
                                <span class="badge badge-info">Excused</span>
                                @break
                                @case('absent')
                                <span class="badge badge-danger">Absent</span>
                                @break
                                @default
                                <span class="badge badge-secondary">
                                    {{ ucfirst($entry->status) }}
                                </span>
                                @endswitch
                            </td>
                            <td>{{ $entry->remarks ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No attendance data available for this date.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total Students</th>
                            <th colspan="2">{{ $summary['total'] }}</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
        </div>
    </div>
</div>
@endsection