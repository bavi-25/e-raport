@extends('layouts.admin')
@section('title', 'E-Raport | Grade Level')
@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.grade_levels.store') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Grade Level</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.grade_levels.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level">Level</label>
                                <input type="number" class="form-control @error('level') is-invalid @enderror"
                                    id="level" name="level" value="{{ old('level') }}" min="1" required>
                                @error('level')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection