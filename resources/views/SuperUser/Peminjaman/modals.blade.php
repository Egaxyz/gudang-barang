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

                    <!-- Pilih Siswa -->
                    <div class="form-group">
                        <label for="nis">Pilih Siswa</label>
                        <div class="input-group">
                            <input type="text" id="nis_display" class="form-control"
                                placeholder="Klik untuk memilih siswa" readonly>
                            <input type="hidden" id="siswa_id" name="siswa_id">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#siswaModal">Cari</button>
                            </div>
                        </div>
                        <div id="selectedSiswaList" class="mt-2"></div> <!-- Display selected siswa here -->
                    </div>

                    <!-- Pilih Barang -->
                    <div class="form-group">
                        <label for="barang">Barang</label>
                        <div class="input-group">
                            <input type="text" id="barang_display" class="form-control"
                                placeholder="Klik untuk memilih barang" readonly>
                            <input type="hidden" id="barang_input" name="barang">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#barangModal">Cari</button>
                            </div>
                        </div>
                        <div id="selectedBarangList" class="mt-2"></div> <!-- Display selected barang here -->
                    </div>

                    <!-- Tanggal Harus Kembali -->
                    <div class="form-group">
                        <label for="pb_harus_kembali_tgl">Tanggal Harus Kembali</label>
                        <input type="date" class="form-control" id="pb_harus_kembali_tgl" name="pb_harus_kembali_tgl"
                            required>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
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

<!-- Modal Pencarian Siswa -->
<div class="modal fade" id="siswaModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchSiswa" class="form-control mb-3"
                    placeholder="Cari NIS atau Identitas Siswa" onkeyup="filterSiswa()">
                <div id="siswaList">
                    @foreach ($siswa as $user)
                        <div class="list-group">
                            <button type="button" class="list-group-item list-group-item-action"
                                onclick="selectSiswa('{{ $user->siswa_id }}', '{{ $user->nis }}', '{{ $user->nama_siswa }}', '{{ $user->kelasData->tingkatan }}','{{ $user->jurusanData->jurusan }}', '{{ $user->kelasData->konsentrasi }}', '{{ $user->kelasData->no_konsentrasi }}' )">
                                <strong>{{ $user->nis }}</strong> - {{ $user->nama_siswa }} -
                                {{ $user->kelasData->tingkatan }} {{ $user->jurusanData->jurusan }}
                                {{ $user->kelasData->konsentrasi }} {{ $user->kelasData->no_konsentrasi }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pencarian Barang -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchBarang" class="form-control mb-3" placeholder="Cari Barang..."
                    onkeyup="filterBarang()">
                <div id="barangList" class="list-group">
                    @foreach ($barang as $item)
                        <div
                            class="list-group-item d-flex align-items-center justify-content-between
                            {{ $item->pdb_sts == 1 ? 'disabled-item' : '' }}">
                            <input type="checkbox" id="checkbox_{{ $item->br_kode }}" class="mr-2"
                                {{ $item->pdb_sts == 1 ? 'disabled' : '' }}
                                onclick="{{ $item->pdb_sts == 1 ? 'return false;' : '' }}"
                                onchange="toggleBarangSelection('{{ $item->br_kode }}', '{{ $item->br_nama }}', this)">
                            <span class="font-weight-bold">{{ $item->br_kode }} - {{ $item->br_nama }}</span>
                            <span class="badge {{ $item->pdb_sts == 1 ? 'badge-danger' : 'badge-success' }}">
                                {{ $item->pdb_sts == 1 ? 'Dipinjam' : 'Tersedia' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .disabled-item {
        cursor: not-allowed;
        /* Change cursor to indicate disabled */
        opacity: 0.6;
        /* Make it look disabled */
    }
</style>

<script>
    function filterBarang() {
        let input = document.getElementById("searchBarang").value.toLowerCase(); // Get the search input
        let items = document.querySelectorAll("#barangList .list-group-item"); // Get all barang items
        items.forEach(item => {
            // Get the text content of the item
            let text = item.textContent.toLowerCase();
            // Show or hide the item based on the search input
            item.style.display = text.includes(input) ? "" : "none";
        });
    }

    function toggleBarangSelection(br_kode, br_nama, checkbox) {
        let barangInput = document.getElementById("barang_input");
        let barangDisplay = document.getElementById("barang_display");
        let selectedBarangList = document.getElementById("selectedBarangList");

        if (checkbox.checked) {
            // Add the selected barang to the hidden input and display
            if (!barangInput.value.includes(br_kode)) {
                // Update the hidden input
                barangInput.value += (barangInput.value ? ',' : '') + br_kode;
                // Update the display
                barangDisplay.value += (barangDisplay.value ? ', ' : '') + br_nama;
                // Add to selected list
                selectedBarangList.innerHTML += `<span class="badge badge-info mr-1">${br_nama}</span>`;
            }
        } else {
            // Remove the unselected barang from the hidden input and display
            barangInput.value = barangInput.value.split(',').filter(item => item !== br_kode).join(',');
            barangDisplay.value = barangDisplay.value.split(', ').filter(item => item !== br_nama).join(', ');
            selectedBarangList.innerHTML = selectedBarangList.innerHTML.split('<span class="badge badge-info mr-1">')
                .filter(item => item !== `${br_nama}</span>`).join('');
        }
    }

    function selectBarang(br_kode, br_nama) {
        // Add the selected barang to the hidden input and display
        let barangInput = document.getElementById("barang_input");
        let barangDisplay = document.getElementById("barang_display");
        let selectedBarangList = document.getElementById("selectedBarangList");

        // Check if the barang is already selected
        if (!barangInput.value.includes(br_kode)) {
            // Update the hidden input
            barangInput.value += (barangInput.value ? ',' : '') + br_kode;
            // Update the display
            barangDisplay.value += (barangDisplay.value ? ', ' : '') + br_nama;
            // Add to selected list
            selectedBarangList.innerHTML += `<span class="badge badge-info mr-1">${br_nama}</span>`;
        }

        // Optionally, you can close the modal after selection
        $("#barangModal").modal("hide");
    }

    function filterSiswa() {
        let input = document.getElementById("searchSiswa").value.toLowerCase(); // Get the search input
        let items = document.querySelectorAll("#siswaList .list-group-item"); // Get all siswa items
        items.forEach(item => {
            // Get the text content of the item
            let text = item.textContent.toLowerCase();
            // Show or hide the item based on the search input
            item.style.display = text.includes(input) ? "" : "none";
        });
    }


    function selectSiswa(siswa_id, nis, nama, tingkatan, jurusan, konsentrasi, no_konsentrasi) {
        // Add the selected siswa to the hidden input and display
        let siswaInput = document.getElementById("siswa_id");
        let siswaDisplay = document.getElementById("nis_display");
        let selectedSiswaList = document.getElementById("selectedSiswaList");

        // Update the hidden input
        siswaInput.value = siswa_id;
        // Update the display
        siswaDisplay.value = `${nis} - ${nama}`;
        // Add to selected list

        // Optionally, you can close the modal after selection
        $("#siswaModal").modal("hide");
    }
</script>
