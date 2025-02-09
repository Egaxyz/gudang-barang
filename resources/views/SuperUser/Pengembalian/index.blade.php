    @extends('SuperUser.templates_superuser.header')
    @push('style')
        <!-- DataTables -->
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
                            <h1>Daftar Pengembalian</h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <button class="btn bg-warning" type="button" data-toggle="modal" data-target="#formModal"><i
                            class="fas fa-reply"></i> Pinjam Barang</button>
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
                    <table id="example1"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode Peminjaman</th>
                                <th>Tanggal Harus Kembali</th>
                                <th>Status</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengembalian as $kembali)
                                <tr>
                                    <td>{{ $kembali->peminjaman->pb_id ?? 'unknown' }}</td>
                                    <td>{{ $kembali->kembali_tgl }}</td>
                                    <td>{{ $kembali->kembali_sts }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <button class="btn btn-success btn-m mr-2" type="button" data-toggle="modal"
                                                data-target="#formModal" data-mode="edit"
                                                data-id="{{ $kembali->kembali_id }}"
                                                data-pinjam="{{ $kembali->peminjaman->pb_id }}"
                                                data-kembali="{{ $kembali->pb_harus_kembali_tgl }}"
                                                data-status="{{ $kembali->stat }}">Edit</button>
                                            <button class="btn btn-danger btn-m" type="button" data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-id="{{ $kembali->kembali_id }}">Delete</button>
                                        </div>
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
                        Apakah Anda yakin ingin menghapus data pengembalian ini?
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

        @include('SuperUser/Pengembalian/modals')
    @endsection

    @push('script')
        <script>
            $('#formModal').on('show.bs.modal', function(e) {
                const btn = $(e.relatedTarget);
                console.log(btn.data());
                const mode = btn.data('mode');
                const kembali_id = btn.data('id');
                const pb_id = btn.data('pinjam');
                const kembali_tgl = btn.data('kembali');
                const kembali_sts = btn.data('status');
                const modal = $(this);

                if (mode == 'edit') {
                    modal.find('.modal-title').text('Edit Data Peminjaman');
                    modal.find('#kembali_id').val(kembali_id);
                    modal.find('#pb_id').val(pb_id)
                    modal.find('#kembali_tgl').val(kembali_tgl);
                    modal.find('#kembali_sts').val(kembali_sts);
                    modal.find('.modal-body form').attr('action', '{{ url('/superuser/pengembalian') }}/' +
                        kembali_id);
                    modal.find('#method').html('@method('PATCH')');
                } else {
                    modal.find('.modal-title').text('Input Data pengembalian');
                    modal.find('#kembali_id').val('');
                    modal.find('#pb_id').val(''); // Pastikan dikosongkan saat tambah
                    modal.find('#kembali_tgl').val('');
                    modal.find('#kembali_sts').val('');
                    modal.find('#method').html('');
                    modal.find('.modal-body form').attr('action', '{{ url('/superuser/pengembalian') }}');
                }
            });

            $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
                var barangKode = $(this).data('id');
                $('#deleteForm').attr('action', '/superuser/pengembalian/' + barangKode);
            });
        </script>
    @endpush
