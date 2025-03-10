@extends('User.templates_user.header')
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
                        <h1>Barang Inventaris</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal"><i
                        class="fas fa-plus-square"></i> Tambah Data Barang</button>

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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            &times;</button>
                        <h5><i class="icon fas fa-check"></i>Sukses!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            x</button>
                        <h5><i class="icon fas fa-ban"></i>Data Gagal Disimpan!</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Jenis Barang</th>
                            <th>Asal Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Entry</th>
                            <th>Status</th>
                            <th>Menu</th>
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

                                <td>
                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                        data-target="#formModal" data-mode="edit" data-id="{{ $barang->br_kode }}"
                                        data-terima="{{ $barang->br_tgl_terima }}"
                                        data-jenis="{{ $barang->jenisBarang->jns_brg_kode }}"
                                        data-asal="{{ $barang->asalBarang->id_asal_br }}"
                                        data-entry="{{ $barang->br_tgl_entry }}"
                                        data-status="{{ $barang->br_status }}">Edit</button>

                                    <button class="btn btn-danger" type="button" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $barang->br_kode }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data barang ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('User/Barang/modals')
@endsection
@push('script')
    <script>
        $('#formModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const mode = btn.data('mode');
            const br_kode = btn.data('id');
            const jns_barang_nama = btn.data('jenis');
            const nama_perusahaan = btn.data('asal');
            const br_tgl_terima = btn.data('terima');
            const br_tgl_entry = btn.data('entry');
            const br_status = btn.data('status');
            const modal = $(this);

            if (mode == 'edit') {
                modal.find('.modal-title').text('Edit Data Barang');
                modal.find('#br_kode').val(br_kode);
                modal.find('#br_tgl_terima').val(br_tgl_terima);
                modal.find('#jns_brg_kode').val(jns_barang_nama);
                modal.find('#id_asal_br').val(nama_perusahaan);
                modal.find('#br_tgl_entry').val(br_tgl_entry);
                modal.find('#br_status').val(br_status);
                modal.find('.modal-body form').attr('action', '{{ url('/user/barang') }}/' + br_kode);
                modal.find('#method').html('@method('PATCH')');
            } else {
                modal.find('.modal-title').text('Input Data Barang');
                modal.find('#br_tgl_terima').val('');
                modal.find('#jns_brg_kode').val('');
                modal.find('#id_asal_br').val('');
                modal.find('#br_tgl_entry').val('');
                modal.find('#br_status').val('1');
                modal.find('#method').html('');
                modal.find('.modal-body form').attr('action', '{{ url('/user/barang') }}');
            }
        });

        $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
            var barangKode = $(this).data('id');
            $('#deleteForm').attr('action', '/user/barang/' + barangKode);
        });
    </script>
@endpush
