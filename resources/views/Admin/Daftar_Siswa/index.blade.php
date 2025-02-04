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
                        <h1>Daftar Siswa</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal"><i
                        class="fas fa-plus-square"></i> Tambah Data Siswa</button>

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
                            <th>Nama</th>
                            <th>Tingkatan</th>
                            <th>Jurusan</th>
                            <th>Konsentrasi</th>
                            <th>No Konsentrasi</th>
                            <th>NIS</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $akun)
                            <tr>
                                <td>{{ $akun->nama_siswa }}</td>
                                <td>{{ $akun->kelasData->tingkatan ?? 'unknown' }}</td>
                                <td>{{ $akun->jurusanData->jurusan ?? 'unknown' }}</td>
                                <td>{{ $akun->kelasData->konsentrasi ?? 'unknown' }}</td>
                                <td>{{ $akun->kelasData->no_konsentrasi ?? 'unknown' }}</td>
                                <td>{{ $akun->nis }}</td>
                                <td>{{ $akun->no_hp }}</td>
                                <td>
                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                        data-target="#formModal" data-mode="edit" data-id="{{ $akun->siswa_id }}"
                                        data-nama="{{ $akun->nama_siswa }}"
                                        data-tingkatan="{{ $akun->kelas->kelas_id ?? '' }}"
                                        data-jurusan="{{ $akun->jurusanData->jurusan ?? '' }}"
                                        data-konsentrasi="{{ $akun->kelasData->kelas_id ?? '' }}"
                                        data-noKonsentrasi="{{ $akun->kelasData->kelas_id ?? '' }}"
                                        data-nis="{{ $akun->nis }}" data-hp="{{ $akun->no_hp }}">
                                        Edit
                                    </button>

                                    <button class="btn btn-danger" type="button" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $akun->siswa_id }}">Delete</button>
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
                    Apakah Anda yakin ingin menghapus jenis barang ini?
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
    @include('Admin/Daftar_Siswa/modals')
@endsection

@push('script')
    <script>
        $('#formModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            const mode = btn.data('mode');
            const siswa_id = btn.data('id');
            const nama_siswa = btn.data('nama');
            const kelas_id = btn.data('tingkatan');
            const jurusan_id = btn.data('jurusan');
            const konsentrasi_id = btn.data('konsentrasi');
            const no_konsentrasi_id = btn.data('noKonsentrasi');
            const nis = btn.data('nis');
            const no_hp = btn.data('hp');
            const modal = $(this);

            if (mode == 'edit') {
                modal.find('.modal-title').text('Edit Data Siswa');
                modal.find('#nama_siswa').val(nama_siswa);
                modal.find('#tingkatan').val(kelas_id);
                modal.find('#jurusan').val(jurusan_id);
                modal.find('#konsentrasi').val(konsentrasi_id);
                modal.find('#no_konsentrasi').val(no_konsentrasi_id);
                modal.find('#nis').val(nis);
                modal.find('#no_hp').val(no_hp);
                modal.find('.modal-body form').attr('action', '{{ url('/admin/siswa') }}/' + siswa_id);
                modal.find('#method').html('@method('PATCH')');
            } else {
                modal.find('.modal-title').text('Input Data Siswa');
                modal.find('#nama_siswa').val('');
                modal.find('#kelas_id').val('');
                modal.find('#jurusan_id').val('');
                modal.find('#konsentrasi_id').val('');
                modal.find('#no_konsentrasi_id').val(''); // Kosongkan no_konsentrasi pada mode tambah
                modal.find('#nis').val('');
                modal.find('#no_hp').val('');
                modal.find('#method').html('');
                modal.find('.modal-body form').attr('action', '{{ url('/admin/siswa') }}');
            }
        });


        $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
            var userId = $(this).data('id');
            $('#deleteForm').attr('action', '/admin/siswa/' + userId);
        });
    </script>
@endpush
