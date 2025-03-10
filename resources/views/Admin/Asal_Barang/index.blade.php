@extends('SuperUser.templates_superuser.header')
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
                        <h1>Asal Barang Inventaris</h1>
                    </div>
                </div>
            </div>
        </section>
        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal">
                    <i class="fas fa-plus-square"></i> Tambah Data Asal Barang
                </button>

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
                            <th>Kode Asal Barang</th>
                            <th>Nama Perusahaan</th>
                            <th>Jumlah Kirim</th>
                            <th>Tanggal Kirim</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asal_barang as $barang)
                            <tr>
                                <td>{{ $barang->id_asal_br }}</td>
                                <td>{{ $barang->nama_perusahaan }}</td>
                                <td>{{ $barang->jumlah_kirim }}</td>
                                <td>{{ $barang->tgl_kirim }}</td>
                                <td>
                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                        data-target="#formModal" data-mode="edit" data-id="{{ $barang->id_asal_br }}"
                                        data-nama="{{ $barang->nama_perusahaan }}"
                                        data-jumlah="{{ $barang->jumlah_kirim }}"
                                        data-tanggal="{{ $barang->tgl_kirim }}">Edit</button>

                                    <button class="btn btn-danger" type="button" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $barang->id_asal_br }}">Delete</button>
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
                    Apakah Anda yakin ingin menghapus data asal barang ini?
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

    @include('Admin/Asal_Barang.modals')
@endsection

@push('script')
    <script>
        $('#formModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            console.log(btn.data());
            const mode = btn.data('mode');
            const id_asal_br = btn.data('id');
            const nama_perusahaan = btn.data('nama');
            const jumlah_kirim = btn.data('jumlah');
            const tgl_kirim = btn.data('tanggal');
            const modal = $(this);

            if (mode == 'edit') {
                modal.find('.modal-title').text('Edit Data Asal Barang');
                modal.find('#nama_perusahaan').val(nama_perusahaan);
                modal.find('#jumlah_kirim').val(jumlah_kirim);
                modal.find('#tgl_kirim').val(tgl_kirim);

                modal.find('.modal-body form').attr('action', '{{ url('/admin/asal-barang') }}/' +
                    id_asal_br);
                modal.find('#method').html('@method('PATCH')');
            } else {
                modal.find('.modal-title').text('Input Data Asal Barang');
                modal.find('#nama_perusahaan').val('');
                modal.find('#jumlah_kirim').val('');
                modal.find('#tgl_kirim').val('');
                modal.find('#method').html('');
                modal.find('.modal-body form').attr('action',
                    '{{ url('/admin/asal-barang') }}');
            }
        });

        $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
            var barangId = $(this).data('id');
            $('#deleteForm').attr('action', '/admin/asal-barang/' + barangId);
        });
    </script>
@endpush
