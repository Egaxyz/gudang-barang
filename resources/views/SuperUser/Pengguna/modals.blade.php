<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ url('/superuser/pengguna') }}">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label for="user_nama">Nama Pengguna</label>
                        <input type="text" class="form-control" autocomplete="off" id="user_nama" name="user_nama"
                            required>
                    </div>
                    <div class="form-group row" id="passwordField">
                        <label for="user_pass">Password</label>
                        <input type="password" class="form-control" autocomplete="off" id="user_pass" name="user_pass"
                            required>
                    </div>
                    <div class="form-group row">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="superuser">SuperUser</option>
                            <option value="admin">Admin</option>
                            <option value="user">User/Operator</option>
                        </select>

                    </div>
                    <div class="form-group row">
                        <label for="user_sts">Status Akun</label>
                        <select id="user_sts" name="user_sts" class="form-control">
                            <option value="1" selected>Aktif</option>
                            <option value="2">Tidak Aktif</option>
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
