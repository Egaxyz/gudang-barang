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
                            <h1>Daftar Peminjaman</h1>
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
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode Peminjaman</th>
                                <th>Kode Barang</th>
                                <th>Nama Peminjam</th>
                                <th>NIS Peminjam</th>
                                <th>Nama Operator</th>
                                <th>Tanggal Harus Kembali</th>
                                <th>Status</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <<tbody>
                            @foreach ($peminjaman as $pinjam)
                                <tr>
                                    <td>{{ optional($pinjam->barang)->br_kode ?? 'unknown' }}</td>
                                    <td>{{ $pinjam->siswa->siswa_id ?? 'unknown' }}</td>
                                    <td>{{ $pinjam->siswa->siswa_id ?? 'unknown' }}</td>
                                    <td>{{ $pinjam->pengguna->user_nama ?? 'unknown' }}</td>
                                    <td>{{ $pinjam->pb_tgl }}</td>
                                    <td>{{ $pinjam->pb_harus_kembali_tgl }}</td>
                                    <td>{{ $pinjam->pb_stat }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <button class="btn btn-success btn-m mr-2" type="button" data-toggle="modal"
                                                data-target="#formModal" data-mode="edit" data-id="{{ $pinjam->pb_id }}"
                                                data-barang="{{ optional($pinjam->barang)->br_kode }}"
                                                data-pengguna="{{ $pinjam->pengguna->user_id }}"
                                                data-nama="{{ $pinjam->siswa->siswa_id }}"
                                                data-nis="{{ $pinjam->siswa->siswa_id }}"
                                                data-tanggal="{{ $pinjam->pb_tgl }}"
                                                data-kembali="{{ $pinjam->pb_harus_kembali_tgl }}"
                                                data-status="{{ $pinjam->stat }}">Edit</button>
                                            <button class="btn btn-danger btn-m" type="button" data-toggle="modal"
                                                data-target="#deleteModal" data-id="{{ $pinjam->pb_id }}">Delete</button>
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
                        Apakah Anda yakin ingin menghapus data peminjaman ini?
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

        @include('SuperUser/Peminjaman/modals')
    @endsection

    @push('script')
        <script>
            $('#formModal').on('show.bs.modal', function(e) {
                const btn = $(e.relatedTarget);
                console.log(btn.data());

                // Ambil data dari tombol
                const mode = btn.data('mode');
                const pb_id = btn.data('id');
                // const pbd_id = btn.data('detail');
                const br_kode = btn.data('barang');
                const siswa_nama = btn.data('nama');
                const siswa_nis = btn.data('nis');
                const user_id = btn.data('pengguna'); // Ambil nama operator
                const pb_tgl = btn.data('tanggal');
                const pb_harus_kembali_tgl = btn.data('kembali');
                const modal = $(this);

                if (mode == 'edit') {
                    modal.find('.modal-title').text('Edit Data Peminjaman');
                    modal.find('#pb_id').val(pb_id);
                    // modal.find('#pbd_id').val(pbd_id);
                    modal.find('#br_kode').val(br_kode);
                    modal.find('#nama_siswa').val(siswa_nama);
                    modal.find('#nis').val(siswa_nis);
                    modal.find('#user_id').val(user_id); // Pastikan diisi saat edit
                    modal.find('#pb_tgl').val(pb_tgl);
                    modal.find('#pb_harus_kembali_tgl').val(pb_harus_kembali_tgl);
                    modal.find('.modal-body form').attr('action', '{{ url('/superuser/peminjaman') }}/' + pb_id);
                    modal.find('#method').html('@method('PATCH')');
                } else {
                    modal.find('.modal-title').text('Input Data Peminjaman');
                    modal.find('#pb_id').val('');
                    // modal.find('#pbd_id').val('');
                    modal.find('#br_kode').val('');
                    modal.find('#nama_siswa').val('');
                    modal.find('#nis').val('');
                    modal.find('#user_id').val(''); // Pastikan dikosongkan saat tambah
                    modal.find('#pb_tgl').val('');
                    modal.find('#pb_harus_kembali_tgl').val('');
                    modal.find('#method').html('');
                    modal.find('.modal-body form').attr('action', '{{ url('/superuser/peminjaman') }}');
                }
            });

            $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
                var barangKode = $(this).data('id');
                $('#deleteForm').attr('action', '/superuser/peminjaman/' + barangKode);
            });
        </script>
    @endpush
