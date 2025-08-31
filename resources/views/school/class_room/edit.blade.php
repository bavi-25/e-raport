@extends('layouts.admin')
@section('title', 'E-Raport | Edit Class Room')

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('school.class_rooms.update', $class_room->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="{{ route('school.class_rooms.index') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name-input">Class Name</label>
                                <input type="text" name="name" id="name-input"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $class_room->name) }}"
                                    placeholder="Ex: 1 Sudirman, 7 A, X RPL" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Section --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="section-input">Section</label>
                                <input type="text" name="section" id="section-input"
                                    class="form-control @error('section') is-invalid @enderror"
                                    value="{{ old('section', $class_room->section) }}" placeholder="Ex: A, B, C">
                                @error('section')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Label --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label-input">Label</label>
                                <input type="text" name="label" id="label-input"
                                    class="form-control @error('label') is-invalid @enderror"
                                    value="{{ old('label', $class_room->label) }}" placeholder="Ex: 1, 2, 3, ... 12">
                                @error('label')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Grade Level --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grade-level-select">Level</label>
                                <select name="grade_level_id" id="grade-level-select"
                                    class="form-control select2bs4 @error('grade_level_id') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option disabled>-- Select Level --</option>
                                    @foreach ($grade_levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('grade_level_id', $class_room->grade_level_id) == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('grade_level_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Homeroom Teacher --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="teacher-select">Wali Kelas</label>
                                <select name="teacher_id" id="teacher-select"
                                    class="form-control select2bs4 @error('teacher_id') is-invalid @enderror"
                                    style="width: 100%;">
                                    <option disabled>-- Select Teacher --</option>
                                    @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id', $class_room->teacher_id ?? $class_room->homeroom_teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->profile->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection