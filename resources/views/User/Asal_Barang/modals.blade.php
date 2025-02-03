<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ url('asal-barang') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" class="form-control" autocomplete="off" id="nama_perusahaan"
                            name="nama_perusahaan" required>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah_kirim">Jumlah Kirim</label>
                        <input type="text" class="form-control" autocomplete="off" id="jumlah_kirim"
                            name="jumlah_kirim" required>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_kirim">Tanggal Kirim</label>
                        <input type="date" class="form-control" id="tgl_kirim" name="tgl_kirim" required>
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
