@extends('layouts.admin')
@section('title', 'E-Raport | Assessment Components')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assessment Component List</h3>
                <div class="card-tools">
                    <a href="{{ route('school.assessment_components.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Component
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Name</th>
                            <th style="width:140px">Weight</th>
                            <th class="text-center" style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessment_components as $component)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $component->name }}</td>
                            <td>{{ number_format((float)$component->weight, 2) }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Action</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a class="dropdown-item"
                                            href="{{ route('school.assessment_components.edit', $component->id) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <form class="form-delete"
                                            action="{{ route('school.assessment_components.destroy', $component->id) }}"
                                            method="POST">
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
                            <td colspan="4" class="text-center text-muted">No components found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection