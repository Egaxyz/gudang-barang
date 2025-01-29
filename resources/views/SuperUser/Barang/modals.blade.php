{{-- <form class="form-horizontal" method="post">
    @csrf
    <div class="form-group row">
        <label for="id_asal_br" class="col-sm-2 col-form-label">Asal Barang</label>
        <div class="col-sm-10">
            <select name="id_asal_br" id="id_asal_br" class="form-control">
                <option value="" disabled selected>Pilih Asal Barang</option>
                @foreach ($asal_barang as $asal)
                    <option value="{{ $asal->id }}">{{ $asal->nama_asal_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="jns_brg_kode" class="col-sm-2 col-form-label">Jenis Barang</label>
        <div class="col-sm-10">
            <select name="jns_brg_kode" id="jns_brg_kode" class="form-control">
                <option value="" disabled selected>Pilih Jenis Barang</option>
                @foreach ($jenis_barang as $jenis)
                    <option value="{{ $jenis->kode }}">{{ $jenis->nama_jenis_barang }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="br_status" class="col-sm-2 col-form-label">Status Barang</label>
        <div class="col-sm-10">
            <select name="br_status" id="br_status" class="form-control">
                <option value="0">Tidak Aktif</option>
                <option value="1">Aktif</option>
            </select>
        </div>
    </div>

    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form> --}}
