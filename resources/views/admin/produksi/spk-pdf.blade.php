<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Perintah Kerja</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f0f0f0;
        }
        .no-border td {
            border: none;
            padding: 4px;
        }
        .header {
            margin-bottom: 15px;
        }
        .logo {
            width: 80px;
        }
        .center {
            text-align: center;
        }
        .signature td {
            border: none;
            padding-top: 60px;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<table class="no-border header">
    <tr>
        <td width="20%">
            <img src="{{ public_path('images/logo-sumber-urip.png') }}" class="logo">
        </td>
        <td width="80%" class="center">
            <strong>IKM SUMBER URIP</strong><br>
            Produksi Bak Mobil
        </td>
    </tr>
</table>

<hr>

<h3 class="center">SURAT PERINTAH KERJA (SPK)</h3>

{{-- INFO PRODUKSI --}}
<table class="no-border">
    <tr>
        <td width="25%">No Produksi</td>
        <td width="5%">:</td>
        <td>{{ $produksi->id_produksi }}</td>
    </tr>
    <tr>
        <td>Jenis Produksi</td>
        <td>:</td>
        <td>{{ ucfirst($produksi->jenis) }}</td>
    </tr>
    <tr>
        <td>Template</td>
        <td>:</td>
        <td>{{ $produksi->template?->nama_template ?? '-' }}</td>
    </tr>
    <tr>
        <td>Tanggal Produksi</td>
        <td>:</td>
        <td>{{ $tanggal }}</td>
    </tr>
    <tr>
        <td>Jam Cetak</td>
        <td>:</td>
        <td>{{ $jam }}</td>
    </tr>
</table>

<br>

{{-- TABEL BAHAN --}}
<table>
    <thead>
        <tr>
            <th>Nama Bahan</th>
            <th>Jumlah Digunakan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produksi->details as $d)
        <tr>
            <td>{{ $d->bahan?->nama_bahan ?? '-' }}</td>
            <td>{{ $d->jumlah_dipakai }} {{ $d->bahan?->satuan ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

{{-- TANDA TANGAN --}}
<table class="signature">
    <tr>
        <td>
            Mengetahui,<br>
            Pimpinan IKM<br><br>
            ( __________________ )
        </td>
        <td>
            Pelaksana Produksi<br><br>
            ( __________________ )
        </td>
    </tr>
</table>

</body>
</html>
