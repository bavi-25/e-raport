@extends('layouts.admin')
@section('title', 'E-Raport | Class')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Enrollments</h3>
            </div>
        </div>
        <div class="row">
            @forelse($enrollments as $en)
            @php
            $cls = optional($en->class);
            $std = optional($en->student);
            $ay = optional($en->academicYear);
            @endphp

            <div class="col-md-6 col-lg-4 d-flex">
                <div class="card flex-fill shadow-sm mb-3 w-100">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chalkboard-teacher mr-1"></i>
                            <strong>{{ $cls->name ?? '—' }}</strong>
                        </h3>
                        <div class="card-tools">
                            @if($ay && $ay->status === 'Active')
                            <span class="badge badge-success">Active</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <small class="text-muted d-block">Academic Year</small>
                                <span class="font-weight-bold">
                                    @if($ay)
                                    {{ $ay->code }} ({{ $ay->term }})
                                    @else
                                    —
                                    @endif
                                </span>
                            </li>

                            <li class="mb-2">
                                <small class="text-muted d-block">Enrolled At</small>
                                <span class="font-weight-bold">
                                    {{ optional($en->created_at)->format('d M Y') ?? '—' }}
                                </span>
                            </li>
                        </ul>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('raport.download', $en->id) }}" class="btn btn-sm btn-danger">
                            <i class="bi bi-journal-text"></i> Report
                        </a>
                        <a href="{{ route('student.enrollment.show', $en->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center text-muted py-5">
                    <i class="far fa-folder-open fa-2x mb-2"></i>
                    <div>No enrollments found.</div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection