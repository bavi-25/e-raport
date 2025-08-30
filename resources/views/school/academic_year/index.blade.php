@extends('layouts.admin')
@section('title', 'E-Raport | Class')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Class List</h3>
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