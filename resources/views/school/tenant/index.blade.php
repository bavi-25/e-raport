@extends('layouts.admin')
@section('title', 'E-Raport | School')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-school mr-2"></i> School Information
                </h3>
                <div class="card-tools">
                    <a href="" class="btn btn-sm btn-primary" id="editSchoolBtn">
                        <i class="fas fa-edit"></i> Edit Information
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Logo Sekolah --}}
                    {{-- <div class="col-md-3 text-center">
                        <div class="school-logo-wrapper mb-3">
                            <img src="{{ $tenant?->logo_path ? asset($tenant->logo_path) : 'https://via.placeholder.com/200x200/3498db/ffffff?text=LOGO' }}"
                                alt="School Logo" class="img-fluid img-thumbnail" style="max-width:200px;">
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary btn-block">
                            <i class="fas fa-camera"></i> Change Logo
                        </a>
                    </div> --}}

                    {{-- Informasi Utama --}}
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-muted">
                                            <i class="fas fa-building mr-1"></i> School Name
                                        </span>
                                        <span class="info-box-number text-dark">
                                            {{ $tenant->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-muted">
                                            <i class="fas fa-id-card mr-1"></i> NPSN
                                        </span>
                                        <span class="info-box-number text-dark">
                                            {{ $tenant->npsn ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- row --}}
                    </div>
                </div> {{-- row --}}

                <hr class="my-4">

                {{-- Alamat & Kontak --}}
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">
                            <i class="fas fa-map-marker-alt text-primary"></i> Address Information
                        </h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="140" class="text-muted">Street</td>
                                <td>: {{ $tenant->street ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Village/Kelurahan</td>
                                <td>: {{ $tenant->village ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">District</td>
                                <td>: {{ $tenant->district ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">City</td>
                                <td>: {{ $tenant->city ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Province</td>
                                <td>: {{ $tenant->province ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Postal Code</td>
                                <td>: {{ $tenant->postal_code ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">
                            <i class="fas fa-phone text-success"></i> Contact Information
                        </h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="140" class="text-muted">Phone</td>
                                <td>: {{ $tenant->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Fax</td>
                                <td>: {{ $tenant->fax ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>:
                                    @if(!empty($tenant?->email))
                                    <a href="mailto:{{ $tenant->email }}">{{ $tenant->email }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Website</td>
                                <td>:
                                    @if(!empty($tenant?->website))
                                    <a href="{{ Str::startsWith($tenant->website, ['http://','https://']) ? $tenant->website : ('https://'.$tenant->website) }}"
                                        target="_blank">
                                        {{ $tenant->website }}
                                    </a>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <h5 class="mb-3 mt-4">
                            <i class="fas fa-user-tie text-info"></i> Principal
                        </h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="140" class="text-muted">Name</td>
                                <td>:
                                    {{ $principal?->profile?->name
                                        ?? $principal?->name
                                        ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIP</td>
                                <td>:
                                    {{ $principal?->profile?->nip_nis ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> {{-- card-body --}}
        </div>
    </div>
</div>

@push('styles')
<style>
    .info-box {
        min-height: 70px;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .info-box-text {
        display: block;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-box-number {
        display: block;
        font-weight: bold;
        font-size: 18px;
    }

    .school-logo-wrapper {
        padding: 10px;
    }

    .table-borderless td {
        padding: 5px 8px;
    }

    h5 {
        font-weight: 600;
        border-bottom: 2px solid #f4f4f4;
        padding-bottom: 10px;
    }
</style>
@endpush
@endsection