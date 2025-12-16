<!DOCTYPE html>
<html>
<body style="font-family: Arial">

    <h2>⚠️ Stok Bahan Baku Menipis</h2>

    <p>Halo,</p>

    <p>Stok bahan baku berikut sudah mencapai batas minimum:</p>

    <table cellpadding="6" border="1" cellspacing="0">
        <tr>
            <td><strong>Nama Bahan</strong></td>
            <td>{{ $bahan->nama_bahan }}</td>
        </tr>
        <tr>
            <td><strong>Sisa Stok</strong></td>
            <td>{{ $bahan->stok }} {{ $bahan->satuan }}</td>
        </tr>
        <tr>
            <td><strong>Batas Minimum</strong></td>
            <td>{{ $bahan->min_stok }}</td>
        </tr>
    </table>

    <p>Mohon segera lakukan restock.</p>

    <p>
        Salam,<br>
        <strong>Losbak System</strong>
    </p>

</body>
</html>
