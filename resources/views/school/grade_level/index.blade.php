@extends('layouts.admin')
@section('title', 'E-Raport | Grade Level')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grade Level List</h3>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grade_levels as $academicYear)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $academicYear->name }}</td>
                            <td>{{ $academicYear->level }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection