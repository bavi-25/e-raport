@extends('layouts.admin')
@section('title', 'E-Raport | Class')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Academic Year List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.academic_year.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Academic Year
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Term</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($academic_years as $academicYear)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $academicYear->code }}</td>
                            <td>{{ $academicYear->term }}</td>
                            <td>{{ $academicYear->start_date }}</td>
                            <td>{{ $academicYear->end_date }}</td>
                            <td>{{ $academicYear->status }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item" href="{{ route('school.academic_year.edit', $academicYear->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form class="form-delete" action="{{ route('school.academic_year.destroy', $academicYear->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                        </form>
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