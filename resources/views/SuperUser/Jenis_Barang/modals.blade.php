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
                <form class="form-horizontal" method="POST" action="{{ url('jenis-barang') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="jns_barang_nama">Nama Jenis Barang</label>
                        <input type="text" class="form-control" autocomplete="off" id="jns_barang_nama"
                            name="jns_barang_nama" required>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_entry">Tanggal Entry</label>
                        <input type="date" class="form-control" id="tgl_entry" name="tgl_entry" required>
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
