@extends('layouts.admin')

@section('title', 'E-Report | Attendance')

@section('content')
<form method="POST" action="{{ route('school.attendance.store') }}">
    @csrf
    <input type="hidden" name="class_subject_id" value="{{ $classSubject->id }}">
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Class</strong><br>
                            {{ $classSubject->class->name }}
                        </div>
                        <div class="col-md-4">
                            <strong>Subject</strong><br>
                            {{ $classSubject->subject->name }}
                        </div>
                        <div class="col-md-4">
                            <strong>Date</strong><br>
                            {{ $today->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Teaching Journal</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Learning Material / Activities</label>
                        <textarea name="notes" class="form-control" rows="4"
                            placeholder="Example: Discussion of Chapter 3 – Linear Equations...">{{ optional($attendance)->notes }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Student Attendance List</h5>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Student</th>
                                <th width="250">Attendance Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollments as $i => $enrollment)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $enrollment->student->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @php
                                        $savedEntry = $attendanceEntries->get($enrollment->student->id);
                                        $savedStatus = optional($savedEntry)->status;
                                        @endphp

                                        @foreach ($status as $item)
                                        @php $val = Str::lower($item); @endphp

                                        <label class="mr-2">
                                            <input type="radio" name="entries[{{ $enrollment->student->id }}][status]"
                                                value="{{ $val }}"
                                                {{ $savedStatus ? ($savedStatus === $val ? 'checked' : '') : ($item === 'Present' ? 'checked' : '') }}>
                                            {{ $item }}
                                        </label>
                                        @endforeach
                                    </div>
                                </td>

                                <td>
                                    <input type="text" name="entries[{{ $enrollment->student->id }}][remarks]"
                                        class="form-control form-control-sm"
                                        value="{{ optional($savedEntry)->remarks }}" placeholder="Optional">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('school.attendance.index') }}" class="btn btn-danger">
                        Back
                    </a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection