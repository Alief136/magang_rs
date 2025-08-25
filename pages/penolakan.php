<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$title = "Form Penolakan Tindakan Kedokteran";
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
                    <input type="date" class="form-control" name="tgl_lahir_pasien">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat</label>
                    <input type="text" class="form-control" name="alamat_pasien">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">No. Rekam Medis</label>
                    <input type="text" class="form-control" name="no_rm">
                </div>
            </div>

            <?= section("Informasi Penolakan") ?>
            <div class="mb-3">
                <label class="form-label fw-bold">Tindakan Kedokteran yang Ditolak</label>
                <input type="text" class="form-control" name="tindakan_ditolak">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Alasan Penolakan</label>
                <textarea class="form-control" name="alasan" rows="3"></textarea>
            </div>

            <?= section("Yang Menyatakan") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" class="form-control" name="penolak_nama">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Hubungan dengan Pasien</label>
                    <select class="form-select" name="hubungan">
                        <option value="Pasien">Pasien Sendiri</option>
                        <option value="Orangtua">Orang Tua</option>
                        <option value="Anak">Anak</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tanggal & Jam</label>
                    <input type="datetime-local" class="form-control" name="tgl_jam">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Saksi</label>
                    <input type="text" class="form-control" name="saksi">
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary">Cetak PDF</button>
            </div>
        </form>
    </div>
</div>

<?php include "../template/footer.php"; ?>