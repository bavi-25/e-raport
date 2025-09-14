@extends('layouts.admin')
@section('title', 'E-Raport | Subjects')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subject List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.subjects.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Subject
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Group</th>
                            <th class="text-center" style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->code }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->group_name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item"
                                            href="{{ route('school.subjects.edit', $subject->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form class="form-delete"
                                            action="{{ route('school.subjects.destroy', $subject->id) }}" method="POST">
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
                            <td colspan="5" class="text-center text-muted">
                                No subjects found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection