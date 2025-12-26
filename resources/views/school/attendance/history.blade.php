@extends('layouts.admin')

@section('title', 'E-Report | Attendance')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance History</h3>
                <div class="card-tools">
                    <a href="{{ route('school.attendance.index') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Present</th>
                            <th>Sick</th>
                            <th>Excused</th>
                            <th>Absent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                            <td>{{ $item->present_count ?? 0 }}</td>
                            <td>{{ $item->sick_count ?? 0 }}</td>
                            <td>{{ $item->excused_count ?? 0 }}</td>
                            <td>{{ $item->absent_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('school.attendance.show', $item->id) }}"
                                    class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No attendance data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection