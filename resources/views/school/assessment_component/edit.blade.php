@extends('layouts.admin')
@section('title', 'E-Raport | Edit Assessment Component')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.assessment_components.update', $component->id) }}">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Assessment Component</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.assessment_components.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', $component->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Contoh: Tugas, UTS, UAS.</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">Weight <span class="text-danger">*</span></label>
                                <input type="number" id="weight" name="weight"
                                    value="{{ old('weight', number_format((float)$component->weight, 2, '.', '')) }}"
                                    class="form-control @error('weight') is-invalid @enderror" step="0.01" min="0"
                                    max="100" required>
                                @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Gunakan nilai desimal (mis. 20, 30.5). Satuan bebas
                                    (umumnya persen).</small>
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