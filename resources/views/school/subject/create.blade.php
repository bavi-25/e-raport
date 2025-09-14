@extends('layouts.admin')
@section('title', 'E-Raport | Create Subject')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.subjects.store') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Subject</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.subjects.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Code <span class="text-danger">*</span></label>
                                <input type="text" id="code" name="code" value="{{ old('code') }}"
                                    class="form-control @error('code') is-invalid @enderror">
                                @error('code')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="group_name">Group <span class="text-danger">*</span></label>
                                <input type="text" id="group_name" name="group_name" value="{{ old('group_name') }}"
                                    class="form-control @error('group_name') is-invalid @enderror">
                                @error('group_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Contoh: Wajib, Peminatan, Muatan Lokal, dll.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phase">Phase <span class="text-danger">*</span></label>
                                <input type="text" id="phase" name="phase" value="{{ old('phase') }}"
                                    class="form-control @error('phase') is-invalid @enderror">
                                @error('phase')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Contoh: A, B, C, D, E, F.</small>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection