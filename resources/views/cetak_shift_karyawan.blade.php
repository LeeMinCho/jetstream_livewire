<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Shift Karyawan</title>
    <!-- Bootstrap Core Css -->
    <link href="{{ url("assets/AdminBSB") }}/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Durasi</th>
                    <th>Keterangan</th>
                    <th>Lewat Hari</th>
                    <th>Libur</th>
                    <th>Warna</th>
                </tr>
            </thead>
            <tbody>
                @if ($shift_karyawan)
                @foreach ($shift_karyawan as $sk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sk->v_shift_jadwal_code }}</td>
                    <td>{{ $sk->v_shift_jadwal_desc }}</td>
                    <td>{{ $sk->jam_masuk }}</td>
                    <td>{{ $sk->jam_keluar }}</td>
                    <td>{{ $sk->lama_jam_kerja }}</td>
                    <td>{{ $sk->keterangan }}</td>
                    <td>{{ $sk->is_lewathari }}</td>
                    <td>{{ $sk->is_libur }}</td>
                    <td>{{ $sk->color }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>