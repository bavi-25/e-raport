@extends('layouts.admin')
@section('title', 'E-Raport | Edit Assessment')

@section('content')
<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('school.assessments.update', $assessment->id) }}">
            @csrf
            @method('PUT')

            {{-- CARD: Header --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Assessment</h3>
                    <div class="card-tools">
                        <a href="{{ route('school.assessments.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Row 1: Title + Date --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $assessment->title) }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <input type="date" id="date" name="date"
                                    value="{{ old('date', optional($assessment->date)->format('Y-m-d')) }}"
                                    class="form-control @error('date') is-invalid @enderror" required>
                                @error('date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Class Subject + Component --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class_subject_id">Class Subject <span class="text-danger">*</span></label>
                                <select id="class_subject_id" name="class_subject_id"
                                    class="form-control select2bs4 @error('class_subject_id') is-invalid @enderror"
                                    data-placeholder="Select class - subject - teacher" style="width:100%;" required>
                                    <option value=""></option>
                                    @foreach($classSubjects as $cs)
                                    @php
                                    $label = trim(
                                    ($cs->class->name ?? '-') . ' | ' .
                                    (optional($cs->subject)->code ? $cs->subject->code.' - ' : '') .
                                    (optional($cs->subject)->name ?? '-') . ' | ' .
                                    (optional($cs->teacher)->name ?? '-')
                                    );
                                    $selected = old('class_subject_id', $assessment->class_subject_id) == $cs->id ?
                                    'selected' : '';
                                    @endphp
                                    <option value="{{ $cs->id }}" {{ $selected }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_subject_id') <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="assessment_component_id">Component <span
                                        class="text-danger">*</span></label>
                                <select id="assessment_component_id" name="assessment_component_id"
                                    class="form-control select2bs4 @error('assessment_component_id') is-invalid @enderror"
                                    data-placeholder="Select component" style="width:100%;" required>
                                    <option value=""></option>
                                    @foreach($components as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('assessment_component_id', $assessment->assessment_component_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }} ({{ number_format((float)$c->weight, 2) }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('assessment_component_id') <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD: Assessment Items --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Assessment Items</h3>
                    <div class="card-tools">
                        <button type="button" id="btnAddItem" class="btn btn-success btn-sm mr-1">
                            <i class="fas fa-plus-circle"></i> Add Item
                        </button>
                        <button type="button" id="btnClearItems" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-eraser"></i> Clear
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0" id="itemsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 56px;">#</th>
                                    <th>Competency Code <span class="text-danger">*</span></th>
                                    <th style="width: 180px;">Max Score <span class="text-danger">*</span></th>
                                    <th style="width: 56px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                @php

                                $oldItems = old('items');

                                if (is_array($oldItems)) {
                                $rows = collect(array_values($oldItems));
                                }
                                else {
                                $rows = $assessment->items->map(function ($it) {
                                return [
                                'id' => $it->id,
                                'competency_code' => $it->competency_code,
                                'max_score' => $it->max_score,
                                ];
                                })->values();
                                }
                                @endphp

                                @forelse($rows as $idx => $row)
                                <tr>
                                    <td class="align-middle index-col"></td>

                                    <td>
                                        @if(!empty($row['id']))
                                        <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $row['id'] }}">
                                        @endif
                                        <input type="text" name="items[{{ $idx }}][competency_code]"
                                            value="{{ $row['competency_code'] ?? '' }}"
                                            class="form-control form-control-sm competency-input"
                                            placeholder="e.g. KD3.1 / C1 / PPKN-3.2" required>
                                    </td>

                                    <td>
                                        <input type="number" name="items[{{ $idx }}][max_score]"
                                            value="{{ $row['max_score'] ?? '' }}"
                                            class="form-control form-control-sm score-input" placeholder="e.g. 100"
                                            min="0" step="0.01" max="100" required>
                                    </td>

                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-outline-danger btn-xs btnRemoveRow"
                                            title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <input type="hidden" class="delete-flag" name="items[{{ $idx }}][_delete]"
                                            value="0">
                                    </td>
                                </tr>
                                @empty
                                {{-- Jika tidak ada item sama sekali, beri satu baris kosong --}}
                                <tr>
                                    <td class="align-middle index-col"></td>
                                    <td>
                                        <input type="text" name="items[0][competency_code]"
                                            class="form-control form-control-sm competency-input"
                                            placeholder="e.g. KD3.1 / C1 / PPKN-3.2" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][max_score]"
                                            class="form-control form-control-sm score-input" placeholder="e.g. 100"
                                            min="0" step="0.01" max="100" required>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-outline-danger btn-xs btnRemoveRow"
                                            title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <input type="hidden" class="delete-flag" name="items[0][_delete]" value="0">
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bg-light">
                                    <th colspan="2" class="text-right">Total Max Score:</th>
                                    <th id="totalScoreCell">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="p-3 text-muted small">
                        <i class="fas fa-info-circle"></i>
                        <span>Gunakan <b>Competency Code</b> untuk mengacu ke KD/TP/indikator (contoh: KD3.1, KD4.2).
                            Nilai <b>Max Score</b> maksimal 100.</span>
                    </div>
                </div>

                <div class="card-footer">
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    #itemsTable tbody tr td {
        vertical-align: middle;
    }

    #itemsTable .index-col {
        font-weight: 600;
        text-align: center;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const itemsBody = document.getElementById('itemsBody');
    const totalCell = document.getElementById('totalScoreCell');
    const btnAdd    = document.getElementById('btnAddItem');
    const btnClear  = document.getElementById('btnClearItems');

    function getNextIndex() {
        const inputs = itemsBody.querySelectorAll('input[name^="items["][name$="[competency_code]"]');
        let maxIdx = -1;
        inputs.forEach(inp => {
            const match = inp.name.match(/^items\[(\d+)\]\[competency_code\]$/);
            if (match) maxIdx = Math.max(maxIdx, parseInt(match[1], 10));
        });
        return maxIdx + 1;
    }

    function renumberRows() {
        [...itemsBody.querySelectorAll('tr')].forEach((tr, i) => {
            const indexCell = tr.querySelector('.index-col');
            if (indexCell) indexCell.textContent = i + 1;
        });
    }

    function recalcTotal() {
        let sum = 0;
        itemsBody.querySelectorAll('.score-input').forEach(inp => {
            let v = parseFloat(inp.value);
            if (!isNaN(v)) sum += v;
        });
        totalCell.textContent = Number.isInteger(sum) ? sum.toFixed(0) : sum.toFixed(2);
    }

    function createRow(idx, data = { id: '', competency_code: '', max_score: '' }) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="align-middle index-col"></td>
            <td>
                ${data.id ? `<input type="hidden" name="items[${idx}][id]" value="${data.id}">` : ''}
                <input type="text"
                       name="items[${idx}][competency_code]"
                       class="form-control form-control-sm competency-input"
                       placeholder="e.g. KD3.1 / C1 / PPKN-3.2"
                       value="${data.competency_code ?? ''}"
                       required>
            </td>
            <td>
                <input type="number"
                       name="items[${idx}][max_score]"
                       class="form-control form-control-sm score-input"
                       placeholder="e.g. 100"
                       min="0" step="0.01" max="100"
                       value="${data.max_score ?? ''}"
                       required>
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-outline-danger btn-xs btnRemoveRow" title="Remove">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <input type="hidden" class="delete-flag" name="items[${idx}][_delete]" value="0">
            </td>
        `;
        return tr;
    }

    function addItemRow(prefill = {}) {
        const idx = getNextIndex();
        const tr = createRow(idx, prefill);
        itemsBody.appendChild(tr);
        renumberRows();
        recalcTotal();
    }

    // Init
    renumberRows();
    recalcTotal();

    // Delegasi: remove row
    itemsBody.addEventListener('click', function (e) {
        if (e.target.closest('.btnRemoveRow')) {
            const tr = e.target.closest('tr');

            // Jika ada hidden _delete, set 1 (untuk diproses server), lalu sembunyikan baris
            const del = tr.querySelector('.delete-flag');
            if (del) { del.value = '1'; }

            tr.remove(); // hapus dari DOM; kalau ingin "soft-hide", bisa pakai class d-none
            renumberRows();
            recalcTotal();
        }
    });

    // Hitung total realtime
    itemsBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('score-input')) recalcTotal();
    });

    // Tambah baris
    btnAdd.addEventListener('click', function () {
        addItemRow();
    });

    // Clear semua baris -> sisakan satu baris kosong
    btnClear.addEventListener('click', function () {
        itemsBody.innerHTML = '';
        addItemRow();
    });

    // Validasi sederhana sebelum submit
    document.querySelector('form').addEventListener('submit', function (e) {
        const rows = itemsBody.querySelectorAll('tr');
        if (!rows.length) {
            e.preventDefault();
            alert('Tambahkan minimal 1 Assessment Item.');
            return;
        }

        let ok = true;
        rows.forEach(tr => {
            tr.querySelectorAll('input[required]').forEach(inp => {
                if (!inp.value || !String(inp.value).trim()) ok = false;
                if (inp.name.endsWith('[max_score]') && parseFloat(inp.value) > 100) ok = false;
            });
        });
        if (!ok) {
            e.preventDefault();
            alert('Lengkapi semua kolom pada Assessment Items dan pastikan Max Score ≤ 100.');
        }
    });
});
</script>
@endpush