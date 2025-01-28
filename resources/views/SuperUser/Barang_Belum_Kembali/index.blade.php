@extends('templates.header')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Barang Belum Kembali</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Nama Peminjam</th>
                            <th>NIS Peminjam</th>
                            <th>Status Barang</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang_inventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->peminjamanBarang->peminjaman->pb_tgl ?? 'Unknown' }}</td>
                                <td>{{ $barang->peminjamanBarang->peminjaman->siswa->nama_siswa ?? 'Error' }}</td>
                                <td>{{ $barang->peminjamanBarang->peminjaman->siswa->nis ?? 'Error' }}</td>
                                <td>{{ $barang->peminjamanBarang->pdb_sts ?? 'dipinjam' }}</td>
                                <td>Edit | Delete</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
