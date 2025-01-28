@extends('templates.header')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asal Barang</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal"><i
                        class="fas fa-plus-square"></i>Data Asal Barang</button>

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
                            <th>Barang Kode</th>
                            <th>Nama Perusahaan</th>
                            <th>Jumlah Kirim</th>
                            <th>Tanggal Kirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asal_barang as $barang)
                            <tr>
                                <td>{{ $barang->id_asal_br }}</td>
                                <td>{{ $barang->nama_perusahaan }}</td>
                                <td>{{ $barang->jumlah_kirim }}</td>
                                <td>{{ $barang->tgl_kirim }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
