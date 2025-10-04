@extends('layouts.admin')
@section('title', 'E-Raport | Subject Detail')

@section('content')
<div class="row">
    <div class="col-12">
       <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a href="{{ route('student.enrollment.show', $enrollment->id) }}" class="btn btn-danger btn-sm mr-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
       </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-book-open mr-1"></i> Subject</h3>
            </div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt>Class</dt>
                    <dd>{{ optional($enrollment->class)->name ?? '—' }}</dd>

                    <dt>Subject</dt>
                    <dd>{{ optional($classSubject->subject)->code }} — {{ optional($classSubject->subject)->name }}</dd>

                    <dt>Teacher</dt>
                    <dd>{{ optional($classSubject->teacher)->name ?? '—' }}</dd>

                    <dt>Student</dt>
                    <dd>{{ optional($enrollment->student)->name ?? '—' }}</dd>

                    <dt>Academic Year</dt>
                    <dd>
                        {{ optional($enrollment->academicYear)->code }}
                        <small class="text-muted">({{ optional($enrollment->academicYear)->term }})</small>
                    </dd>
                </dl>
            </div>
        </div>

        @if($classSubject->finalGrades->first())
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-certificate mr-1"></i> Final Grade</h3>
            </div>
            <div class="card-body">
                <div class="h4 mb-0">{{ $classSubject->finalGrades->first()->final_score }}</div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0"><i class="fas fa-tasks mr-1"></i> Assessments (with Scores)</h3>
            </div>

            <div class="card-body p-0">
                @if(empty($assessmentSummaries))
                <div class="p-4 text-center text-muted">
                    <i class="far fa-folder-open fa-2x mb-2"></i>
                    <div>No assessments for this enrollment.</div>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th class="text-right">Scored / Items</th>
                                <th class="text-right">Score</th>
                                <th class="text-right">Max</th>
                                <th class="text-right">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assessmentSummaries as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="font-weight-bold">{{ $row['title'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($row['date'])->format('d M Y') }}</td>
                                <td class="text-right">{{ $row['scored_items'] }} / {{ $row['items_count'] }}</td>
                                <td class="text-right">{{ $row['score_sum'] }}</td>
                                <td class="text-right">{{ $row['max_sum'] }}</td>
                                <td class="text-right">{{ $row['percent'] !== null ? $row['percent'].'%' : '—' }}</td>
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
@endsection