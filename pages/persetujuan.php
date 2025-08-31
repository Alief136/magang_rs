<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$title = "Form Persetujuan Tindakan Kedokteran Anestesi";
include "../template/header.php";

// Helper section
function section($title)
{
    return "<h5 class='mt-4 mb-3 fw-bold border-bottom pb-2'>$title</h5>";
}
?>

<div class="container my-4">
    <div class="card shadow p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-decoration-underline"><?= $title ?></h4>
        </div>

        <form method="post" action="">
            <!-- Identitas Pasien -->
            <?= section("Identitas Pasien") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" class="form-control" name="nama_pasien">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Umur</label>
                    <input type="text" class="form-control" name="umur" placeholder="th/bln">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat</label>
                    <input type="text" class="form-control" name="alamat">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sex</label>
                    <select class="form-select" name="sex">
                        <option value="">-- pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">No Rekam Medis</label>
                    <input type="text" class="form-control" name="no_rm">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Kunjungan</label>
                    <input type="date" class="form-control" name="tgl_kunjungan">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jam Kunjungan</label>
                    <input type="time" class="form-control" name="jam_kunjungan">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Ruang</label>
                    <input type="text" class="form-control" name="ruang">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kelas</label>
                    <select class="form-select" name="kelas">
                        <option>III</option>
                        <option>II</option>
                        <option>I</option>
                        <option>VIP</option>
                    </select>
                </div>
            </div>

            <!-- Dokter / Informasi -->
            <?= section("Dokter / Informasi") ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Dokter Pelaksana Tindakan</label>
                    <input type="text" class="form-control" name="dokter_pelaksana">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Pemberi Informasi</label>
                    <input type="text" class="form-control" name="pemberi_informasi">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Penerima Informasi</label>
                    <input type="text" class="form-control" name="penerima_informasi">
                </div>
            </div>

            <!-- Butir Informasi -->
            <?= section("Butir Informasi") ?>
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:30%">Jenis Informasi</th>
                        <th>Isi Informasi</th>
                        <th style="width:10%">Tanda (✔)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $butir = [
                        "Diagnosis (WD & DD)",
                        "Dasar Diagnosis",
                        "Tindakan Kedokteran",
                        "Indikasi Tindakan",
                        "Tata Cara",
                        "Tujuan",
                        "Risiko",
                        "Komplikasi",
                        "Prognosis",
                        "Alternatif & Risiko",
                        "Lain-lain"
                    ];
                    $no = 1;
                    foreach ($butir as $b) {
                        $name = strtolower(str_replace([' ', '(', ')', '&', '-'], ['_', '', '', '_', ''], $b));
                        echo "
                        <tr>
                            <td class='text-center'>$no</td>
                            <td>$b</td>
                            <td><textarea class='form-control' rows='2' name='$name'></textarea></td>
                            <td class='text-center'><input type='checkbox' name='check_$name'></td>
                        </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pernyataan setelah Butir Informasi (Checkbox) -->
            <div class="mb-4">
                <p>
                    Dengan ini menyatakan bahwa saya telah menjelaskan hal-hal di atas secara benar dan jelas serta memberikan kesempatan untuk bertanya/diskusi kepada pasien dan/atau keluarganya sehingga telah memahaminya.
                </p>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="ttd_dokter" id="ttd_dokter">
                    <label class="form-check-label fw-bold" for="ttd_dokter">
                        Saya selaku <u>Dokter/Petugas</u> telah memberikan penjelasan.
                    </label>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="ttd_pasien" id="ttd_pasien">
                    <label class="form-check-label fw-bold" for="ttd_pasien">
                        Saya selaku <u>Pasien/Keluarga</u> telah menerima informasi.
                    </label>
                </div>

                <p class="small fst-italic mt-3">
                    * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.
                </p>
            </div>

            <!-- Persetujuan Anestesi -->
            <div class="mb-3">
                <label class="form-label fw-bold">Yang bertanda tangan di bawah ini saya</label>
            </div>

            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:150px;">Nama :</p>
                <input type="text" class="form-control" name="nama_persetujuan">
            </div>

            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:150px;">Alamat :</p>
                <input type="text" class="form-control" name="alamat_persetujuan">
            </div>

            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:150px;">Tanggal Lahir :</p>
                <input type="date" class="form-control" name="tgl_lahir_persetujuan">
            </div>


            <!-- Pasien yang ditindak -->
            <div class="mb-3">
                <label class="form-label fw-bold">
                    Dengan ini menyatakan PERSETUJUAN untuk dilakukannya tindakan anestesi terhadap:
                </label>
            </div>

            <div class="d-flex flex-wrap gap-3 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="saya" value="Saya">
                    <label class="form-check-label" for="saya">Saya</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="anak" value="Anak">
                    <label class="form-check-label" for="anak">Anak</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="istri" value="Istri">
                    <label class="form-check-label" for="istri">Istri</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="suami" value="Suami">
                    <label class="form-check-label" for="suami">Suami</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="orang_tua" value="Orang Tua">
                    <label class="form-check-label" for="orang_tua">Orang Tua</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="terhadap" id="lain_lain" value="Lain-lain">
                    <label class="form-check-label" for="lain_lain">Lain-lain</label>
                </div>
            </div>


            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:220px;">Nama Pasien yang ditindak :</p>
                <input type="text" class="form-control" name="nama_tindakan">
            </div>

            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:220px;">Alamat Pasien yang ditindak :</p>
                <input type="text" class="form-control" name="alamat_tindakan">
            </div>

            <div class="mb-3 d-flex align-items-center">
                <p class="form-label me-2" style="min-width:220px;">Tanggal Lahir Pasien yang ditindak :</p>
                <input type="date" class="form-control" name="tgl_lahir_tindakan">
            </div>

            <!-- Bagian akhir dengan checkbox sebagai pengganti tanda tangan -->
            <div class="mt-4 d-flex justify-content-between align-items-start">
                <!-- Checkbox sisi kiri -->
                <div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="setuju_pasien" id="setuju_pasien">
                        <label class="form-check-label fw-bold" for="setuju_pasien">
                            Saya selaku <u>Pasien/Keluarga</u> menyatakan persetujuan.
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="setuju_saksi" id="setuju_saksi">
                        <label class="form-check-label fw-bold" for="setuju_saksi">
                            Saya selaku <u>Saksi/Keluarga/Wali</u> menyetujui.
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="setuju_perawat" id="setuju_perawat">
                        <label class="form-check-label fw-bold" for="setuju_perawat">
                            Saya selaku <u>Perawat</u> mengetahui.
                        </label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="setuju_dokter" id="setuju_dokter">
                        <label class="form-check-label fw-bold" for="setuju_dokter">
                            Saya selaku <u>Dokter</u> menyetujui.
                        </label>
                    </div>
                </div>

                <!-- Tanggal & Jam sisi kanan -->
                <div class="text-end">
                    <p>
                        Jombang, <input type="date" name="tgl_surat"> <br>
                        Jam <input type="time" name="jam_surat"> WIB
                    </p>
                </div>
            </div>


            <!-- Tombol -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary">Cetak PDF</button>
            </div>
        </form>
    </div>
</div>

<?php include "../template/footer.php"; ?>