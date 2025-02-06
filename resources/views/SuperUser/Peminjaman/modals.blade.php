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
                        <div id="selectedSiswaList" class="mt-2"></div>
                    </div>

                    <!-- Pilih Barang -->
                    <div class="form-group">
                        <label for="barang">Pilih Barang</label>
                        <div class="input-group">
                            <div class="input-group">
                                <input type="text" id="barang_display" class="form-control"
                                    placeholder="Klik untuk memilih barang" readonly>
                                <input type="hidden" id="barang_ids" name="barang_ids[]">
                                <!-- Menggunakan array untuk menyimpan br_kode -->
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#barangModal">Cari</button>
                                </div>
                            </div>
                            <div id="selectedBarangList" class="mt-2"></div> <!-- B
                            <!-- This will display selected barang -->
                            <div id="barangIdsContainer"></div> <!-- This will hold hidden input fields -->
                        </div>
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
                <div id="barangList">
                    @foreach ($barang as $item)
                        <div class="list-group">
                            <label class="list-group-item">
                                <input type="checkbox" class="barang-checkbox" value="{{ $item->br_kode }}"
                                    onchange="updateSelectedBarang(this, '{{ $item->br_nama }}')">
                                <strong>{{ $item->br_kode }}</strong> - {{ $item->br_nama }}
                            </label>
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
        opacity: 0.6;
    }

    .selected-item {
        background-color: #007bff;
        color: white;
    }

    .selected-barang {
        background-color: #28a745;
        /* Warna hijau untuk barang yang dipilih */
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-right: 5px;
    }
</style>

<script>
    function filterSiswa() {
        let input = document.getElementById("searchSiswa").value.toLowerCase();
        let items = document.querySelectorAll("#siswaList .list-group-item");
        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? "" : "none";
        });
    }

    function selectSiswa(siswa_id, nis, nama, tingkatan, jurusan, konsentrasi, no_konsentrasi) {
        let siswaInput = document.getElementById("siswa_id");
        let siswaDisplay = document.getElementById("nis_display");
        let selectedSiswaList = document.getElementById("selectedSiswaList");

        siswaInput.value = siswa_id;
        siswaDisplay.value = `${nis} - ${nama} ${tingkatan} ${jurusan} ${konsentrasi} ${no_konsentrasi}`;
        $("#siswaModal").modal("hide");
    }

    function filterBarang() {
        let input = document.getElementById("searchBarang").value.toLowerCase();
        let items = document.querySelectorAll("#barangList .list-group-item");
        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? "" : "none";
        });
    }

    function updateSelectedBarang(checkbox, br_nama) {
        let selectedBarangList = document.getElementById("selectedBarangList");
        let selectedBarang = [];

        // Get existing selected barang from hidden input fields
        let currentSelectedBarang = Array.from(selectedBarangList.getElementsByClassName("selected-barang"));
        currentSelectedBarang.forEach(item => {
            selectedBarang.push({
                br_kode: item.getAttribute("data-br_kode"),
                br_nama: item.innerText.trim()
            });
        });

        if (checkbox.checked) {
            // Add selected item to the list
            selectedBarang.push({
                br_kode: checkbox.value,
                br_nama: br_nama
            });
            selectedBarangList.innerHTML +=
                `<span class="badge badge-info mr-1 selected-barang" data-br_kode="${checkbox.value}">${br_nama}</span>`;
        } else {
            // Remove item from the list
            selectedBarang = selectedBarang.filter(item => item.br_kode !== checkbox.value);
            selectedBarangList.innerHTML = selectedBarang.map(item => {
                return `<span class="badge badge-info mr-1 selected-barang" data-br_kode="${item.br_kode}">${item.br_nama}</span>`;
            }).join('');
        }

        // Update hidden inputs for each selected barang
        let barangInputsHtml = selectedBarang.map((item, index) => {
            return `<input type="hidden" name="barang[${index}][br_kode]" value="${item.br_kode}">`;
        }).join('');

        document.getElementById('barangIdsContainer').innerHTML = barangInputsHtml;

        // Update the display input for barang
        let barangDisplay = document.getElementById("barang_display");
        barangDisplay.value = selectedBarang.map(item => item.br_nama).join(', ');
    }
</script>
