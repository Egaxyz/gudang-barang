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
                        <h1>Kelas</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="card">
            <div class="card-header">
                <button class="btn bg-primary" type="button" data-toggle="modal" data-target="#formModal"><i
                        class="fas fa-plus-square"></i> Tambah Data Kelas</button>

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
                            <th>Tingkatan</th>
                            <th>Jurusan</th>
                            <th>Konsentrasi</th>
                            <th>No. Konsentrasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $kelas)
                            <tr>
                                <td>{{ $kelas->tingkatan }}</td>
                                <td>{{ $kelas->jurusan->jurusan ?? 'Unknown' }}</td>
                                <td>{{ $kelas->konsentrasi }}</td>
                                <td>{{ $kelas->no_konsentrasi }}</td>
                                <td>
                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                        data-target="#formModal" data-mode="edit" data-id="{{ $kelas->kelas_id }}"
                                        data-tingkatan="{{ $kelas->tingkatan }}"
                                        data-jurusan="{{ $kelas->jurusan->jurusan_id }}"
                                        data-konsentrasi="{{ $kelas->konsentrasi }}"
                                        data-no="{{ $kelas->no_konsentrasi }}">Edit</button>
                                    <button class="btn btn-danger" type="button" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $kelas->kelas_id }}">Delete</button>
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
    @include('SuperUser/Kelas/modals')
@endsection

@push('script')
    <script>
        $('#formModal').on('show.bs.modal', function(e) {
            const btn = $(e.relatedTarget);
            console.log(btn.data());
            const mode = btn.data('mode');
            const kelas_id = btn.data('id');
            const jurusan = btn.data('jurusan')
            const tingkatan = btn.data('tingkatan');
            const konsentrasi = btn.data('konsentrasi');
            const no_konsentrasi = btn.data('no');
            const modal = $(this);

            if (mode == 'edit') {
                modal.find('.modal-title').text('Edit Data Kelas');
                modal.find('#tingkatan').val(tingkatan);
                modal.find('#jurusan_id').val(jurusan);
                modal.find('#konsentrasi').val(konsentrasi)
                modal.find('#no_konsentrasi').val(no_konsentrasi)
                modal.find('.modal-body form').attr('action', '{{ url('/superuser/kelas') }}/' +
                    kelas_id);
                modal.find('#method').html('@method('PATCH')');
            } else {
                modal.find('.modal-title').text('Input Data Pengguna');
                modal.find('#tingkatan').val('');
                modal.find('#jurusan_id').val('');
                modal.find('#konsentrasi').val('')
                modal.find('#no_konsentrasi').val('')
                modal.find('#method').html('');
                modal.find('.modal-body form').attr('action',
                    '{{ url('/superuser/kelas') }}');
            }
        });

        $(document).on('click', '[data-toggle="modal"][data-target="#deleteModal"]', function() {
            var kelasId = $(this).data('id');
            $('#deleteForm').attr('action', '/superuser/kelas/' + kelasId);
        });
    </script>
@endpush
