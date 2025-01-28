@extends('templates.header')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Barang Inventaris</h1>
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
                            <th>Jenis Barang Kode</th>
                            <th>Tanggal Entry</th>
                            <th>Status Barang</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang_inventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->jenisBarang->jns_barang_nama ?? 'Unknown' }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td>
                                <td>{{ $barang->peminjamanBarang->pdb_sts ?? 'tersedia' }}</td>
                                <td>Edit | Delete</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
