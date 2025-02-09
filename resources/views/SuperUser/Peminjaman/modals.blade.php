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
                        <div class="form-group">
                            <label for="siswa">Pilih Siswa</label>
                            <div class="input-group">
                                <input type="text" id="nis_display" class="form-control"
                                    placeholder="Klik untuk memilih siswa" readonly data-toggle="modal"
                                    data-target="#siswaModal">
                                <input type="hidden" id="siswa_id" name="siswa_id">
                            </div>
                        </div>

                        <div id="selectedSiswaList" class="mt-2"></div>

                        <div class="form-group">
                            <label for="barang">Pilih Barang</label>
                            <div class="input-group">
                                <input type="text" id="barang_display" class="form-control"
                                    placeholder="Klik untuk memilih barang" readonly data-toggle="modal"
                                    data-target="#barangModal">
                            </div>
                            <div id="selectedBarangList" class="mt-2"></div> <!-- Badge akan ditampilkan di sini -->
                            <div id="barangIdsContainer"></div>
                        </div>

                        <!-- Tanggal Harus Kembali -->
                        <div class="form-group">
                            <label for="pb_harus_kembali_tgl">Tanggal Harus Kembali</label>
                            <input type="date" class="form-control" id="pb_harus_kembali_tgl"
                                name="pb_harus_kembali_tgl" required>
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

    <div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="siswaModalLabel"
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
                    <input type="text" id="searchBarang" class="form-control mb-3"
                        placeholder="Cari Kode Barang atau Nama Barang" onkeyup="filterBarang()">
                    <div id="barangList">
                        @foreach ($barang as $item)
                            <button type="button" class="list-group-item list-group-item-action btn "
                                onclick="selectBarang('{{ $item->br_kode }}', '{{ $item->br_nama }}', '{{ isset($item->detail) ? $item->detail->pdb_sts : 'Tersedia' }}', this)">
                                <strong>{{ $item->br_kode }}</strong> - {{ $item->br_nama }} <span
                                    class="status-barang 
        {{ isset($item->detail) && $item->detail->pdb_sts === 'dipinjam' ? 'badge-danger' : 'badge-success' }} 
        float-right">
                                    {{ isset($item->detail) ? $item->detail->pdb_sts : 'Tersedia' }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        let selectedBarang = []; // Array untuk menyimpan barang yang dipilih

        function selectBarang(br_kode, br_nama, pdb_sts, btn) {
            if (pdb_sts === "dipinjam") {
                alert("Barang ini sedang dipinjam dan tidak bisa dipilih.");
                return;
            }

            if (selectedBarang.some(item => item.br_kode === br_kode)) {
                alert("Barang sudah dipilih.");
                return;
            }

            selectedBarang.push({
                br_kode,
                br_nama
            });

            let barangIdsContainer = document.getElementById("barangIdsContainer");
            let inputHidden = document.createElement("input");
            inputHidden.type = "hidden";
            inputHidden.name = `barang[${selectedBarang.length - 1}][br_kode]`;
            inputHidden.value = br_kode;
            barangIdsContainer.appendChild(inputHidden);

            updateSelectedBarangList();

            btn.classList.add("barang-dipilih");

        }

        function removeBarang(br_kode) {
            selectedBarang = selectedBarang.filter(item => item.br_kode !== br_kode);
            updateSelectedBarangList();

            let barangButtons = document.querySelectorAll("#barangList .list-group-item");
            barangButtons.forEach(btn => {
                if (btn.textContent.includes(br_kode)) {
                    btn.classList.remove("barang-dipilih");
                }
            });

            // Hapus input hidden yang sesuai
            let barangIdsContainer = document.getElementById("barangIdsContainer");
            let hiddenInputs = barangIdsContainer.querySelectorAll("input[type='hidden']");
            hiddenInputs.forEach(input => {
                if (input.value === br_kode) {
                    barangIdsContainer.removeChild(input);
                }
            });
        }

        function updateSelectedBarangList() {
            let selectedBarangList = document.getElementById("selectedBarangList");
            selectedBarangList.innerHTML = selectedBarang.map(item => {
                return `<span class="selected-barang">${item.br_kode} - ${item.br_nama} 
                    <button onclick="removeBarang('${item.br_kode}')">X</button></span>`;
            }).join("");
        }

        function updateBarangStatus() {
            let items = document.querySelectorAll("#barangList .list-group-item");
            items.forEach(item => {
                let status = item.querySelector("span").textContent.trim();
                if (status === "dipinjam") {
                    item.classList.add("disabled");
                } else {
                    item.classList.remove("disabled");
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            updateBarangStatus();
        });
    </script>

    <style>
        .selected-barang {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 5px;
            display: inline-flex;
            align-items: center;
        }

        .selected-barang button {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            margin-left: 5px;
            cursor: pointer;
        }

        .disabled {
            background-color: #d3d3d3 !important;
            color: #6c757d;
            cursor: grab;
        }

        .barang-dipilih {
            background-color: #007bff !important;
            margin: 3px;
            color: white !important;
        }

        .status-barang {
            display: inline-block;
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 12px;
        }

        .badge-danger {
            background-color: red;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .float-right {
            float: right;
        }
    </style>
