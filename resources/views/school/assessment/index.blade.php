@extends('layouts.admin')
@section('title', 'E-Raport | Assessments')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Assessment List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.assessments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Assessment
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th class="text-center" style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessments as $a)
                        @php
                        $cs = $a->classSubject;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($a->date)->translatedFormat('d F Y') }}</td>
                            <td>{{ $a->title }}</td>
                            <td>{{ optional(optional($cs)->class)->name ?? '-' }}</td>
                            <td>{{ optional(optional($cs)->subject)->name ?? '-' }}</td>
                            <td>{{ optional(optional($cs)->teacher)->name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm">Action</button>
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item"
                                            href="{{ route('school.assessments.show', $a->id) }}">View</a>
        
                                        <a class="dropdown-item"
                                            href="{{ route('school.assessments.edit', $a->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form class="form-delete"
                                            action="{{ route('school.assessments.destroy', $a->id) }}" method="POST">
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
                            <td colspan="6" class="text-center text-muted">No assessments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection