@extends('layouts.admin')

@section('title', 'E-Report | Attendance')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Taught Subjects</h3>
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Homeroom Teacher</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class_subjects as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->subject->name }}
                            </td>
                            <td>
                                {{ $item->class->gradeLevel->name }} {{ $item->class->name }}
                                @if($item->class->section)
                                - {{ $item->class->section }}
                                @endif
                            </td>
                            <td>{{ $item->class->homeroomTeacher?->name ?? '-' }}</td>

                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                            href="{{ route('school.attendance.start', $item->id) }}">
                                            <i class="fas fa-play-circle mr-1"></i> Start Teaching (Today's Attendance)
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('school.attendance.history', $item->id) }}">
                                            <i class="fas fa-history mr-1"></i> Attendance History
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection