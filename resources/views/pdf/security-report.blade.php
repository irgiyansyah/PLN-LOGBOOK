<!DOCTYPE html>
<html>
<head>
    <title>Laporan Mutasi Satpam</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        
        .main-title { 
            font-size: 16px; 
            font-weight: bold; 
            text-align: center; 
            text-decoration: underline; 
            margin-bottom: 15px;
            width: 100%;
        }

        .header-table { width: 100%; margin-bottom: 20px; }
        
        .logo-img {
            width: 200px; 
            height: auto;
        }
        
        .bordered-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .bordered-table th, .bordered-table td { border: 1px solid black; padding: 4px; }
        .bordered-table th { background-color: #f0f0f0; text-align: center; }
        .text-center { text-align: center; }
        
        /* CSS Area Tanda Tangan */
        .signature-table { width: 100%; margin-top: 20px; page-break-inside: avoid; }
        
        /* Container untuk membungkus blok TTD agar tetap center di dalam aligment pinggir */
        .sig-container {
            display: inline-block;
            text-align: center;
            width: 180px; /* Lebar area per blok TTD */
        }

        .signature-box { 
            height: 100px; /* Diperbesar lagi dari 90px */
            margin-bottom: 5px; 
            text-align: center; 
            vertical-align: middle;
        }
        .signature-img { 
            height: 95px; /* Diperbesar lagi dari 85px */
            width: auto; 
            display: inline-block; 
        }

        .evidence-box { margin-top: 20px; text-align: center; page-break-inside: avoid; }
        .evidence-img { max-width: 90%; max-height: 300px; border: 1px solid #ccc; padding: 5px; }
    </style>
</head>
<body>

    <div class="main-title">MUTASI LAPORAN SATPAM</div>

    <table class="header-table">
        <tr>
            <td width="50%" valign="top">
                <img src="{{ public_path('images/pln-logo.png') }}" class="logo-img" alt="Logo PLN">
            </td>
            <td width="50%" valign="top" style="font-size: 12px;">
                <table align="right">
                    <tr>
                        <td>HARI</td>
                        <td>: {{ \Carbon\Carbon::parse($record->report_date)->locale('id')->isoFormat('dddd') }}</td>
                    </tr>
                    <tr>
                        <td>TANGGAL</td>
                        <td>: {{ \Carbon\Carbon::parse($record->report_date)->locale('id')->isoFormat('D MMMM Y') }}</td>
                    </tr>
                    <tr>
                        <td>SHIFT</td>
                        <td>: {{ $record->shift ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>JAM</td>
                        <td>: {{ \Carbon\Carbon::parse($record->start_time)->format('H.i') }} - {{ \Carbon\Carbon::parse($record->end_time)->format('H.i') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="bordered-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th>NAMA</th>
                <th width="20%">JABATAN</th>
                <th width="20%">JAM DINAS</th>
                <th width="15%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->personnels as $index => $personil)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $personil->name }}</td>
                <td class="text-center">{{ $personil->role }}</td>
                <td class="text-center">07.00 - 15.00</td>
                <td class="text-center">{{ $personil->attendance_status }}</td>
            </tr>
            @endforeach
            @if($record->personnels->count() == 0)
                <tr><td colspan="5" class="text-center">- Tidak ada data personil -</td></tr>
            @endif
        </tbody>
    </table>

    <div style="margin-bottom: 10px; text-align: justify;">
        Pada Hari ini, <b>{{ \Carbon\Carbon::parse($record->report_date)->locale('id')->isoFormat('dddd') }}</b> 
        Tanggal <b>{{ \Carbon\Carbon::parse($record->report_date)->locale('id')->isoFormat('D MMMM Y') }}</b>, 
        pukul <b>{{ \Carbon\Carbon::parse($record->start_time)->format('H.i') }}</b>. 
        Saya selaku Petugas Jaga Telah menerima tugas dan tanggung jawab "Pos Jaga UP3 PALOPO" 
        dalam Keadaan <b>{{ strtoupper($record->area_status) }}</b>. Berikut barang Inventaris Lengkap sebagai berikut:
    </div>

    <table class="bordered-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th>NAMA BARANG</th>
                <th width="10%">JUMLAH</th>
                <th width="15%">KONDISI</th>
                <th width="20%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->inventories as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->item_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">{{ $item->condition }}</td>
                <td>{{ $item->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="font-weight: bold; margin-bottom: 5px;">URAIAN KEJADIAN / KEGIATAN</div>
    <table class="bordered-table">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="10%">JAM</th>
                <th>URAIAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->activities as $index => $activity)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($activity->log_time)->format('H.i') }}</td>
                <td>{{ $activity->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td width="50%" align="left" valign="top">
                <div class="sig-container">
                    <div style="margin-bottom: 20px;">&nbsp;</div>
                    <div>Yang Menerima</div>
                    <div style="font-size: 10px; margin-bottom: 5px;">Petugas Jaga</div>
                    
                    <div class="signature-box">
                        @if($record->signature_to)
                            @if(str_starts_with($record->signature_to, 'data:image'))
                                <img src="{{ $record->signature_to }}" class="signature-img">
                            @elseif(file_exists(storage_path('app/public/' . $record->signature_to)))
                                <img src="{{ storage_path('app/public/' . $record->signature_to) }}" class="signature-img">
                            @endif
                        @endif
                    </div>

                    <div style="font-weight: bold; text-decoration: underline;">
                        {{ $record->handover_to }}
                    </div>
                </div>
            </td>

            <td width="50%" align="right" valign="top">
                <div class="sig-container">
                    <div style="margin-bottom: 5px; font-size: 11px;">
                        Palopo, {{ \Carbon\Carbon::parse($record->report_date)->locale('id')->isoFormat('D MMMM Y') }}
                    </div>
                    <div>Yang Menyerahkan</div>
                    <div style="font-size: 10px; margin-bottom: 5px;">Petugas Jaga Lama</div>

                    <div class="signature-box">
                        @if($record->signature_from)
                            @if(str_starts_with($record->signature_from, 'data:image'))
                                <img src="{{ $record->signature_from }}" class="signature-img">
                            @elseif(file_exists(storage_path('app/public/' . $record->signature_from)))
                                <img src="{{ storage_path('app/public/' . $record->signature_from) }}" class="signature-img">
                            @endif
                        @endif
                    </div>

                    <div style="font-weight: bold; text-decoration: underline;">
                        {{ $record->handover_from }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    @if($record->evidence_photo)
    <div class="evidence-box">
        <div style="font-weight: bold; text-decoration: underline; margin-bottom: 10px;">LAMPIRAN DOKUMENTASI</div>
        @if(file_exists(storage_path('app/public/' . $record->evidence_photo)))
            <img src="{{ storage_path('app/public/' . $record->evidence_photo) }}" class="evidence-img">
        @endif
    </div>
    @endif

</body>
</html>