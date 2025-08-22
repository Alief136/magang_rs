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

        <!-- Identitas Pasien -->
        <?= section("Identitas Pasien") ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Sex</label>
                <select class="form-select">
                    <option value="">-- pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Umur</label>
                <input type="text" class="form-control" placeholder="th/bln">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" rows="2"></textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Tanggal Lahir</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">No Rekam Medis</label>
                <input type="text" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Tanggal Kunjungan</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Jam Kunjungan</label>
                <input type="time" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Ruang</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Kelas</label>
                <select class="form-select">
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
                <label class="form-label fw-bold">Dokter Pelaksana</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Pemberi Informasi</label>
                <input type="text" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Penerima Informasi</label>
                <input type="text" class="form-control">
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
                    <th style="width:10%">✔</th>
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
                    echo "
          <tr>
            <td class='text-center'>$no</td>
            <td>$b</td>
            <td><textarea class='form-control' rows='2'></textarea></td>
            <td class='text-center'><input type='checkbox'></td>
          </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>

        <!-- Pernyataan Persetujuan -->
        <?= section("Pernyataan Persetujuan") ?>
        <div class="mb-3">
            <label class="form-label fw-bold">Nama</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Alamat</label>
            <textarea class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Tanggal Lahir</label>
            <input type="date" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Jenis Anestesi</label>
            <textarea class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Dengan ini menyatakan <strong>PERSETUJUAN</strong> untuk dilakukannya tindakan anestesi terhadap :</label>
            <div class="d-flex flex-wrap gap-3">
                <?php
                $opsi = ["Saya", "Anak", "Istri", "Suami", "Orang Tua", "Lain-lain"];
                foreach ($opsi as $i => $o) {
                    $id = strtolower(str_replace(" ", "_", $o));
                    echo "
          <div class='form-check'>
            <input class='form-check-input' type='radio' name='terhadap' id='$id' value='$o'>
            <label class='form-check-label' for='$id'>$o</label>
          </div>";
                }
                ?>
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center mt-4">
            <button class="btn btn-primary">Simpan</button>
            <button class="btn btn-secondary">Cetak PDF</button>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>