@extends('layouts.admin')
@section('title', 'E-Raport | Academic Year')
@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('school.academic_year.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="{{ route('school.academic_year.index') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date-input">Start Date</label>
                                <input type="date" name="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror" id="start_date-input"
                                    value="{{ old('start_date') }}" required>
                                @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date-input">End Date</label>
                                <input type="date" name="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror" id="end_date-input"
                                    value="{{ old('end_date') }}" required>
                                @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- term ganjil genap --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code-input">Term</label>
                                <select name="term" id="term-input"
                                    class="form-control select2bs4 @error('term') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option selected disabled>-- Select Term --</option>
                                    <option value="Ganjil" {{ old('term') == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                    </option>
                                    <option value="Genap" {{ old('term') == 'Genap' ? 'selected' : '' }}>Genap
                                    </option>
                                </select>
                                @error('term')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- status --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status-input">Status</label>
                                <select name="status" id="status-input"
                                    class="form-control select2bs4 @error('status') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option selected disabled>-- Select Status --</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                @error('status')
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
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
    <!-- /.col -->
</div>
@endsection