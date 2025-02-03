@extends('Admin.templates_admin.header')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Laporan Daftar Barang Inventaris</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
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
                            <th>Kode Barang</th>
                            <th>Jenis Barang</th>
                            <th>Asal Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Entry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang_inventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->jenisBarang->jns_barang_nama ?? 'Unknown' }}</td>
                                <td>{{ $barang->asalBarang->nama_perusahaan ?? 'Unknown' }}</td>
                                <td>{{ $barang->br_tgl_terima }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td>
                                <td>
                                    @if ($barang->br_status == 0)
                                        <span class="badge badge-danger">Dihapus</span>
                                    @elseif ($barang->br_status == 1)
                                        <span class="badge badge-success">Baik</span>
                                    @elseif ($barang->br_status == 2)
                                        <span class="badge badge-warning">Rusak (Bisa Diperbaiki)</span>
                                    @elseif ($barang->br_status == 3)
                                        <span class="badge badge-dark">Rusak (Tidak Bisa Digunakan)</span>
                                    @else
                                        <span class="badge badge-secondary">Status Tidak Diketahui</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script></script>
@endpush
