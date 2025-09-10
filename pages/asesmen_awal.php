<link rel="stylesheet" href="../assets/css/style.css">

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
date_default_timezone_set('Asia/Jakarta');

if (!function_exists('esc')) {
    function esc($s)
    {
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}

// Ambil parameter dari URL / POST
$no_rawat = $_POST['no_rawat'] ?? $_GET['no_rawat'] ?? '';
$no_rkm_medis = $_POST['no_rkm_medis'] ?? $_GET['no_rkm_medis'] ?? '';

// Inisialisasi data pasien
$pasien = $_SESSION['pasien_data'] ?? ['no_rkm_medis' => '', 'nm_pasien' => '', 'tgl_lahir' => '', 'jk' => '', 'alamat' => '', 'agama' => '', 'stts_nikah' => ''];

// Kalau no_rawat kosong tapi ada no_rkm_medis → ambil rawat terakhir pasien
if ($no_rawat === '' && $no_rkm_medis !== '') {
    $sqlLast = "SELECT rp.no_rawat
        FROM reg_periksa rp
        LEFT JOIN kamar_inap ki ON ki.no_rawat = rp.no_rawat
        WHERE rp.no_rkm_medis = ?
        ORDER BY
          COALESCE(CONCAT(ki.tgl_masuk, ' ', COALESCE(ki.jam_masuk, '00:00:00')),
                  CONCAT(rp.tgl_registrasi, ' ', rp.jam_reg)) DESC
        LIMIT 1";
    try {
        $stLast = $pdo->prepare($sqlLast);
        $stLast->execute([$no_rkm_medis]);
        $no_rawat = $stLast->fetchColumn() ?: '';
    } catch (PDOException $e) {
        error_log("Error in last rawat query: " . $e->getMessage());
        $no_rawat = '';
    }
}

// Ambil identitas pasien + no_rawat
if ($no_rawat) {
    $sql = "SELECT rp.no_rawat, rp.no_rkm_medis, p.nm_pasien, p.tgl_lahir, p.jk, p.alamat, p.agama, p.stts_nikah
            FROM reg_periksa rp
            JOIN pasien p ON p.no_rkm_medis = rp.no_rkm_medis
            LEFT JOIN kamar_inap ki ON ki.no_rawat = rp.no_rawat
            WHERE (rp.no_rkm_medis = ? OR rp.no_rawat = ?)
            LIMIT 1";
    try {
        $st = $pdo->prepare($sql);
        $st->execute([$no_rkm_medis, $no_rawat]);
        $pasien = $st->fetch(PDO::FETCH_ASSOC) ?: $pasien;
        // Simpan ke sesi
        $_SESSION['pasien_data'] = $pasien;
    } catch (PDOException $e) {
        error_log("Error in main query: " . $e->getMessage());
    }
} elseif ($no_rkm_medis) {
    // Fallback: ambil data pasien saja
    $sql = "SELECT no_rkm_medis, nm_pasien, tgl_lahir, jk, alamat, agama, stts_nikah
            FROM pasien
            WHERE no_rkm_medis = ?
            LIMIT 1";
    try {
        $st = $pdo->prepare($sql);
        $st->execute([$no_rkm_medis]);
        $pasien = $st->fetch(PDO::FETCH_ASSOC) ?: $pasien;
        // Simpan ke sesi
        $_SESSION['pasien_data'] = $pasien;
    } catch (PDOException $e) {
        error_log("Error in fallback query: " . $e->getMessage());
    }
}

// Hitung umur berdasarkan tgl_lahir
$umur = '';
if (!empty($pasien['tgl_lahir'])) {
    $birthDate = new DateTime($pasien['tgl_lahir']);
    $today = new DateTime(date('Y-m-d'));
    $diff = $today->diff($birthDate);
    $umur = $diff->y . ' thn ' . $diff->m . ' bln ' . $diff->d . ' hr';
}

$title = "Form Asesmen Awal Medis Rawat Inap - UGD Dewasa";
include "../template/header.php";

// Helper section
function section($title)
{
    return "<h5 class='mt-4 mb-2 fw-bold border-bottom pb-2'>$title</h5>";
}
?>

<div class="container my-4">
    <div class="card shadow p-4 form-title-card visible">
        <div class="card-header text-white d-flex align-items-center justify-content-center mb-4"
            style="background-color: #000000ff !important; color: #f5f5f5 !important;">
            <i class="fas fa-file-medical me-2"></i>
            <h4 class="mb-0 fw-bold"><?= $title ?></h4>
        </div>

        <!-- Tampilkan pesan sukses/error -->
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
                <?= esc(urldecode($_GET['message'] ?? 'Unknown error')) ?>
            </div>
        <?php endif; ?>

        <form id="asesmenForm" method="post" action="../actions/save_asesmen_awal_medis_ranap.php">
            <!-- Identitas Pasien -->
            <?= section("Identitas Pasien") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Informasi Pribadi -->
                <div class="col-md-12">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Informasi Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-user me-1"></i> Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?= esc($pasien['nm_pasien'] ?? '') ?>" readonly disabled>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-calendar-alt me-1"></i> Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_input" value="<?= esc($pasien['tgl_lahir'] ?? '') ?>" readonly disabled>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-venus-mars me-1"></i> jenis Kelamin</label>
                                    <select class="form-select" name="jk" disabled>
                                        <option value="" disabled <?= empty($pasien['jk']) ? 'selected' : '' ?>>Pilih...</option>
                                        <option value="L" <?= ($pasien['jk'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="P" <?= ($pasien['jk'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-child me-1"></i> Umur</label>
                                    <input type="text" class="form-control" name="umur" id="umur_input" value="<?= esc($umur) ?>" placeholder="... bln/thn" readonly disabled>
                                </div>
                                <div class="col-md-9 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-home me-1"></i> Alamat</label>
                                    <input type="text" class="form-control" name="alamat" value="<?= esc($pasien['alamat'] ?? '') ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-pray me-1"></i> Agama</label>
                                    <select class="form-select" name="agama" disabled>
                                        <option value="" disabled <?= empty($pasien['agama']) ? 'selected' : '' ?>>Pilih...</option>
                                        <option value="Islam" <?= ($pasien['agama'] ?? '') === 'Islam' ? 'selected' : '' ?>>Islam</option>
                                        <option value="Kristen" <?= ($pasien['agama'] ?? '') === 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                                        <option value="Katolik" <?= ($pasien['agama'] ?? '') === 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                                        <option value="Hindu" <?= ($pasien['agama'] ?? '') === 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                                        <option value="Buddha" <?= ($pasien['agama'] ?? '') === 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                                        <option value="Konghucu" <?= ($pasien['agama'] ?? '') === 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-ring me-1"></i> Status Perkawinan</label>
                                    <select class="form-select" name="status" disabled>
                                        <option value="" disabled <?= empty($pasien['stts_nikah']) ? 'selected' : '' ?>>Pilih...</option>
                                        <option value="K" <?= ($pasien['stts_nikah'] ?? '') === 'MENIKAH' ? 'selected' : '' ?>>K</option>
                                        <option value="BK" <?= ($pasien['stts_nikah'] ?? '') === 'BELUM MENIKAH' ? 'selected' : '' ?>>BK</option>
                                        <option value="C" <?= ($pasien['stts_nikah'] ?? '') === 'CERAI HIDUP' ? 'selected' : '' ?>>C</option>
                                        <option value="J" <?= ($pasien['stts_nikah'] ?? '') === 'JANDA' ? 'selected' : '' ?>>J</option>
                                        <option value="D" <?= ($pasien['stts_nikah'] ?? '') === 'DUDA' ? 'selected' : '' ?>>D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Detail Penerimaan -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-hospital me-2"></i>
                            <h6 class="mb-0 fw-bold">Detail Penerimaan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-id-card me-1"></i> No Rekam Medis</label>
                                    <input type="text" class="form-control" name="no_rkm_medis" value="<?= esc($pasien['no_rkm_medis'] ?? '') ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-file-medical me-1"></i> No Rawat</label>
                                    <input type="text" class="form-control" name="no_rawat" value="<?= esc($no_rawat) ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-calendar-check me-1"></i> Tgl Masuk</label>
                                    <input type="date" class="form-control" name="tgl_masuk" value="<?= esc($_POST['tgl_masuk'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-clock me-1"></i> Jam</label>
                                    <input type="time" class="form-control" name="jam_masuk" value="<?= esc($_POST['jam_masuk'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-door-open me-1"></i> Ruang</label>
                                    <input type="text" class="form-control" name="ruang" value="<?= esc($_POST['ruang'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label fw-bold text-gray"><i class="fas fa-star me-1"></i> Kelas</label>
                                    <select class="form-select" name="kelas">
                                        <option value="" disabled <?= empty($_POST['kelas']) ? 'selected' : '' ?>>Pilih...</option>
                                        <option value="III" <?= ($_POST['kelas'] ?? '') === 'III' ? 'selected' : '' ?>>III</option>
                                        <option value="II" <?= ($_POST['kelas'] ?? '') === 'II' ? 'selected' : '' ?>>II</option>
                                        <option value="I" <?= ($_POST['kelas'] ?? '') === 'I' ? 'selected' : '' ?>>I</option>
                                        <option value="VIP" <?= ($_POST['kelas'] ?? '') === 'VIP' ? 'selected' : '' ?>>VIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Transportasi -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 identitas-card visible">
                        <div class="card-header bg-gray text-white d-flex align-items-center">
                            <i class="fas fa-ambulance me-2"></i>
                            <h6 class="mb-0 fw-bold">Detail Transportasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-gray"><i class="fas fa-user-plus me-1"></i> Dikirim oleh</label>
                                <select class="form-select" name="dikirim_oleh">
                                    <option value="" disabled <?= empty($_POST['dikirim_oleh']) ? 'selected' : '' ?>>Pilih...</option>
                                    <option value="Sendiri" <?= ($_POST['dikirim_oleh'] ?? '') === 'Sendiri' ? 'selected' : '' ?>>Sendiri</option>
                                    <option value="Dokter/Bidan" <?= ($_POST['dikirim_oleh'] ?? '') === 'Dokter/Bidan' ? 'selected' : '' ?>>Dokter/Bidan</option>
                                    <option value="RS/PKM/BP" <?= ($_POST['dikirim_oleh'] ?? '') === 'RS/PKM/BP' ? 'selected' : '' ?>>RS/PKM/BP</option>
                                    <option value="Perusahaan" <?= ($_POST['dikirim_oleh'] ?? '') === 'Perusahaan' ? 'selected' : '' ?>>Perusahaan</option>
                                    <option value="Lainnya" <?= ($_POST['dikirim_oleh'] ?? '') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-gray"><i class="fas fa-users me-1"></i> Diantar oleh</label>
                                <select class="form-select" name="diantar_oleh">
                                    <option value="" disabled <?= empty($_POST['diantar_oleh']) ? 'selected' : '' ?>>Pilih...</option>
                                    <option value="Sendiri" <?= ($_POST['diantar_oleh'] ?? '') === 'Sendiri' ? 'selected' : '' ?>>Sendiri</option>
                                    <option value="Keluarga" <?= ($_POST['diantar_oleh'] ?? '') === 'Keluarga' ? 'selected' : '' ?>>Keluarga</option>
                                    <option value="Polisi" <?= ($_POST['diantar_oleh'] ?? '') === 'Polisi' ? 'selected' : '' ?>>Polisi</option>
                                    <option value="Lainnya" <?= ($_POST['diantar_oleh'] ?? '') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-gray"><i class="fas fa-car me-1"></i> Kendaraan Pengantar</label>
                                <select class="form-select" name="kendaraan">
                                    <option value="" disabled <?= empty($_POST['kendaraan']) ? 'selected' : '' ?>>Pilih...</option>
                                    <option value="Ambulance" <?= ($_POST['kendaraan'] ?? '') === 'Ambulance' ? 'selected' : '' ?>>Ambulance</option>
                                    <option value="Umum" <?= ($_POST['kendaraan'] ?? '') === 'Umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="Pribadi" <?= ($_POST['kendaraan'] ?? '') === 'Pribadi' ? 'selected' : '' ?>>Pribadi</option>
                                    <option value="Lainnya" <?= ($_POST['kendaraan'] ?? '') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prioritas & Kebutuhan Pasien -->
            <?= section("Prioritas & Kebutuhan Pasien") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Prioritas 0 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-skull-crossbones me-2"></i>
                            <h6 class="mb-0 fw-bold">Prioritas 0</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="prioritas" value="0">
                                <label class="form-check-label">Pilih Prioritas 0</label>
                            </div>
                            <ol class="mt-2 mb-0 small">
                                <li>Pasien sudah meninggal</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Prioritas 1 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-ambulance me-2"></i>
                            <h6 class="mb-0 fw-bold">Prioritas 1</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="prioritas" value="1">
                                <label class="form-check-label">Pilih Prioritas 1</label>
                            </div>
                            <ol class="mt-2 mb-2 small">
                                <li>Tersedak</li>
                                <li>Cidera Kepala Berat</li>
                                <li>Kejang</li>
                                <li>Penurunan Kesadaran</li>
                                <li>Kelainan Persalinan</li>
                                <li>Serangan Jantung</li>
                                <li>Lain - lain</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Prioritas 2 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-medkit me-2"></i>
                            <h6 class="mb-0 fw-bold">Prioritas 2</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="prioritas" value="2">
                                <label class="form-check-label">Pilih Prioritas 2</label>
                            </div>
                            <ol class="mt-2 mb-2 small">
                                <li>Luka Bakar</li>
                                <li>Cidera Kepala Sedang</li>
                                <li>Dehidrasi</li>
                                <li>Muntah Terus menerus</li>
                                <li>Hipertensi</li>
                                <li>Trauma sedang</li>
                                <li>Lain - lain</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Prioritas 3 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-band-aid me-2"></i>
                            <h6 class="mb-0 fw-bold">Prioritas 3</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="prioritas" value="3">
                                <label class="form-check-label">Pilih Prioritas 3</label>
                            </div>
                            <ol class="mt-2 mb-2 small">
                                <li>Dislokasi</li>
                                <li>Patah Tulang tertutup</li>
                                <li>Nyeri minimal</li>
                                <li>Luka Minor / Lecet</li>
                                <li>Muntah Tanpa dehidrasi</li>
                                <li>Lain - lain</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Preventif -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-shield-alt me-2"></i>
                            <h6 class="mb-0 fw-bold">Preventif</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Preventif">
                                <label class="form-check-label">Preventif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kuratif -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-hand-holding-medical me-2"></i>
                            <h6 class="mb-0 fw-bold">Kuratif</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Kuratif">
                                <label class="form-check-label">Kuratif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rehabilitatif -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-heartbeat me-2"></i>
                            <h6 class="mb-0 fw-bold">Rehabilitatif</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Rehabilitatif">
                                <label class="form-check-label">Rehabilitatif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paliatif -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 prioritas-card visible">
                        <div class="card-header bg-red text-white d-flex align-items-center">
                            <i class="fas fa-hand-holding-heart me-2"></i>
                            <h6 class="mb-0 fw-bold">Paliatif</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Paliatif">
                                <label class="form-check-label">Paliatif</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survey Primer -->
            <?= section("Survey Primer") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Jalan Napas -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-primer-card visible">
                        <div class="card-header bg-purple text-white d-flex align-items-center">
                            <i class="fas fa-lungs me-2"></i>
                            <h6 class="mb-0 fw-bold">Jalan Napas</h6>
                        </div>
                        <div class="card-body">
                            <!-- Bisa lebih dari 1 kondisi -->
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Paten"><label class="form-check-label">Paten</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Obstruksi partial"><label class="form-check-label">Obstruksi partial</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Stridor"><label class="form-check-label">Stridor</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Snoring"><label class="form-check-label">Snoring</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Gurgling"><label class="form-check-label">Gurgling</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Obstruksi total"><label class="form-check-label">Obstruksi total</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Trauma jalan napas"><label class="form-check-label">Trauma jalan napas</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Risiko aspirasi"><label class="form-check-label">Risiko aspirasi</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Perdarahan / muntahan"><label class="form-check-label">Perdarahan / muntahan</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="jalan_napas[]" value="Benda asing"><label class="form-check-label">Benda asing</label></div>

                            <!-- Kesimpulan → hanya satu -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-check-circle me-1"></i> Kesimpulan</label>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_napas" value="Aman"><label class="form-check-label">Aman</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_napas" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                        </div>
                    </div>
                </div>

                <!-- Pernapasan -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-primer-card visible">
                        <div class="card-header bg-purple text-white d-flex align-items-center">
                            <i class="fas fa-wind me-2"></i>
                            <h6 class="mb-0 fw-bold">Pernapasan</h6>
                        </div>
                        <div class="card-body">
                            <!-- Bisa lebih dari 1 -->
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Paten"><label class="form-check-label">Paten</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Tidak Spontan"><label class="form-check-label">Tidak Spontan</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Reguler"><label class="form-check-label">Reguler</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Irreguler"><label class="form-check-label">Irreguler</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Gerakan Dada Simetris"><label class="form-check-label">Gerakan Dada Simetris</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Gerakan Dada Asimetris"><label class="form-check-label">Gerakan Dada Asimetris</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Jejas Dinding Dada"><label class="form-check-label">Jejas Dinding Dada</label></div>

                            <!-- Tipe Pernapasan → hanya satu -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-lungs me-1"></i> Tipe Pernapasan</label>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Normal"><label class="form-check-label">Normal</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Takipneu"><label class="form-check-label">Takipneu</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Kussmaul"><label class="form-check-label">Kussmaul</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Biot"><label class="form-check-label">Biot</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Hiperventilasi"><label class="form-check-label">Hiperventilasi</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Cheyne Stoke"><label class="form-check-label">Cheyne Stoke</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Apneustic"><label class="form-check-label">Apneustic</label></div>

                            <!-- Auskultasi → bisa lebih dari 1 -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-stethoscope me-1"></i> Auskultasi</label>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="auskultasi[]" value="Rhonki"><label class="form-check-label">Rhonki</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="auskultasi[]" value="Wheezing"><label class="form-check-label">Wheezing</label></div>

                            <!-- Kesimpulan → hanya satu -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-check-circle me-1"></i> Kesimpulan</label>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_pernapasan" value="Aman"><label class="form-check-label">Aman</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_pernapasan" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                        </div>
                    </div>
                </div>

                <!-- Sirkulasi -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-primer-card visible">
                        <div class="card-header bg-purple text-white d-flex align-items-center">
                            <i class="fas fa-heartbeat me-2"></i>
                            <h6 class="mb-0 fw-bold">Sirkulasi</h6>
                        </div>
                        <div class="card-body">
                            <!-- Bisa lebih dari 1 -->
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Nadi Kuat"><label class="form-check-label">Nadi Kuat</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Nadi Lemah"><label class="form-check-label">Nadi Lemah</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Reguler"><label class="form-check-label">Reguler</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Irreguler"><label class="form-check-label">Irreguler</label></div>

                            <!-- Kulit / Mukosa -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-hand-holding-heart me-1"></i> Kulit / Mukosa</label>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Normal"><label class="form-check-label">Normal</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Pucat"><label class="form-check-label">Pucat</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Jaundice"><label class="form-check-label">Jaundice</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Sianosis"><label class="form-check-label">Sianosis</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Berkeringat"><label class="form-check-label">Berkeringat</label></div>

                            <!-- Akral -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-thermometer me-1"></i> Akral</label>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="akral[]" value="Hangat"><label class="form-check-label">Hangat</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="akral[]" value="Dingin"><label class="form-check-label">Dingin</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="akral[]" value="Kering"><label class="form-check-label">Kering</label></div>
                            <div class="form-check mb-2"><input type="checkbox" class="form-check-input" name="akral[]" value="Basah"><label class="form-check-label">Basah</label></div>

                            <!-- CRT → hanya satu -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-stopwatch me-1"></i> CRT</label>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="crt" value="<2 Detik"><label class="form-check-label">&lt; 2 Detik</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="crt" value=">2 Detik"><label class="form-check-label">&gt; 2 Detik</label></div>

                            <!-- Kesimpulan → hanya satu -->
                            <label class="form-label fw-bold text-purple mt-2"><i class="fas fa-check-circle me-1"></i> Kesimpulan</label>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_sirkulasi" value="Aman"><label class="form-check-label">Aman</label></div>
                            <div class="form-check mb-2"><input type="radio" class="form-check-input" name="kesimpulan_sirkulasi" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Vital -->
            <?= section("Tanda Vital") ?>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="card p-3 survey-primer-card">
                        <div class="card-header bg-purple text-white d-flex align-items-center">
                            <i class="fas fa-vials me-2"></i>
                            <h6 class="mb-0 fw-bold">Tanda Vital</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-brain me-1"></i> GCS
                                    </label>
                                    <input type="number" class="form-control" name="gcs" placeholder="..." min="0" max="15">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-heartbeat me-1"></i> TD (mmHg)
                                    </label>
                                    <input type="number" class="form-control" name="td" placeholder="..." min="0" max="300">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-pulse me-1"></i> Nadi (/menit)
                                    </label>
                                    <input type="number" class="form-control" name="nadi" placeholder="..." min="0" max="250">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-lungs me-1"></i> RR (/menit)
                                    </label>
                                    <input type="number" class="form-control" name="rr" placeholder="..." min="0" max="100">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-thermometer-half me-1"></i> Suhu (°C)
                                    </label>
                                    <input type="number" class="form-control" name="suhu" placeholder="..." step="0.1" min="25" max="45">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-tint me-1"></i> SpO2 (%)
                                    </label>
                                    <input type="number" class="form-control" name="spo2" placeholder="..." min="0" max="100">
                                </div>
                                <div class="col-md col-6 mb-2">
                                    <label class="form-label fw-bold text-purple">
                                        <i class="fas fa-weight me-1"></i> BB (kg)
                                    </label>
                                    <input type="number" class="form-control" name="bb" placeholder="..." step="0.1" min="0" max="500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjektif -->
            <?= section("Subjektif") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 subjektif-card">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Subjektif</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-comment-medical me-1"></i> Keluhan Utama</label>
                                <textarea class="form-control subjektif-textarea" name="keluhan" rows="3" placeholder="Masukkan keluhan utama pasien..."></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-history me-1"></i> Riwayat Penyakit Sekarang</label>
                                <textarea class="form-control subjektif-textarea" name="riwayat_sekarang" rows="3" placeholder="Masukkan riwayat penyakit saat ini..."></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-file-medical me-1"></i> Riwayat Penyakit Dahulu</label>
                                <textarea class="form-control subjektif-textarea" name="riwayat_dahulu" rows="3" placeholder="Masukkan riwayat penyakit sebelumnya..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 subjektif-card">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <h6 class="mb-0 fw-bold">Subjektif</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-users me-1"></i> Riwayat Penyakit Keluarga</label>
                                <textarea class="form-control subjektif-textarea" name="riwayat_keluarga" rows="3" placeholder="Masukkan riwayat penyakit keluarga..."></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-prescription-bottle me-1"></i> Obat-obatan</label>
                                <textarea class="form-control subjektif-textarea" name="obat" rows="3" placeholder="Masukkan obat-obatan yang digunakan..."></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-info"><i class="fas fa-allergies me-1"></i> Alergi</label>
                                <textarea class="form-control subjektif-textarea" name="alergi" rows="3" placeholder="Masukkan riwayat alergi..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Survey Sekunder -->
            <?= section("Survey Sekunder - Pemeriksaan Fisik (Objective)") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Keadaan Umum -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-stethoscope me-2"></i>
                            <h6 class="mb-0 fw-bold">Keadaan Umum</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-heartbeat me-1"></i> Keadaan Umum</label>
                                <textarea class="form-control" rows="20" name="keadaan_umum"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kepala & Wajah -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-head-side-mask me-2"></i>
                            <h6 class="mb-0 fw-bold">Kepala & Wajah</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-brain me-1"></i> Kepala</label>
                                <textarea class="form-control" rows="2" name="kepala"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-eye me-1"></i> Konjungtiva</label>
                                <textarea class="form-control" rows="2" name="konjungtiva"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-eye me-1"></i> Sclera</label>
                                <textarea class="form-control" rows="2" name="sclera"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-lips me-1"></i> Bibir / Lidah</label>
                                <textarea class="form-control" rows="2" name="bibir_lidah"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-head-side-cough me-1"></i> Mukosa</label>
                                <textarea class="form-control" rows="2" name="mukosa"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leher -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-neck me-2"></i>
                            <h6 class="mb-0 fw-bold">Leher</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-neck me-1"></i> Leher</label>
                                <textarea class="form-control" rows="2" name="leher"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-lungs me-1"></i> Deviasi Trakea</label>
                                <textarea class="form-control" rows="2" name="deviasi_trakea"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-veins me-1"></i> JVP</label>
                                <textarea class="form-control" rows="2" name="jvp"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-lymph-nodes me-1"></i> LNN</label>
                                <textarea class="form-control" rows="2" name="lnn"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-thyroid me-1"></i> Tiroid</label>
                                <textarea class="form-control" rows="2" name="tiroid"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Thorax -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-lungs me-2"></i>
                            <h6 class="mb-0 fw-bold">Thorax</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-chest me-1"></i> Thorax</label>
                                <textarea class="form-control" rows="2" name="thorax"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-heart me-1"></i> Jantung</label>
                                <textarea class="form-control" rows="2" name="jantung"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-lungs me-1"></i> Paru</label>
                                <textarea class="form-control" rows="2" name="paru"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Abdomen & Pelvis -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-abdomen me-2"></i>
                            <h6 class="mb-0 fw-bold">Abdomen & Pelvis</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-abdomen me-1"></i> Abdomen & Pelvis</label>
                                <textarea class="form-control" rows="4" name="abdomen_pelvis"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-spine me-1"></i> Punggung & Pinggang</label>
                                <textarea class="form-control" rows="4" name="punggung_pinggang"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Genitalia & Ekstremitas -->
                <div class="col-md-4">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-body me-2"></i>
                            <h6 class="mb-0 fw-bold">Genitalia & Ekstremitas</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-genitalia me-1"></i> Genitalia</label>
                                <textarea class="form-control" rows="4" name="genitalia"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-bone me-1"></i> Ekstremitas</label>
                                <textarea class="form-control" rows="4" name="ekstremitas"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Pemeriksaan Lain -->
                <div class="col-md-12">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-clipboard-check me-2"></i>
                            <h6 class="mb-0 fw-bold">Pemeriksaan Lain</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-notes-medical me-1"></i> Pemeriksaan Lain</label>
                                <textarea class="form-control" rows="2" name="pemeriksaan_lain"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Penunjang -->
            <?= section("Pemeriksaan Penunjang") ?>
            <div class="row mb-4 d-flex align-items-stretch">
                <!-- Laboratorium -->
                <div class="col-md-12">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-vial me-2"></i>
                            <h6 class="mb-0 fw-bold">Laboratorium</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-vial me-1"></i> Laboratorium</label>
                                <textarea class="form-control" rows="2" name="laboratorium"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 d-flex align-items-stretch">
                <!-- Radiologi & Lain-lain -->
                <div class="col-md-12">
                    <div class="card p-3 h-100 survey-sekunder-card visible">
                        <div class="card-header bg-teal text-white d-flex align-items-center">
                            <i class="fas fa-x-ray me-2"></i>
                            <h6 class="mb-0 fw-bold">Radiologi & Lain-lain</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-x-ray me-1"></i> CT Scan</label>
                                <textarea class="form-control" rows="2" name="ct_scan"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-x-ray me-1"></i> X-ray</label>
                                <textarea class="form-control" rows="2" name="x_ray"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-ultrasound me-1"></i> USG</label>
                                <textarea class="form-control" rows="2" name="usg"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-heartbeat me-1"></i> ECG</label>
                                <textarea class="form-control" rows="2" name="ecg"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold text-teal"><i class="fas fa-notes-medical me-1"></i> Lain-lain</label>
                                <textarea class="form-control" rows="2" name="lain_lain"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assesmen & Planning -->
            <?= section("Assesmen & Planning") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Assesmen -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 assesmen-card">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <i class="fas fa-stethoscope me-2"></i>
                            <h6 class="mb-0 fw-bold">Assesmen</h6>
                        </div>
                        <div class="card-body">
                            <label class="form-label fw-bold text-primary">Diagnosis Utama</label>
                            <textarea class="form-control mb-2 assesmen-textarea" rows="2" name="diagnosis_utama" placeholder="Masukkan diagnosis utama..."></textarea>

                            <label class="form-label fw-bold text-primary">Diagnosis Sekunder</label>
                            <textarea class="form-control assesmen-textarea" rows="6" name="diagnosis_sekunder" placeholder="Masukkan diagnosis sekunder..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Planning -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 planning-card">
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <i class="fas fa-clipboard-list me-2"></i>
                            <h6 class="mb-0 fw-bold">Planning</h6>
                        </div>
                        <div class="card-body">
                            <label class="form-label fw-bold text-success">Tindakan dan Terapi</label>
                            <textarea class="form-control planning-textarea" rows="9" name="planning_tindakan_terapi" placeholder="Masukkan tindakan dan terapi..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tindak Lanjut -->
            <?= section("Tindak Lanjut") ?>
            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Pulang -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-home me-2"></i>
                            <h6 class="mb-0 fw-bold">Pulang</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="Pulang">
                                <div class="card-content">
                                    <span class="fw-bold">Pulang</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- MRS di ruang -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-hospital me-2"></i>
                            <h6 class="mb-0 fw-bold">MRS di ruang</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="MRS di ruang">
                                <div class="card-content">
                                    <span class="fw-bold">MRS di ruang</span>
                                </div>
                            </label>
                            <input type="text" class="form-control mt-1 mb-1" name="nama_ruang" placeholder="Nama Ruang...">
                        </div>
                    </div>
                </div>

                <!-- Menolak tindakan / MRS -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-ban me-2"></i>
                            <h6 class="mb-0 fw-bold">Menolak tindakan / MRS</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="Menolak tindakan / MRS">
                                <div class="card-content">
                                    <span class="fw-bold">Menolak tindakan / MRS</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Dirujuk ke RS -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-ambulance me-2"></i>
                            <h6 class="mb-0 fw-bold">Dirujuk ke RS</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="Dirujuk ke RS">
                                <div class="card-content">
                                    <span class="fw-bold">Dirujuk ke RS</span>
                                </div>
                            </label>
                            <input type="text" class="form-control mt-2" name="nama_rs" placeholder="Nama RS...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-2 d-flex align-items-stretch">
                <!-- Meninggal -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-skull-crossbones me-2"></i>
                            <h6 class="mb-0 fw-bold">Meninggal</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="Meninggal">
                                <div class="card-content">
                                    <span class="fw-bold">Meninggal</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- DOA -->
                <div class="col-md-3">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-heart-broken me-2"></i>
                            <h6 class="mb-0 fw-bold">DOA</h6>
                        </div>
                        <div class="card-body">
                            <label class="selectable-card w-100 h-100 text-center">
                                <input type="radio" class="form-check-input" name="tindak_lanjut" value="DOA">
                                <div class="card-content">
                                    <span class="fw-bold">DOA</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Dokter dan Tanda Tangan -->
                <div class="col-md-6">
                    <div class="card p-3 h-100 tindak-lanjut-card visible">
                        <div class="card-header bg-orange text-white d-flex align-items-center">
                            <i class="fas fa-user-md me-2"></i>
                            <h6 class="mb-0 fw-bold">Dokter yang Merawat / DPJP</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <input type="text" class="form-control" name="dokter_merawat" placeholder="Nama Dokter...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-info" onclick="printPDF()">Cetak PDF</button>
                <button type="reset" class="btn btn-warning">Reset Form</button>
                <a href="http://localhost/magang/magang_rs/public/detail.php?no_rkm_medis=<?= esc(urlencode($no_rkm_medis)) ?>&no_rawat=<?= esc(urlencode($no_rawat)) ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
<script src="../assets/js/main.js"></script>

<script>
    function printPDF() {
        const form = document.getElementById('asesmenForm');
        form.action = '../actions/cetak_pdf_asesmen_awal_medis_ranap.php'; // Changed from './actions/cetak_pdf.php'
        form.target = '_blank';
        form.submit();
        form.action = '../actions/save_asesmen_awal_medis_ranap.php';
        form.target = '';
    }
</script>

<?php include "../template/footer.php"; ?>