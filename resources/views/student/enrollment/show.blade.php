{{-- resources/views/student/enrollment/show.blade.php --}}
@extends('layouts.admin')
@section('title', 'E-Raport | Enrollment Detail')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ route('student.enrollment.index') }}" class="btn btn-danger btn-sm mr-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

            </div>
        </div>

        @php
        $en = $enrollment;
        $cls = optional($en->class);
        $ay = optional($en->academicYear);
        $std = optional($en->student);
        $classSubjects = $cls && $cls->relationLoaded('classSubjects')
        ? $cls->classSubjects
        : collect();
        @endphp

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-id-card-alt mr-1"></i> Enrollment
                        </h3>
                    </div>
                    <div class="card-body">
                        <dl class="mb-0">
                            <dt>Student</dt>
                            <dd class="mb-2">{{ $std->name ?? '—' }}</dd>

                            <dt>Class</dt>
                            <dd class="mb-2">
                                <span class="h6 mb-0">{{ $cls->name ?? '—' }}</span>
                            </dd>

                            <dt>Academic Year</dt>
                            <dd class="mb-2">
                                @if($ay)
                                {{ $ay->code }} — <small class="text-muted">{{ $ay->term }}</small>
                                @if($ay->status === 'Active')
                                <span class="badge badge-success ml-1">Active</span>
                                @endif
                                @else
                                —
                                @endif
                            </dd>

                            <dt>Enrolled At</dt>
                            <dd class="mb-2">{{ optional($en->created_at)->format('d M Y') ?? '—' }}</dd>

                            <dt>Total Subjects</dt>
                            <dd class="mb-0">{{ $classSubjects->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-book-open mr-1"></i> Subjects in {{ $cls->name ?? '—' }}
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $classSubjects->count() }} Subjects</span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if($classSubjects->isEmpty())
                        <div class="p-4 text-center text-muted">
                            <i class="far fa-folder-open fa-2x mb-2"></i>
                            <div>No subjects found for this class.</div>
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Teacher</th>
                                        <th class="text-right" style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classSubjects as $i => $cs)
                                    @php
                                    $sub = optional($cs->subject);
                                    $tch = optional($cs->teacher);
                                    @endphp
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $sub->code ?? '—' }}</td>
                                        <td class="font-weight-bold">{{ $sub->name ?? '—' }}</td>
                                        <td>{{ $tch->name ?? '—' }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('student.enrollment.subject_detail', 
                                            ['enrollmentId' => $en->id, 'subjectId' => $sub->id]) }}"
                                                class="btn btn-info btn-sm" tabindex="-1" aria-disabled="true">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection