@extends('layouts.admin')
@section('title', 'E-Raport | Students')

@section('content')
<form method="POST" action="{{ route('school.students.store') }}">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Create Student</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.students.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Row 1: Name, Email --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Password, Confirm Password --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: NIS (opsional), Birth Date (opsional) --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip_nis">NIS</label>
                                <input type="text" id="nip_nis" name="nip_nis" value="{{ old('nip_nis') }}"
                                    class="form-control @error('nip_nis') is-invalid @enderror">
                                @error('nip_nis')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birth_date">Birth Date</label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}"
                                    class="form-control @error('birth_date') is-invalid @enderror">
                                @error('birth_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Row 4: Religion (opsional), Gender (opsional) --}}
                    @php
                    $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
                    $selectedReligion = old('religion');
                    $genders = ['Laki-laki', 'Perempuan'];
                    $selectedGender = old('gender');
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <select id="religion" name="religion"
                                    class="form-control select2bs4 @error('religion') is-invalid @enderror">
                                    <option disabled value="" {{ $selectedReligion ? '' : 'selected' }}>- Select
                                        Religion -
                                    </option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion }}"
                                        {{ $selectedReligion === $religion ? 'selected' : '' }}>
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
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender"
                                    class="form-control select2bs4 @error('gender') is-invalid @enderror">
                                    <option disabled value="" {{ $selectedGender ? '' : 'selected' }}>- Select Gender -
                                    </option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender }}" {{ $selectedGender === $gender ? 'selected' : '' }}>
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
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="08xxxxxxxxxx">
                                @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>
@endsection