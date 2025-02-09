<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('pengembalian') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="pb_id">Peminjaman</label>
                        <select id="pb_id" name="pb_id" class="form-control">
                            <option value="" disabled selected>Pilih Peminjaman</option>
                            @foreach ($peminjaman as $peminjaman)
                                <option value="{{ $peminjaman->pb_id }}"
                                    {{ old('pb_id', isset($peminjaman) ? $peminjaman->pb_id : '') == $peminjaman->pb_id ? 'selected' : '' }}>
                                    {{ $peminjaman->pb_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kembali_tgl">Kembali Tanggal</label>
                        <input type="date" class="form-control" id="kembali_tgl" name="kembali_tgl" required>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="kembali_sts">Status</label>
                        <select id="kembali_sts" name="kembali_sts" class="form-control">
                            <option value="0" selected>Aktif</option>
                            <option value="1">Tidak Aktif</option>
                        </select>
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
