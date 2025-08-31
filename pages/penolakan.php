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
        <div class="card-header bg-dark-blue text-white d-flex align-items-center justify-content-center mb-4 form-title-card">
            <i class="fas fa-file-alt me-2"></i>
            <h4 class="mb-0 fw-bold"><?= $title ?></h4>
        </div>

        <form method="post" action="">
            <!-- Identitas Pasien -->
            <?= section("Identitas Pasien") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-12">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Informasi Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-user me-1"></i> Nama</label>
                                    <input type="text" class="form-control" name="nama_pasien">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-child me-1"></i> Umur</label>
                                    <input type="text" class="form-control" name="umur" placeholder="... bln/thn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-home me-1"></i> Alamat</label>
                                    <input type="text" class="form-control" name="alamat">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-venus-mars me-1"></i> Sex</label>
                                    <select class="form-select" name="sex">
                                        <option value="" disabled selected>Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-id-card me-1"></i> No Rekam Medis</label>
                                    <input type="text" class="form-control" name="no_rm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-calendar-check me-1"></i> Tanggal Kunjungan</label>
                                    <input type="date" class="form-control" name="tgl_kunjungan">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-clock me-1"></i> Jam Kunjungan</label>
                                    <input type="time" class="form-control" name="jam_kunjungan">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-door-open me-1"></i> Ruang</label>
                                    <input type="text" class="form-control" name="ruang">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-star me-1"></i> Kelas</label>
                                    <select class="form-select" name="kelas">
                                        <option value="" disabled selected>Pilih...</option>
                                        <option>III</option>
                                        <option>II</option>
                                        <option>I</option>
                                        <option>VIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokter / Informasi -->
            <?= section("Dokter / Informasi") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-12">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-user-md me-2"></i>
                            <h6 class="mb-0 fw-bold">Informasi Dokter</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-user-md me-1"></i> Dokter Pelaksana Tindakan</label>
                                    <input type="text" class="form-control" name="dokter_pelaksana">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-info-circle me-1"></i> Pemberi Informasi</label>
                                    <input type="text" class="form-control" name="pemberi_informasi">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-user-check me-1"></i> Penerima Informasi</label>
                                    <input type="text" class="form-control" name="penerima_informasi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Butir Informasi -->
            <?= section("Butir Informasi") ?>
            <div class="medical-table-container">
                <table class="table-medical">
                    <thead>
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
    <td class='label-col'>$b</td>
    <td class='input-col'><textarea class='form-control' rows='2' name='$name'></textarea></td>
    <td class='text-center' style='vertical-align: middle; padding: 8px;'>
        <div style='display: flex; justify-content: center; align-items: center; height: 100%;'>
            <input type='checkbox' class='form-check-input table-checkbox' name='check_$name' style='transform: scale(1.8); position: relative; opacity: 1; margin: 0;'>
        </div>
    </td>
</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pernyataan setelah Butir Informasi -->
            <?= section("Pernyataan Informasi") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-12">
                    <div class="card p-3 h-100 subjektif-card visible">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <h6 class="mb-0 fw-bold">Pernyataan Informasi</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                Dengan ini menyatakan bahwa saya telah menjelaskan hal-hal di atas secara benar dan jelas serta memberikan kesempatan untuk bertanya/diskusi kepada pasien dan/atau keluarganya sehingga telah memahaminya.
                            </p>
                            <div class="form-check mb-2 selectable-card">
                                <input class="form-check-input" type="checkbox" name="ttd_dokter" id="ttd_dokter">
                                <label class="form-check-label fw-bold card-content" for="ttd_dokter">
                                    Saya selaku <u>Dokter/Petugas</u> telah memberikan penjelasan.
                                </label>
                            </div>
                            <div class="form-check mb-2 selectable-card">
                                <input class="form-check-input" type="checkbox" name="ttd_pasien" id="ttd_pasien">
                                <label class="form-check-label fw-bold card-content" for="ttd_pasien">
                                    Saya selaku <u>Pasien/Keluarga</u> telah menerima informasi.
                                </label>
                            </div>
                            <p class="small fst-italic mt-3">
                                * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pernyataan Penolakan Tindakan Kedokteran -->
            <?= section("Pernyataan Penolakan Tindakan Kedokteran") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-6">
                    <div class="card p-3 h-100 subjektif-card visible">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="fas fa-ban me-2"></i>
                            <h6 class="mb-0 fw-bold">Identitas Penolak</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-user me-1"></i> Nama</label>
                                <input type="text" class="form-control subjektif-textarea" name="nama_penolakan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-home me-1"></i> Alamat</label>
                                <input type="text" class="form-control subjektif-textarea" name="alamat_penolakan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir</label>
                                <input type="date" class="form-control subjektif-textarea" name="tgl_lahir_penolakan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 h-100 subjektif-card visible">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="fas fa-ban me-2"></i>
                            <h6 class="mb-0 fw-bold">Detail Penolakan</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-notes-medical me-1"></i> Tindakan Medis yang Ditolak</label>
                                <input type="text" class="form-control subjektif-textarea" name="jenis_tindakan" placeholder="Tindakan medis yang ditolak">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-user me-1"></i> Terhadap</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="saya" value="Saya">
                                        <label class="form-check-label card-content" for="saya">Saya</label>
                                    </div>
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="anak" value="Anak">
                                        <label class="form-check-label card-content" for="anak">Anak</label>
                                    </div>
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="istri" value="Istri">
                                        <label class="form-check-label card-content" for="istri">Istri</label>
                                    </div>
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="suami" value="Suami">
                                        <label class="form-check-label card-content" for="suami">Suami</label>
                                    </div>
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="orang_tua" value="Orang Tua">
                                        <label class="form-check-label card-content" for="orang_tua">Orang Tua</label>
                                    </div>
                                    <div class="form-check selectable-card">
                                        <input class="form-check-input" type="radio" name="terhadap" id="lain_lain" value="Lain-lain">
                                        <label class="form-check-label card-content" for="lain_lain">Lain-lain</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-user me-1"></i> Nama Pasien yang Ditolak Tindakannya</label>
                                <input type="text" class="form-control subjektif-textarea" name="nama_tindakan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-home me-1"></i> Alamat Pasien</label>
                                <input type="text" class="form-control subjektif-textarea" name="alamat_tindakan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-info"><i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir Pasien</label>
                                <input type="date" class="form-control subjektif-textarea" name="tgl_lahir_tindakan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Akhir dengan Checkbox dan Tanggal -->
            <?= section("Pernyataan Akhir") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-6">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-signature me-2"></i>
                            <h6 class="mb-0 fw-bold">Pernyataan dan Persetujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2 selectable-card">
                                <input class="form-check-input" type="checkbox" name="penolakan_pasien" id="penolakan_pasien">
                                <label class="form-check-label fw-bold card-content" for="penolakan_pasien">
                                    Saya selaku <u>Pasien/Keluarga</u> menyatakan penolakan.
                                </label>
                            </div>
                            <div class="form-check mb-2 selectable-card">
                                <input class="form-check-input" type="checkbox" name="penolakan_perawat" id="penolakan_perawat">
                                <label class="form-check-label fw-bold card-content" for="penolakan_perawat">
                                    Saya selaku <u>Perawat</u> mengetahui.
                                </label>
                            </div>
                            <div class="form-check mb-2 selectable-card">
                                <input class="form-check-input" type="checkbox" name="penolakan_saksi" id="penolakan_saksi">
                                <label class="form-check-label fw-bold card-content" for="penolakan_saksi">
                                    Saya selaku <u>Saksi/Keluarga/Wali</u> menyetujui.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <h6 class="mb-0 fw-bold">Tanggal dan Jam</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-orange"><i class="fas fa-calendar-day me-1"></i> Tanggal</label>
                                <input type="date" class="form-control" name="tgl_surat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-orange"><i class="fas fa-clock me-1"></i> Jam</label>
                                <input type="time" class="form-control" name="jam_surat">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan Penolakan</button>
                <button type="button" class="btn btn-secondary">Cetak PDF</button>
            </div>
        </form>
    </div>
</div>

<?php include "../template/footer.php"; ?>