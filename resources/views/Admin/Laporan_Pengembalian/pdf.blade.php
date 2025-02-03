<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Inventaris</title>
    <style>
        /* Center the h2 element */
        h2.center {
            text-align: center;
            margin-bottom: 20px;
            /* Add space below the title */
        }

        /* Styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            /* Ensures borders are combined */
            margin: 0 auto;
            /* Center the table */
        }

        th,
        td {
            border: 1px solid black;
            /* Add border to table cells */
            padding: 10px;
            /* Add padding inside cells */
            text-align: left;
            /* Align text to the left */
        }

        th {
            background-color: #f2f2f2;
            /* Light background for header */
        }
    </style>
</head>

<body>
    <h2 class="center">Barang Inventaris</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Pengembalian</th>
                <th>Kode Peminjaman</th>
                <th>Nama Operator</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalian as $kembali)
                <tr>
                    <td>{{ $kembali->kembali_id }}</td>
                    <td>{{ $kembali->pb_id }}</td>
                    <td>{{ $kembali->pengguna->user_nama ?? 'Unknown' }}</td>
                    <td>{{ $kembali->kembali_tgl }}</td>
                    <td>{{ $kembali->kembali_sts }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
