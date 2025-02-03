@extends('SuperUser.templates_superuser.header')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Pengembalian Barang</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
                <!-- Tombol print dan export -->
                <button id="printButton" class="btn btn-primary" onclick="window.print()">Print</button>
                <a id="exportButton" href="{{ url('/pengembalian/pdf') }}" class="btn btn-danger">Export PDF</a>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
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
            </div>

        </div>
    </div>
    <script>
        window.onbeforeprint = function() {
            document.getElementById("printButton").style.display = "none";
            document.getElementById("exportButton").style.display = "none";
            document.getElementById("printTitle").style.display = "block"; // Menampilkan judul "Data Barang"
        };

        window.onafterprint = function() {
            document.getElementById("printButton").style.display = "inline-block";
            document.getElementById("exportButton").style.display = "inline-block";
            document.getElementById("printTitle").style.display = "none"; // Menyembunyikan judul setelah print
        };
    </script>
@endsection
