@extends('templates.header')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jenis Barang Inventaris</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal"><i
                        class="fas fa-plus-square"></i>Data Jenis Barang</button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Barang Kode</th>
                            <th>Jenis Barang Nama</th>
                            <th>Tanggal Entry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jenis_barang as $barang)
                            <tr>
                                <td>{{ $barang->jns_brg_kode }}</td>
                                <td>{{ $barang->jns_barang_nama }}</td>
                                <td>{{ $barang->tgl_entry }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
