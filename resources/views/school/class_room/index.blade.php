@extends('layouts.admin')
@section('title', 'E-Raport | Class Rooms')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Class Room List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.class_rooms.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Class Room
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Academic Year</th>
                            <th>Teacher</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classs_rooms as $class_room)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $class_room->name }}</td>
                            <td>{{ $class_room->academicYear->code ?? '-' }}</td>
                            <td>{{ $class_room->homeroomTeacher->name ?? '-' }}</td>
                            <td class="text-center">
                               <div class="btn-group">
                                <button type="button" class="btn btn-primary">Action</button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item" href="{{ route('school.class_rooms.edit', $class_room->id) }}">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <form class="form-delete" action="{{ route('school.class_rooms.destroy', $class_room->id) }}" method="POST">
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
    <!-- /.col -->
</div>
@endsection