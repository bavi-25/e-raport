@extends('layouts.admin')
@section('title', 'E-Raport | Class')
@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('super_admin.users.store') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="{{ route('super_admin.users.index') }}" class="btn btn-sm btn-danger">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="ex: John Doe" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip_nis">NIP/NIS</label>
                                <input type="text" class="form-control @error('nip_nis') is-invalid @enderror"
                                    id="nip_nis" name="nip_nis" placeholder="ex: 12345678" value="{{ old('nip_nis') }}"
                                    required>
                                @error('nip_nis')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="ex: jhondoe@example.com" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" placeholder="ex: 08123456789" value="{{ old('phone') }}" required>
                                @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthdate">Birthdate</label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                    id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                                @error('birthdate')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <select id="religion" name="religion"
                                    class="form-control select2bs4 @error('religion') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('religion') ? '' : 'selected' }}>- Select Religion
                                        -</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion }}"
                                        {{ old('religion') == $religion ? 'selected' : '' }}>
                                        {{ $religion }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('religion')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select id="roles" name="roles[]"
                                    class="form-control select2bs4 @error('roles') is-invalid @enderror" multiple
                                    required>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender"
                                    class="form-control select2bs4 @error('gender') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>- Select Gender -
                                    </option>
                                    @foreach ($genders as $gender)
                                    <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tenant">Tenant</label>
                                <select id="tenant" name="tenant"
                                    class="form-control select2bs4 @error('tenant') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('tenant') ? '' : 'selected' }}>- Select Tenant -
                                    </option>
                                    @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}"
                                        {{ old('tenant') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} ({{ $tenant->npsn }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('tenant')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                                    name="address" rows="3" placeholder="ex: Jl. Merdeka No. 123, Jakarta"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection