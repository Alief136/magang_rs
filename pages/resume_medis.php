<link rel="stylesheet" href="../assets/css/style.css">

<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$title = "RESUME MEDIS (DISCHARGE SUMMARY)";
include "../template/header.php";

// Helper section
function section($title)
{
    return "<h5 class='mt-4 mb-3 fw-bold border-bottom pb-2'>$title</h5>";
}
?>

<div class="container my-4">
    <div class="card shadow p-4 form-title-card visible">
        <div class="card-header bg-dark-blue text-white d-flex align-items-center justify-content-center mb-4">
            <i class="fas fa-file-medical me-2"></i>
            <h4 class="mb-0 fw-bold"><?= htmlspecialchars($title) ?></h4>
        </div>

        <form class="needs-validation" novalidate>
            <!-- Identitas Pasien -->
            <?= section("Identitas Pasien") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Informasi Pribadi -->
                <div class="col-md-12">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Informasi Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-user me-1"></i> Nama Pasien</label>
                                    <input type="text" class="form-control" name="nama_pasien" required>
                                    <div class="invalid-feedback">Nama pasien wajib diisi.</div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-venus-mars me-1"></i> Jenis Kelamin</label>
                                    <select class="form-select" name="sex" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-id-card me-1"></i> No. Rekam Medis</label>
                                    <input type="text" class="form-control" name="no_rm" maxlength="8" style="font-family: monospace; letter-spacing: 1px;" required>
                                    <div class="invalid-feedback">No. Rekam Medis wajib diisi.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_input" required>
                                    <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-child me-1"></i> Umur</label>
                                    <input type="text" class="form-control" name="umur" id="umur_input" placeholder="bln/th" readonly>
                                    <div class="invalid-feedback">Umur wajib diisi.</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-door-open me-1"></i> Ruang</label>
                                    <input type="text" class="form-control" name="ruang" required>
                                    <div class="invalid-feedback">Ruang wajib diisi.</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-star me-1"></i> Kelas</label>
                                    <select class="form-select" name="kelas" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option>III</option>
                                        <option>II</option>
                                        <option>I</option>
                                        <option>VIP</option>
                                    </select>
                                    <div class="invalid-feedback">Kelas wajib dipilih.</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-gray"><i class="fas fa-home me-1"></i> Alamat</label>
                                <input type="text" class="form-control" name="alamat" required>
                                <div class="invalid-feedback">Alamat wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Medis -->
            <?= section("Informasi Medis") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Indikasi Rawat Inap -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-hospital me-2"></i>
                            <h6 class="mb-0 fw-bold">Indikasi Rawat Inap</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-hospital me-1"></i> 1. INDIKASI RAWAT INAP</label>
                                <textarea class="form-control" rows="3" name="indikasi_rawat_inap" required></textarea>
                                <div class="invalid-feedback">Indikasi rawat inap wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluhan Lain -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-comment-medical me-2"></i>
                            <h6 class="mb-0 fw-bold">Keluhan Lain</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-comment-medical me-1"></i> 2. KELUHAN LAIN</label>
                                <textarea class="form-control" rows="3" name="keluhan_lain"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Riwayat Penyakit Dahulu -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-history me-2"></i>
                            <h6 class="mb-0 fw-bold">Riwayat Penyakit Dahulu</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-file-medical me-1"></i> 3. RIWAYAT PENYAKIT DAHULU</label>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Penyakit :</label>
                                        <input type="text" class="form-control" name="nama_penyakit">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kapan :</label>
                                        <input type="text" class="form-control" name="kapan_penyakit">
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Riwayat Keluarga :</label>
                                    <textarea class="form-control" rows="2" name="riwayat_keluarga"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pemeriksaan Fisik -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-stethoscope me-2"></i>
                            <h6 class="mb-0 fw-bold">Pemeriksaan Fisik</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-stethoscope me-1"></i> 4. PEMERIKSAAN FISIK</label>
                                <textarea class="form-control" rows="4" name="pemeriksaan_fisik"></textarea>
                                <div class="invalid-feedback">Pemeriksaan fisik wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Pemeriksaan Penunjang -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-vial me-2"></i>
                            <h6 class="mb-0 fw-bold">Pemeriksaan Penunjang</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">

                                <div class="mb-2">
                                    <label class="form-label">Laboratorium :</label>
                                    <textarea class="form-control" rows="3" name="laboratorium"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Radiologi :</label>
                                    <textarea class="form-control" rows="3" name="radiologi"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Lain-lain :</label>
                                    <textarea class="form-control" rows="3" name="pemeriksaan_lain"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosa -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-diagnoses me-2"></i>
                            <h6 class="mb-0 fw-bold">Diagnosa</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" name="diagnosa"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Tata Laksana -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-prescription me-2"></i>
                            <h6 class="mb-0 fw-bold">Tata Laksana</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-prescription me-1"></i> 7. TATA LAKSANA</label>
                                <div class="mb-3">
                                    <label class="form-label">Medikamentosa saat perawatan :</label>
                                    <textarea class="form-control" rows="4" name="medikamentosa_perawatan"></textarea>

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Medikamentosa saat pulang :</label>
                                    <textarea class="form-control" rows="4" name="medikamentosa_pulang"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keadaan Waktu Keluar RS -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-hospital-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Keadaan Waktu Keluar RS</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-hospital-user me-1"></i> 8. KEADAAN WAKTU KELUAR RS</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Sembuh" id="sembuh" required><label class="form-check-label" for="sembuh">Sembuh</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Membaik" id="membaik"><label class="form-check-label" for="membaik">Membaik</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Meninggal < 48 jam" id="meninggal_kurang"><label class="form-check-label" for="meninggal_kurang">Meninggal &lt; 48 jam</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Meninggal > 48 jam" id="meninggal_lebih"><label class="form-check-label" for="meninggal_lebih">Meninggal &gt; 48 jam</label></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Belum Sembuh" id="belum_sembuh"><label class="form-check-label" for="belum_sembuh">Belum Sembuh</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Cacat" id="cacat"><label class="form-check-label" for="cacat">Cacat</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Lain-lain" id="lain_lain"><label class="form-check-label" for="lain_lain">Lain-lain</label></div>
                                    </div>
                                    <div class="invalid-feedback d-block">Pilih salah satu keadaan.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Cara Keluar RS -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <h6 class="mb-0 fw-bold">Cara Keluar RS</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-sign-out-alt me-1"></i> 9. CARA KELUAR RS</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check"><input class="form-check-input" type="radio" name="cara_keluar" value="Diijinkan Pulang" id="ijin_pulang" required><label class="form-check-label" for="ijin_pulang">Diijinkan Pulang</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="cara_keluar" value="Pulang atas Permintaan Sendiri" id="permintaan_sendiri"><label class="form-check-label" for="permintaan_sendiri">Pulang atas Permintaan Sendiri</label></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check"><input class="form-check-input" type="radio" name="cara_keluar" value="Pulang tanpa pemberitahuan" id="tanpa_pemberitahuan"><label class="form-check-label" for="tanpa_pemberitahuan">Pulang tanpa pemberitahuan</label></div>
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-2" type="radio" name="cara_keluar" value="rujuk" id="rujuk">
                                            <label class="form-check-label me-2" for="rujuk">Dirujuk ke RS</label>
                                            <input type="text" class="form-control" name="rs_rujukan" placeholder="Nama RS...">
                                        </div>
                                    </div>
                                    <div class="invalid-feedback d-block">Pilih salah satu cara keluar.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prognosis -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-chart-line me-2"></i>
                            <h6 class="mb-0 fw-bold">Prognosis</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-chart-line me-1"></i> 10. PROGNOSIS</label>
                                <textarea class="form-control" rows="3" name="prognosis" required></textarea>
                                <div class="invalid-feedback">Prognosis wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Sebab Meninggal -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-skull-crossbones me-2"></i>
                            <h6 class="mb-0 fw-bold">Sebab Meninggal</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-skull-crossbones me-1"></i> 11. SEBAB MENINGGAL</label>
                                <textarea class="form-control" rows="3" name="sebab_meninggal"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instruksi Tindak Lanjut -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-clipboard-list me-2"></i>
                            <h6 class="mb-0 fw-bold">Instruksi Tindak Lanjut</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-clipboard-list me-1"></i> 12. INSTRUKSI TINDAK LANJUT</label>
                                <textarea class="form-control" rows="4" name="instruksi_tindak_lanjut" required></textarea>
                                <div class="invalid-feedback">Instruksi tindak lanjut wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Note -->
            <div class="alert alert-info mb-4">
                <small><strong>NB :</strong> Dibuat 3 rangkap : 1. Putih: Rekam Medis, 2. Merah Muda: Pasien, 3. Kuning: Faskes Lanjutan</small>
            </div>

            <!-- Tanda Tangan -->
            <?= section("Tanda Tangan") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <div class="col-md-6">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-signature me-2"></i>
                            <h6 class="mb-0 fw-bold">Pasien/Keluarga</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 80px; border: 1px dashed #ccc; margin: 10px 0; display: flex; align-items: center; justify-content: center; color: #999; background: #f8f9fa;">
                                <small>Area Tanda Tangan</small>
                            </div>
                            <div class="border-top pt-2">
                                <input type="text" class="form-control text-center" name="nama_pasien_ttd" placeholder="( Nama Terang )" required>
                                <div class="invalid-feedback">Nama pasien/keluarga wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-signature me-2"></i>
                            <h6 class="mb-0 fw-bold">DPJP</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 80px; border: 1px dashed #ccc; margin: 10px 0; display: flex; align-items: center; justify-content: center; color: #999; background: #f8f9fa;">
                                <small>Area Tanda Tangan</small>
                            </div>
                            <div class="border-top pt-2">
                                <input type="text" class="form-control text-center" name="nama_dpjp" placeholder="( Nama Terang )" required>
                                <div class="invalid-feedback">Nama DPJP wajib diisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jombang Date -->
            <div class="row mb-3">
                <div class="col-md-6 text-center">
                    <p class="mb-1">Jombang, <input type="date" class="form-control d-inline-block" name="tanggal_ttd" style="width: auto;" id="tanggal_ttd" required>
                    <div class="invalid-feedback">Tanggal wajib diisi.</div>
                    </p>
                </div>
                <div class="col-md-6"></div>
            </div>

            <!-- Template Actions -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">Cetak PDF</button>
                <button type="reset" class="btn btn-warning">Reset Form</button>
            </div>
        </form>
    </div>
</div>
<script src="../assets/js/main.js"></script>
<?php include "../template/footer.php"; ?>