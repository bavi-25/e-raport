@extends('layouts.admin')
@section('title', 'E-Raport | Edit Assignment')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.class_subjects.update', $assignment->id) }}">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assign Teacher to Subject</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.class_subjects.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Class --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="class_id">Class <span class="text-danger">*</span></label>
                                <select id="class_id" name="class_id"
                                    class="form-control select2bs4 @error('class_id') is-invalid @enderror" required
                                    style="width:100%" data-placeholder="Select class">
                                    <option value=""></option>
                                    @foreach($classes as $c)
                                    <option value="{{ $c->id }}"
                                        {{ (string)old('class_id', $assignment->class_id)===(string)$c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Subject --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subject_id">Subject <span class="text-danger">*</span></label>
                                <select id="subject_id" name="subject_id"
                                    class="form-control select2bs4 @error('subject_id') is-invalid @enderror" required
                                    style="width:100%" data-placeholder="Select subject">
                                    <option value=""></option>
                                    @foreach($subjects as $s)
                                    <option value="{{ $s->id }}"
                                        {{ (string)old('subject_id', $assignment->subject_id)===(string)$s->id ? 'selected' : '' }}>
                                        {{ $s->code }} — {{ $s->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Teacher (Profile) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="teacher_id">Teacher <span class="text-danger">*</span></label>
                                <select id="teacher_id" name="teacher_id"
                                    class="form-control select2bs4 @error('teacher_id') is-invalid @enderror" required
                                    style="width:100%" data-placeholder="Select teacher">
                                    <option value=""></option>
                                    @foreach($teachers as $t)
                                    <option value="{{ $t->id }}"
                                        {{ (string)old('teacher_id', $assignment->teacher_id)===(string)$t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('teacher_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
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