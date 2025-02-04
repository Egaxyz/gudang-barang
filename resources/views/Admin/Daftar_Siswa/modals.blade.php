<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ url('/admin/siswa') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama_siswa" name="nama_siswa"
                            required>
                    </div>
                    <div class="form-group row">
                        <label for="kelas_id">Tingkatan</label>
                        <select id="kelas_id" name="kelas_id" class="form-control">
                            <option value="" disabled selected>Tingkatan</option>
                            @foreach ($kelasData as $kelas)
                                <option value="{{ $kelas->kelas_id }}"
                                    {{ old('kelas_id', isset($kelas) ? $kelas->kelas_id : '') == $kelas->kelas_id ? 'selected' : '' }}>
                                    {{ $kelas->tingkatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="jurusan_id">Jurusan</label>
                        <select id="jurusan_id" name="jurusan_id" class="form-control">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            @foreach ($jurusanData as $jurusan)
                                <option value="{{ $jurusan->jurusan_id }}"
                                    {{ old('jurusan_id', isset($jurusan) ? $jurusan->jurusan_id : '') == $jurusan->jurusan_id ? 'selected' : '' }}>
                                    {{ $jurusan->jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="konsentrasi_id">Konsentrasi</label>
                        <select id="konsentrasi_id" name="konsentrasi_id" class="form-control">
                            <option value="" disabled selected>Pilih Konsentrasi</option>
                            @foreach ($kelasData as $kelas)
                                <option value="{{ $kelas->kelas_id }}"
                                    {{ old('konsentrasi_id', isset($kelas) ? $kelas->kelas_id : '') == $kelas->kelas_id ? 'selected' : '' }}>
                                    {{ $kelas->konsentrasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="no_konsentrasi_id">No. Konsentrasi</label>
                        <select id="no_konsentrasi_id" name="no_konsentrasi_id" class="form-control">
                            <option value="" disabled selected>Pilih No Konsentrasi</option>
                            @foreach ($kelasData as $kelas)
                                <option value="{{ $kelas->kelas_id }}"
                                    {{ old('no_konsentrasi_id', isset($kelas) ? $kelas->kelas_id : '') == $kelas->kelas_id ? 'selected' : '' }}>
                                    {{ $kelas->no_konsentrasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="nis">NIS</label>
                        <input type="text" class="form-control" autocomplete="off" id="nis" name="nis"
                            required>
                    </div>
                    <div class="form-group row">
                        <label for="no_hp">No. HP</label>
                        <input type="text" class="form-control" autocomplete="off" id="no_hp" name="no_hp"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
