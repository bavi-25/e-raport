@extends('layouts.admin')
@section('title', 'E-Raport | Grade Entries')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('school.grade_entries.index') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select name="academic_year_id" class="form-control select2bs4"
                                    onchange="this.form.submit()">
                                    <option value="">- Pilih -</option>
                                    @foreach ($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $academic_year_id == $ay->id ? 'selected' : '' }}>
                                        {{ $ay->code }} {{ ($ay->status == 'Active') ? ' -- Active --' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_id">Kelas</label>
                                <select name="class_id" class="form-control select2bs4" onchange="this.form.submit()"
                                    {{ empty($academic_year_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih -</option>
                                    @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ $class_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mapel</label>
                                <select name="class_subject_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($class_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih -</option>
                                    @foreach ($classSubjects as $cs)
                                    <option value="{{ $cs->id }}" {{ $class_subject_id == $cs->id ? 'selected' : '' }}>
                                        {{ $cs->subject->code ?? 'SUB' }} — {{ $cs->subject->name ?? 'Subject' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Siswa</label>
                                <select name="enrollment_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($class_subject_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih -</option>
                                    @foreach ($enrollments as $e)
                                    <option value="{{ $e->id }}" {{ $enrollment_id == $e->id ? 'selected' : '' }}>
                                        {{ $e->student->name ?? 'Student' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assessment</label>
                                <select name="assessment_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($enrollment_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih / Buat Baru -</option>
                                    @foreach ($assessments as $a)
                                    <option value="{{ $a->id }}" {{ $assessment_id == $a->id ? 'selected' : '' }}>
                                        {{ $a->date }} — {{ $a->title }}
                                        ({{ $a->assessmentComponent->name ?? 'Comp' }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if($enrollment_id && $class_subject_id)
                <form method="POST" action="{{ route('school.grade_entries.store') }}">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $academic_year_id }}">
                    <input type="hidden" name="class_id" value="{{ $class_id }}">
                    <input type="hidden" name="class_subject_id" value="{{ $class_subject_id }}">
                    <input type="hidden" name="enrollment_id" value="{{ $enrollment_id }}">
                    @if($assessment)
                    <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
                    @endif

                    @if(!$assessment)
                    {{-- Buat assessment baru cepat --}}
                    <div class="alert alert-info">
                        Belum memilih assessment. Isi data berikut untuk membuat assessment baru (khusus siswa ini).
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" placeholder="Mis. UTS Matematika"
                                required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tanggal</label>
                            <input type="date" name="date" class="form-control" value="{{ now()->toDateString() }}"
                                required>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Komponen Penilaian</label>
                            <select name="assessment_component_id" class="form-control" required>
                                @foreach(\App\Models\AssessmentComponent::where('tenant_id',
                                auth()->user()->tenant_id)->orderBy('name')->get(['id','name','weight']) as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }} ({{ $comp->weight }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-secondary">
                        <strong>Catatan:</strong> Items (indikator soal/KD) untuk assessment baru ini silakan buat di
                        menu <em>Assessments → Items</em> setelah tersimpan,
                        atau isi nilai nanti setelah items dibuat.
                    </div>
                    @endif

                    @if($assessment && $items->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:60%">Kompetensi / Item</th>
                                    <th style="width:15%">Skor Maks</th>
                                    <th style="width:25%">Nilai Siswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $it)
                                @php
                                $val = $gradeByItem[$it->id] ?? '';
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $it->competency_code }}</strong>
                                    </td>
                                    <td>{{ number_format((float)$it->max_score, 2) }}</td>
                                    <td>
                                        <input type="number" step="0.01" min="0" max="{{ (float)$it->max_score }}"
                                            name="scores[{{ $it->id }}]" class="form-control" value="{{ $val }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif($assessment && !$items->count())
                    <div class="alert alert-warning">
                        Assessment terpilih belum memiliki item. Buat item terlebih dahulu agar bisa mengisi nilai.
                    </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                        @if($assessment)
                        <div>
                            <button type="submit" name="next_student" value="1" class="btn btn-outline-secondary">
                                Simpan & Siswa Berikutnya
                            </button>
                        </div>
                        @endif
                    </div>
                </form>
                @else
                <div class="alert alert-info">
                    Silakan pilih Tahun Ajaran → Kelas → Mapel → Siswa untuk mulai mengisi nilai.
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection