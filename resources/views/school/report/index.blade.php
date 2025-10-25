@extends('layouts.admin')
@section('title', 'E-Raport | Generate Report')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
    <div class="col-12">

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('school.report.index') }}" id="filter-form">
                    <div class="row">
                        {{-- Tahun Ajaran --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select name="academic_year_id" class="form-control select2bs4"
                                    onchange="this.form.submit()">
                                    <option value="">- Pilih -</option>
                                    @foreach ($academicYears as $ay)
                                    <option value="{{ $ay->id }}"
                                        {{ (int)$academic_year_id === (int)$ay->id ? 'selected' : '' }}>
                                        {{ $ay->code }} {{ ($ay->status ?? '') === 'Active' ? ' — Active —' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select name="class_id" class="form-control select2bs4" onchange="this.form.submit()"
                                    {{ empty($academic_year_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih -</option>
                                    @foreach ($classes as $c)
                                    <option value="{{ $c->id }}" {{ (int)$class_id === (int)$c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Mapel --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mapel</label>
                                <select name="class_subject_id" class="form-control select2bs4"
                                    onchange="this.form.submit()" {{ empty($class_id) ? 'disabled' : '' }}>
                                    <option value="">- Pilih -</option>
                                    @foreach ($classSubjects as $cs)
                                    <option value="{{ $cs['id'] }}"
                                        {{ (int)$class_subject_id === (int)$cs['id'] ? 'selected' : '' }}>
                                        {{ $cs['subject_code'] }} — {{ $cs['subject_name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- AKSI: HITUNG FINAL GRADE (AJAX JSON) --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Generate Final Grade</h5>
                        <small class="text-muted">Pilih Tahun Ajaran, Kelas, dan Mapel terlebih dahulu.</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span id="calc-status" class="mr-2 text-muted" style="display:none;">
                            <i class="fas fa-spinner fa-spin"></i> Menghitung...
                        </span>
                        <button id="btn-calc" class="btn btn-primary"
                            {{ (empty($academic_year_id) || empty($class_id) || empty($class_subject_id)) ? 'disabled' : '' }}>
                            <i class="fas fa-calculator"></i> Hitung / Refresh Final Grade
                        </button>
                    </div>
                </div>

                {{-- Hidden payload untuk AJAX --}}
                <input type="hidden" id="tenant_id" value="{{ $tenantId }}">
                <input type="hidden" id="academic_year_id" value="{{ $academic_year_id }}">
                <input type="hidden" id="class_id" value="{{ $class_id }}">
                <input type="hidden" id="class_subject_id" value="{{ $class_subject_id }}">

                {{-- Alert placeholder --}}
                <div id="calc-alert" class="mt-3" style="display:none;"></div>
            </div>
        </div>

        {{-- TABEL HASIL (final_grades yang sudah ada) --}}
        <div class="card">
            <div class="card-body">
                @if(empty($academic_year_id) || empty($class_id) || empty($class_subject_id))
                <div class="alert alert-info mb-0">
                    Silakan pilih <strong>Tahun Ajaran</strong>, <strong>Kelas</strong>, dan <strong>Mapel</strong>
                    terlebih dahulu.
                </div>
                @else
                @if($finalRows->isEmpty())
                <div class="alert alert-warning mb-0">
                    Belum ada data final grade untuk kombinasi ini. Klik <em>Hitung / Refresh Final Grade</em>.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 80%">Nama Siswa</th>
                                <th style="width: 20%" class="text-center">Final Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finalRows as $row)
                            @php
                            $score = (float) $row->final_score;
                            @endphp
                            <tr>
                                <td>{{ $row->student_name }}</td>
                                <td class="text-center">{{ number_format($score, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary disabled" aria-disabled="true" title="Coming soon">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="#" class="btn btn-outline-secondary disabled" aria-disabled="true" title="Coming soon">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
                @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
    const btn = document.getElementById('btn-calc');
    if (!btn) return;

    const alertBox   = document.getElementById('calc-alert');
    const statusSpan = document.getElementById('calc-status');

    function showAlert(type, html) {
      alertBox.style.display = 'block';
      alertBox.className = 'alert alert-' + type;
      alertBox.innerHTML = html;
    }

    function hideAlert() {
      alertBox.style.display = 'none';
      alertBox.className = '';
      alertBox.innerHTML = '';
    }

    btn.addEventListener('click', async function (e) {
      e.preventDefault();
      hideAlert();

      const tenant_id        = document.getElementById('tenant_id').value;
      const academic_year_id = document.getElementById('academic_year_id').value;
      const class_id         = document.getElementById('class_id').value;
      const class_subject_id = document.getElementById('class_subject_id').value;

      if (!tenant_id || !academic_year_id || !class_id || !class_subject_id) {
        showAlert('warning', 'Lengkapi filter Tahun Ajaran, Kelas, dan Mapel terlebih dahulu.');
        return;
      }
      
      btn.disabled = true;
      statusSpan.style.display = 'inline';

      try {
        const res = await fetch("{{ route('school.report.calculateFinalGrades') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            tenant_id: Number(tenant_id),
            academic_year_id: Number(academic_year_id),
            class_id: Number(class_id),
            class_subject_id: Number(class_subject_id)
          })
        });

        const json = await res.json();

        if (!res.ok) {
          const msg = (json && json.message) ? json.message : 'Gagal menghitung.';
          showAlert('danger', msg);
        } else {

          showAlert('success', 'Berhasil dihitung. Memuat ulang…');
          setTimeout(function () {

            const params = new URLSearchParams({
              academic_year_id: academic_year_id,
              class_id: class_id,
              class_subject_id: class_subject_id
            });
            window.location.href = "{{ route('school.report.index') }}?" + params.toString();
          }, 600);
        }

      } catch (err) {
        showAlert('danger', 'Terjadi kesalahan jaringan / server.');
        console.error(err);
      } finally {
        btn.disabled = false;
        statusSpan.style.display = 'none';
      }
    });
  })();
</script>
@endpush