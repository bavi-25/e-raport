<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>E-Raport Siswa</title>
        <style>
            @page {
                margin: 20mm 15mm;
            }

            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 11pt;
                line-height: 1.4;
                color: #000;
            }

            .container {
                width: 100%;
            }

            .header {
                text-align: center;
                border-bottom: 3px solid #000;
                padding-bottom: 8px;
                margin-bottom: 12px;
            }

            .header h1 {
                font-size: 18pt;
                margin: 0 0 4px 0;
                text-transform: uppercase;
            }

            .header h2 {
                font-size: 14pt;
                margin: 0 0 3px 0;
            }

            .header p {
                font-size: 10pt;
                margin: 2px 0;
            }

            .section-title {
                background: #2c3e50;
                color: #fff;
                padding: 6px 8px;
                font-size: 12pt;
                font-weight: bold;
                margin: 14px 0 8px 0;
                text-transform: uppercase;
            }

            /* Info siswa tanpa flex */
            .info-table {
                width: 100%;
                border-collapse: collapse;
                margin: 8px 0 12px 0;
            }

            .info-table td {
                padding: 4px 2px;
                vertical-align: top;
                font-size: 10.5pt;
            }

            .info-label {
                width: 38mm;
            }

            .info-sep {
                width: 6mm;
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 12px;
            }

            thead {
                display: table-header-group;
            }

            /* header ulang tiap halaman */
            tfoot {
                display: table-row-group;
            }

            tr {
                page-break-inside: avoid;
            }

            table th {
                background-color: #34495e;
                color: #fff;
                padding: 8px 6px;
                text-align: center;
                font-size: 10pt;
                border: 1px solid #000;
            }

            table td {
                padding: 6px;
                border: 1px solid #000;
                font-size: 10pt;
            }

            .center {
                text-align: center;
            }

            .mapel {
                padding-left: 6px;
            }

            .nilai-rata {
                background-color: #ecf0f1;
                font-weight: bold;
            }

            /* Signature tanpa flex */
            .signature-wrap {
                width: 100%;
                margin-top: 18px;
            }

            .signature-col {
                width: 48%;
                display: inline-block;
                vertical-align: top;
                text-align: center;
            }

            .signature-col p {
                margin: 0 0 50px 0;
                font-size: 10pt;
            }

            .name {
                font-weight: bold;
                border-bottom: 1px solid #000;
                display: inline-block;
                min-width: 60mm;
                padding-bottom: 2px;
            }

            .footer {
                margin-top: 10px;
                text-align: center;
                font-size: 9pt;
                color: #666;
            }
        </style>
    </head>

    <body>
        <div class="container">
            {{-- Header --}}
            <div class="header">
                <h1>{{ $sekolah->name ?? 'NAMA SEKOLAH' }}</h1>
                <h2>LAPORAN HASIL BELAJAR SISWA</h2>
                {{-- <p>{{ $sekolah['alamat'] ?? 'Alamat Sekolah' }}</p>
                <p>Telp: {{ $sekolah['telepon'] ?? '021-XXXXXXXX' }} | Email:
                    {{ $sekolah['email'] ?? 'email@sekolah.sch.id' }}
                </p> --}}
            </div>

            {{-- Info Siswa --}}
            <table class="info-table">
                <tr>
                    <td class="info-label">Nama Siswa</td>
                    <td class="info-sep">:</td>
                    <td>{{ $siswa->name ?? 'Nama Lengkap Siswa' }}</td>
                </tr>
                <tr>
                    <td class="info-label">NIS</td>
                    <td class="info-sep">:</td>
                    <td>{{ $siswa->nip_nis ?? '000000' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Kelas / Semester</td>
                    <td class="info-sep">:</td>
                    <td>{{ $kelas->nama ?? 'X IPA 1' }} / {{ $semester ?? 'Ganjil' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tahun Pelajaran</td>
                    <td class="info-sep">:</td>
                    <td>{{ $tahun_ajaran ?? '2024/2025' }}</td>
                </tr>
            </table>

            {{-- Nilai Akademik --}}
            <div class="section-title">A. Nilai Akademik dan Kehadiran</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 45%;">Mata Pelajaran</th>
                        <th style="width: 15%;">Nilai Akhir</th>
                        <th style="width: 15%;">Hadir</th>
                        <th style="width: 20%;">Tidak Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td class="mapel">{{ $item['mata_pelajaran'] }}</td>
                        <td class="center">{{ $item['nilai_akhir'] }}</td>
                        <td class="center">{{ $item['hadir'] }} x</td>
                        <td class="center">{{ $item['tidak_hadir'] }} x</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="center">Tidak ada data nilai.</td>
                    </tr>
                    @endforelse
            
                    @if(count($nilai) > 0)
                    <tr class="nilai-rata">
                        <td colspan="2" style="text-align:right; padding-right:6px;">RATA-RATA NILAI</td>
                        <td class="center">{{ $rata_rata }}</td>
                        <td colspan="2"></td>
                    </tr>
                    @endif
                </tbody>
            </table>

            {{-- Ketidakhadiran --}}
            {{-- <div class="section-title">B. Ketidakhadiran</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 60%;">Keterangan</th>
                        <th style="width: 40%;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="mapel">Sakit</td>
                        <td class="center">{{ $kehadiran->sakit ?? '0' }} hari</td>
            </tr>
            <tr>
                <td class="mapel">Izin</td>
                <td class="center">{{ $kehadiran->izin ?? '0' }} hari</td>
            </tr>
            <tr>
                <td class="mapel">Tanpa Keterangan</td>
                <td class="center">{{ $kehadiran->alpha ?? '0' }} hari</td>
            </tr>
            </tbody>
            </table> --}}

            {{-- Catatan Wali Kelas --}}
            {{-- <div class="section-title">C. Catatan Wali Kelas</div>
            <table style="width:100%; border-collapse:collapse; margin-bottom: 8px;">
                <tr>
                    <td style="border:1px solid #000; padding:10px; min-height:80px;">
                        {{ $catatan ?? 'Siswa menunjukkan perkembangan yang baik dalam proses pembelajaran. Tetap pertahankan prestasi dan tingkatkan kedisiplinan.' }}
            </td>
            </tr>
            </table> --}}

            {{-- Tanda Tangan --}}
            <div class="signature-wrap">
                <div class="signature-col">
                    <p>Orang Tua/Wali</p>
                    <div class="name">( ........................... )</div>
                </div>
                <div class="signature-col">
                    <p>{{ $kota ?? 'Kota' }}, {{ $tanggal ?? date('d F Y') }}</p>
                    <p style="margin-bottom:50px;">Wali Kelas</p>
                    <div class="name">{{ $wali_kelas->nama ?? '( Nama Wali Kelas )' }}</div>
                    @if(isset($wali_kelas->nip))
                    <p style="margin-top: 5px; font-size: 9pt;">NIP. {{ $wali_kelas->nip }}</p>
                    @endif
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                Dicetak pada: {{ date('d F Y H:i:s') }}
            </div>
        </div>
    </body>

</html>