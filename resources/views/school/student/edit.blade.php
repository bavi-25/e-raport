@extends('layouts.admin')
@section('title', 'E-Raport | Students')

@section('content')
<form method="POST" action="{{ route('school.students.update', $student->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Student</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.students.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip_nis">NIS <span class="text-danger">*</span></label>
                                <input type="text" id="nip_nis" name="nip_nis"
                                    value="{{ old('nip_nis', optional($student->profile)->nip_nis) }}"
                                    class="form-control @error('nip_nis') is-invalid @enderror" required>
                                @error('nip_nis')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Birth Date <span class="text-danger">*</span></label>
                                <input type="date" id="birth_date" name="birth_date"
                                    value="{{ old('birth_date', $student->profile->birth_date) }}"
                                    class="form-control @error('birth_date') is-invalid @enderror" required>
                                @error('birth_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="religion">Religion <span class="text-danger">*</span></label>
                                @php
                                $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
                                $selectedReligion = old('religion', optional($student->profile)->religion ?? 'Islam');
                                @endphp
                                <select id="religion" name="religion"
                                    class="form-control select2bs4 @error('religion') is-invalid @enderror" required>
                                    <option value="" disabled>- Select Religion -</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion }}"
                                        {{ $selectedReligion == $religion ? 'selected' : '' }}>
                                        {{ $religion }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('religion')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                @php
                                $genders = ['Laki-laki', 'Perempuan'];
                                $selectedGender = old('gender', optional($student->profile)->gender ?? 'Laki-laki');
                                @endphp
                                <select id="gender" name="gender"
                                    class="form-control select2bs4 @error('gender') is-invalid @enderror" required>
                                    <option value="" disabled>- Select Gender -</option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender }}" {{ $selectedGender == $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone"
                                    value="{{ old('phone', optional($student->profile)->phone ?? '081500000001') }}"
                                    class="form-control @error('phone') is-invalid @enderror" required>
                                @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address <span class="text-danger">*</span></label>
                                <textarea id="address" name="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    required>{{ old('address', optional($student->profile)->address ?? 'Domisili SMP Negeri 00 Dev') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
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
        </div>
    </div>
</form>
@endsection