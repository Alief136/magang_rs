<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$title = "Form Resume Medis (Discharge Summary)";
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
            <?= section("Identitas Pasien") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Pasien</label>
                    <input type="text" class="form-control" name="nama_pasien">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_input">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="2"></textarea>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Sex</label>
                    <select class="form-select" name="sex">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Umur</label>
                    <input type="text" class="form-control" name="umur" id="umur_input" placeholder="th/bln" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">No. Rekam Medis</label>
                    <input type="text" class="form-control" name="no_rm">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Ruang</label>
                    <input type="text" class="form-control" name="ruang">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Kelas</label>
                    <select class="form-select" name="kelas">
                        <option>III</option>
                        <option>II</option>
                        <option>I</option>
                        <option>VIP</option>
                    </select>
                </div>
            </div>

            <?= section("Informasi Medis") ?>
            <table class="table table-bordered align-middle">
                <tbody>
                    <?php
                    $informasiMedis = [
                        "Indikasi Rawat Inap",
                        "Keluhan Lain",
                        "Riwayat Penyakit Dahulu",
                        "Riwayat Keluarga",
                        "Pemeriksaan Fisik",
                        "Laboratorium",
                        "Radiologi",
                        "Pemeriksaan Lain-lain",
                        "Diagnosa",
                        "Tata Laksana (Medikamentosa Saat Perawatan)",
                        "Tata Laksana (Medikamentosa Saat Pulang)"
                    ];
                    foreach ($informasiMedis as $im) {
                        $name = strtolower(str_replace([' ', '(', ')', '-'], ['_', '', '', ''], $im));
                        echo "
                        <tr>
                            <td style='width:30%;' class='fw-bold'>$im</td>
                            <td><textarea class='form-control' rows='2' name='$name'></textarea></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?= section("Keadaan & Cara Keluar RS") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Keadaan Waktu Keluar RS</label>
                    <select class="form-select" name="keadaan_keluar">
                        <option>Sembuh</option>
                        <option>Membaik</option>
                        <option>Belum Sembuh</option>
                        <option>Cacat</option>
                        <option>Meninggal < 48 jam</option>
                        <option>Meninggal > 48 jam</option>
                        <option>Lain-lain</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Cara Keluar RS</label>
                    <select class="form-select" name="cara_keluar">
                        <option>Diijinkan Pulang</option>
                        <option>Pulang atas Permintaan Sendiri</option>
                        <option>Pulang tanpa pemberitahuan</option>
                        <option>Dirujuk ke RS lain</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Prognosis</label>
                <textarea class="form-control" name="prognosis"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sebab Meninggal (jika ada)</label>
                <textarea class="form-control" name="sebab_meninggal"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Instruksi Tindak Lanjut</label>
                <textarea class="form-control" name="instruksi"></textarea>
            </div>

            <?= section("Tanda Tangan") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pasien / Keluarga</label>
                    <input type="text" class="form-control" name="ttd_pasien">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Dokter Penanggung Jawab (DPJP)</label>
                    <input type="text" class="form-control" name="ttd_dpjp">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/main.js"></script>

<?php include "../template/footer.php"; ?>