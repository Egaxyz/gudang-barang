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
                <form method="POST" action="{{ url('peminjaman/storeWithBarang') }}">
                    @csrf
                    <div id="method"></div>

                    <div class="form-group row">
                        <label for="nama_siswa">Siswa</label>
                        <select id="nama_siswa" name="siswa_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Siswa</option>
                            @foreach ($siswa as $user)
                                <option value="{{ $user->siswa_id }}"
                                    {{ old('siswa_id') == $user->siswa_id ? 'selected' : '' }}>
                                    {{ $user->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="nis">NIS</label>
                        <select id="nis" name="siswa_id" class="form-control" required>
                            <option value="" disabled selected>Pilih Siswa</option>
                            @foreach ($siswa as $user)
                                <option value="{{ $user->siswa_id }}"
                                    {{ old('siswa_id') == $user->siswa_id ? 'selected' : '' }}>
                                    {{ $user->nis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group row">
                        <label for="user_id">Nama Operator</label>
                        <select id="user_id" name="user_id" class="form-control">
                            <option value="" disabled selected>Pilih Operator</option>
                            @foreach ($pengguna as $user)
                                <option value="{{ $user->user_id }}"
                                    {{ old('user_id', isset($user) ? $user->user_id : '') == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->user_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="barang">Barang</label><br>
                        @foreach ($barang as $item)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="barang[{{ $loop->index }}][br_kode]" value="{{ $item->br_kode }}"
                                    id="barang_{{ $item->br_kode }}">
                                <input type="hidden" name="barang[{{ $loop->index }}][pdb_sts]" value="dipinjam">
                                <!-- Assuming status is always 'dipinjam' -->
                                <label class="form-check-label" for="barang_{{ $item->br_kode }}">
                                    {{ $item->br_kode }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="pb_harus_kembali_tgl">Tanggal Harus Kembali</label>
                        <input type="date" class="form-control" id="pb_harus_kembali_tgl" name="pb_harus_kembali_tgl"
                            required>
                    </div>

                    <div class="form-group row">
                        <label for="pb_stat">Status</label>
                        <select id="pb_stat" name="pb_stat" class="form-control">
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
