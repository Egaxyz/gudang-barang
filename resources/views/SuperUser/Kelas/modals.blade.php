<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ url('kelas') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="tingkatan">Tingkatan</label>
                        <select id="tingkatan" name="tingkatan" class="form-control">
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="jurusan_id">Jurusan</label>
                        <select id="jurusan_id" name="jurusan_id" class="form-control">
                            <option value="" disabled selected>Pilih Jurusan</option>
                            @foreach ($jurusan as $jurusan)
                                <option value="{{ $jurusan->jurusan_id }}"
                                    {{ old('jurusan_id', isset($jurusan) ? $jurusan->jurusan_id : '') == $jurusan->jurusan_id ? 'selected' : '' }}>
                                    {{ $jurusan->jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="konsentrasi">konsentrasi</label>
                        <input type="text" class="form-control" autocomplete="off" id="konsentrasi"
                            name="konsentrasi" required>
                    </div>
                    <div class="form-group row">
                        <label for="no_konsentrasi">No Konsentrasi</label>
                        <input type="text" class="form-control" autocomplete="off" id="no_konsentrasi"
                            name="no_konsentrasi" required>
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
