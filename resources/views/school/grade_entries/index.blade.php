@extends('layouts.admin')
@section('title', 'E-Report | Grade Entries')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('school.grade_entries.index') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Academic Year</label>
                                <select name="academic_year_id" class="form-control select2bs4"
                                    onchange="this.form.submit()">
                                    <option value="">- Select -</option>
                                    @foreach ($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $academic_year_id == $ay->id ? 'selected' : '' }}>
                                        {{ $ay->code }} {{ ($ay->status == 'Active') ? ' -- Active --' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_id">Class</label>
                                <select name="class_id" class="form-control select2bs4" onchange="this.form.submit()"
                                    {{ empty($academic_year_id) ? 'disabled' : '' }}>
                                    <option value="">- Select -</option>
                                    @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ $class_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subject</label>
                                <select name="class_subject_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($class_id) ? 'disabled' : '' }}>
                                    <option value="">- Select -</option>
                                    @foreach ($classSubjects as $cs)
                                    <option value="{{ $cs->id }}" {{ $class_subject_id == $cs->id ? 'selected' : '' }}>
                                        {{ $cs->subject->code ?? 'SUB' }} — {{ $cs->subject->name ?? 'Subject' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Student</label>
                                <select name="enrollment_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($class_subject_id) ? 'disabled' : '' }}>
                                    <option value="">- Select -</option>
                                    @foreach ($enrollments as $e)
                                    <option value="{{ $e->id }}" {{ $enrollment_id == $e->id ? 'selected' : '' }}>
                                        {{ $e->student->name ?? 'Student' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assessment</label>
                                <select name="assessment_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($enrollment_id) ? 'disabled' : '' }}>
                                    <option value="">- Select / Create New -</option>
                                    @foreach ($assessments as $a)
                                    <option value="{{ $a->id }}" {{ $assessment_id == $a->id ? 'selected' : '' }}>
                                        {{ $a->date }} — {{ $a->title }}
                                        ({{ $a->assessmentComponent->name ?? 'Component' }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if($enrollment_id && $class_subject_id)
                <form method="POST" action="{{ route('school.grade_entries.store') }}">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $academic_year_id }}">
                    <input type="hidden" name="class_id" value="{{ $class_id }}">
                    <input type="hidden" name="class_subject_id" value="{{ $class_subject_id }}">
                    <input type="hidden" name="enrollment_id" value="{{ $enrollment_id }}">
                    @if($assessment)
                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                    @endif

                    @if(!$assessment)
                    <div class="alert alert-info">
                        No assessment selected. Please fill in the following fields to create a new assessment
                        (for this student only).
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Mathematics Midterm"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ now()->toDateString() }}"
                                required>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Assessment Component</label>
                            <select name="assessment_component_id" class="form-control" required>
                                @foreach(\App\Models\AssessmentComponent::where('tenant_id',
                                auth()->user()->tenant_id)->orderBy('name')->get(['id','name','weight']) as $comp)
                                <option value="{{ $comp->id }}">
                                    {{ $comp->name }} ({{ $comp->weight }}%)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-secondary">
                        <strong>Note:</strong>
                        Please create items (question indicators / competencies) for this new assessment
                        in the <em>Assessments → Items</em> menu after saving,
                        or enter the scores later once the items have been created.
                    </div>
                    @endif

                    @if($assessment && $items->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:60%">Competency / Item</th>
                                    <th style="width:15%">Max Score</th>
                                    <th style="width:25%">Student Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $it)
                                @php
                                $val = $gradeByItem[$it->id] ?? '';
                                @endphp
                                <tr>
                                    <td><strong>{{ $it->competency_code }}</strong></td>
                                    <td>{{ number_format((float)$it->max_score, 2) }}</td>
                                    <td>
                                        <input type="number" step="0.01" min="0" max="{{ (float)$it->max_score }}"
                                            name="scores[{{ $it->id }}]" class="form-control" value="{{ $val }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif($assessment && !$items->count())
                    <div class="alert alert-warning">
                        The selected assessment does not have any items yet.
                        Please create items first before entering scores.
                    </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save
                        </button>

                        @if($assessment)
                        <button type="submit" name="next_student" value="1" class="btn btn-outline-secondary">
                            Save & Next Student
                        </button>
                        @endif
                    </div>
                </form>
                @else
                <div class="alert alert-info">
                    Please select Academic Year → Class → Subject → Student to start entering grades.
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection