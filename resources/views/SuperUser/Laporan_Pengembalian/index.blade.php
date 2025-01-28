@extends('templates.header')
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

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Pengembalian</th>
                            <th>Kode Peminjaman</th>
                            <th>Nama Operator</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                            <th>Menu</th>
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
                                <td>Edit | Delete</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
