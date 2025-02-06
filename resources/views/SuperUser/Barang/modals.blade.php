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
                <form class="form-horizontal" method="POST" action="{{ url('barang') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group">
                        <label for="br_nama">Nama Barang</label>
                        <input type="text" autocomplete="off" placeholder="Masukkan Nama Barang" class="form-control"
                            id="br_nama" name="br_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="id_asal_br">Asal Barang</label>
                        <select id="id_asal_br" name="id_asal_br" class="form-control">
                            <option value="" disabled selected>Pilih Asal Barang</option>
                            @foreach ($asal_barang as $asal)
                                <option value="{{ $asal->id_asal_br }}"
                                    {{ old('id_asal_br', isset($barang) ? $barang->id_asal_br : '') == $asal->id_asal_br ? 'selected' : '' }}>
                                    {{ $asal->nama_perusahaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jns_brg_kode">Jenis Barang</label>
                        <select id="jns_brg_kode" name="jns_brg_kode" class="form-control">
                            <option value="" disabled selected>Pilih Jenis Barang</option>
                            @foreach ($jenis_barang as $jenis)
                                <option value="{{ $jenis->jns_brg_kode }}"
                                    {{ old('jns_brg_kode', isset($barang) ? $barang->jns_brg_kode : '') == $jenis->jns_brg_kode ? 'selected' : '' }}>
                                    {{ $jenis->jns_barang_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="br_tgl_terima">Tanggal Terima</label>
                        <input type="date" class="form-control" id="br_tgl_terima" name="br_tgl_terima" required>
                    </div>
                    <div class="form-group">
                        <label for="br_tgl_entry">Tanggal Entry</label>
                        <input type="date" class="form-control" id="br_tgl_entry" name="br_tgl_entry" required>
                    </div>
                    <div class="form-group">
                        <label for="br_status">Status Barang</label>
                        <select id="br_status" name="br_status" class="form-control">
                            <option value="1">Baik</option>
                            <option value="2">Rusak (Bisa Diperbaiki)</option>
                            <option value="3">Rusak (Tidak Bisa Digunakan)</option>
                            <option value="0">Dihapus dari Sistem</option>
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
