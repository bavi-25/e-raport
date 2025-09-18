@extends('layouts.admin')
@section('title', 'E-Raport | Enrollments')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Enrollment List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.enrollments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Enrollment
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('school.enrollments.index') }}" class="mb-3">
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="class_id">Class</label>
                            <select id="class_id" name="class_id" class="form-control select2bs4"
                                data-placeholder="All classes" style="width:100%;">
                                <option value="">All</option>
                                @foreach($class_rooms as $cr)
                                <option value="{{ $cr->id }}"
                                    {{ (string)$selected_class === (string)$cr->id ? 'selected' : '' }}>{{ $cr->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="academic_year_id">Academic Year</label>
                            <select id="academic_year_id" name="academic_year_id" class="form-control select2bs4"
                                data-placeholder="All years" style="width:100%;">
                                <option value="">All</option>
                                @foreach($academic_years as $ay)
                                <option value="{{ $ay->id }}"
                                    {{ (string)$selected_year === (string)$ay->id ? 'selected' : '' }}>
                                    {{ $ay->code }} ({{ $ay->term }}) {{ $ay->status === 'Active' ? ' - Active' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div>
                                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i>
                                    Filter</button>
                                <a href="{{ route('school.enrollments.index') }}" class="btn btn-secondary"><i
                                        class="fas fa-redo"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Student</th>
                            <th style="width:140px">NIS/NIP</th>
                            <th>Class</th>
                            <th style="width:200px">Academic Year</th>
                            <th class="text-center" style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $en)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $en->student->name ?? '-' }}</td>
                            <td>{{ $en->student->nip_nis ?? '-' }}</td>
                            <td>{{ $en->class->name ?? '-' }}</td>
                            <td>
                                @if($en->academicYear)
                                {{ $en->academicYear->code }} ({{ $en->academicYear->term }})
                                @if($en->academicYear->status === 'Active') <span
                                    class="badge badge-success ml-1">Active</span> @endif
                                @else
                                -
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item"
                                            href="{{ route('school.enrollments.edit', $en->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form class="form-delete"
                                            action="{{ route('school.enrollments.destroy', $en->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No enrollments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection