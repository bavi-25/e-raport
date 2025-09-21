@extends('layouts.admin')
@section('title', 'E-Raport | Edit Enrollment')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.enrollments.update', $enrollment->id) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Enrollment</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.enrollments.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Student --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id">Student <span class="text-danger">*</span></label>
                                <select id="student_id" name="student_id"
                                    class="form-control select2bs4 @error('student_id') is-invalid @enderror"
                                    data-placeholder="Select a student" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($students as $st) {{-- $st adalah Profile --}}
                                    <option value="{{ $st->id }}"
                                        {{ (string)old('student_id', $enrollment->student_id) === (string)$st->id ? 'selected' : '' }}>
                                        {{ $st->name }}{{ $st->nip_nis ? ' - '.$st->nip_nis : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Class --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_id">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id"
                                    class="form-control select2bs4 @error('class_id') is-invalid @enderror"
                                    data-placeholder="Select a class" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($class_rooms as $cr)
                                    <option value="{{ $cr->id }}"
                                        {{ (string)old('class_id', $enrollment->class_id) === (string)$cr->id ? 'selected' : '' }}>
                                        {{ $cr->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Academic Year --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                                <select id="academic_year_id" name="academic_year_id"
                                    class="form-control select2bs4 @error('academic_year_id') is-invalid @enderror"
                                    data-placeholder="Select academic year" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($academic_years as $ay)
                                    <option value="{{ $ay->id }}"
                                        {{ (string)old('academic_year_id', $enrollment->academic_year_id) === (string)$ay->id ? 'selected' : '' }}>
                                        {{ $ay->code }} ({{ $ay->term }})
                                        {{ $ay->status === 'Active' ? '- Active' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('academic_year_id') <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection