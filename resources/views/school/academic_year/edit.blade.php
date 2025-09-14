@extends('layouts.admin')
@section('title', 'E-Raport | Edit Academic Year')
@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ route('school.academic_year.update', $academicYear->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                        {{-- Start & End Date --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date-input">Start Date</label>
                                <input type="date" name="start_date" id="start_date-input"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date', optional($academicYear->start_date)->format('Y-m-d')) }}"
                                    required>
                                @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date-input">End Date</label>
                                <input type="date" name="end_date" id="end_date-input"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', optional($academicYear->end_date)->format('Y-m-d')) }}"
                                    required>
                                @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Term (Ganjil/Genap) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="term-input">Term</label>
                                <select name="term" id="term-input"
                                    class="form-control select2bs4 @error('term') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option disabled>-- Select Term --</option>
                                    @php $termOld = old('term', $academicYear->term); @endphp
                                    <option value="Ganjil" {{ $termOld === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ $termOld === 'Genap'  ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('term')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status-input">Status</label>
                                <select name="status" id="status-input"
                                    class="form-control select2bs4 @error('status') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option disabled>-- Select Status --</option>
                                    @php $statusOld = old('status', $academicYear->status); @endphp
                                    <option value="Active" {{ $statusOld === 'Active'   ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ $statusOld === 'Inactive' ? 'selected' : '' }}>Inactive
                                    </option>
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