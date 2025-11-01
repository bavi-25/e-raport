@extends('layouts.admin')
@section('title', 'E-Raport | Create Enrollment')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.enrollments.store') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Enrollment</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.enrollments.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id">Student <span class="text-danger">*</span></label>
                                <select id="student_id" name="student_id"
                                    class="form-control select2bs4 @error('student_id') is-invalid @enderror"
                                    data-placeholder="Select a student" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($students as $st) {{-- $st adalah Profile --}}
                                    <option value="{{ $st->id }}"
                                        {{ (string)old('student_id') === (string)$st->id ? 'selected' : '' }}>
                                        {{ $st->name }}{{ $st->nip_nis ? ' - '.$st->nip_nis : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_id">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id"
                                    class="form-control select2bs4 @error('class_id') is-invalid @enderror"
                                    data-placeholder="Select a class" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($class_rooms as $cr)
                                    <option value="{{ $cr->id }}"
                                        {{ (string)old('class_id') === (string)$cr->id ? 'selected' : '' }}>
                                        {{ $cr->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_year_id">Academic Year</label>
                                <select id="academic_year_id" name="academic_year_id"
                                    class="form-control select2bs4 @error('academic_year_id') is-invalid @enderror"
                                    data-placeholder="Auto: Active Year" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($academic_years as $ay)
                                    <option value="{{ $ay->id }}"
                                        {{ (string)old('academic_year_id', optional($active_year)->id) === (string)$ay->id ? 'selected' : '' }}>
                                        {{ $ay->code }} ({{ $ay->term }})
                                        {{ $ay->status === 'Active' ? '- Active' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('academic_year_id') <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Leave it blank to automatically use the
                                    <b>Active</b> Academic Year.</small>
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