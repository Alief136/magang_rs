<?php
session_start();
require_once __DIR__ . '/../config/db.php';
date_default_timezone_set('Asia/Jakarta');

if (!function_exists('esc')) {
    function esc($s)
    {
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}

// Cek apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../asesmen_awal.php?status=error&message=' . urlencode('Metode request tidak valid'));
    exit;
}

// Ambil data dari form
$no_rawat = $_POST['no_rawat'] ?? '';
$no_rkm_medis = $_POST['no_rkm_medis'] ?? '';

// Validasi data wajib
if (empty($no_rawat) || empty($no_rkm_medis)) {
    header('Location: ../asesmen_awal.php?status=error&message=' . urlencode('No. Rawat dan No. RM harus diisi'));
    exit;
}

// Tangkap semua data dari form
$tgl_masuk = $_POST['tgl_masuk'] ?? null;
$jam_masuk = $_POST['jam_masuk'] ?? null;
$ruang = $_POST['ruang'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$dikirim_oleh = $_POST['dikirim_oleh'] ?? '';
$diantar_oleh = $_POST['diantar_oleh'] ?? '';
$kendaraan = $_POST['kendaraan'] ?? '';
$prioritas = $_POST['prioritas'] ?? '';
$kebutuhan = isset($_POST['kebutuhan']) ? implode(',', $_POST['kebutuhan']) : '';

// Survey Primer
$jalan_napas = isset($_POST['jalan_napas']) ? implode(',', $_POST['jalan_napas']) : '';
$kesimpulan_napas = $_POST['kesimpulan_napas'] ?? '';
$pernapasan = isset($_POST['pernapasan']) ? implode(',', $_POST['pernapasan']) : '';
$tipe_pernapasan = $_POST['tipe_pernapasan'] ?? '';
$auskultasi = isset($_POST['auskultasi']) ? implode(',', $_POST['auskultasi']) : '';
$kesimpulan_pernapasan = $_POST['kesimpulan_pernapasan'] ?? '';
$sirkulasi = isset($_POST['sirkulasi']) ? implode(',', $_POST['sirkulasi']) : '';
$kulit_mukosa = isset($_POST['kulit_mukosa']) ? implode(',', $_POST['kulit_mukosa']) : '';
$akral = isset($_POST['akral']) ? implode(',', $_POST['akral']) : '';
$crt = $_POST['crt'] ?? '';
$kesimpulan_sirkulasi = $_POST['kesimpulan_sirkulasi'] ?? '';

// Tanda Vital
$gcs = $_POST['gcs'] ?? null;
$td = $_POST['td'] ?? null;
$nadi = $_POST['nadi'] ?? null;
$rr = $_POST['rr'] ?? null;
$suhu = $_POST['suhu'] ?? null;
$spo2 = $_POST['spo2'] ?? null;
$bb = $_POST['bb'] ?? null;

// Subjektif
$keluhan = $_POST['keluhan'] ?? '';
$riwayat_sekarang = $_POST['riwayat_sekarang'] ?? '';
$riwayat_dahulu = $_POST['riwayat_dahulu'] ?? '';
$riwayat_keluarga = $_POST['riwayat_keluarga'] ?? '';
$obat = $_POST['obat'] ?? '';
$alergi = $_POST['alergi'] ?? '';

// Survey Sekunder
$keadaan_umum = $_POST['keadaan_umum'] ?? '';
$kepala = $_POST['kepala'] ?? '';
$konjungtiva = $_POST['konjungtiva'] ?? '';
$sclera = $_POST['sclera'] ?? '';
$bibir_lidah = $_POST['bibir_lidah'] ?? '';
$mukosa = $_POST['mukosa'] ?? '';
$leher = $_POST['leher'] ?? '';
$deviasi_trakea = $_POST['deviasi_trakea'] ?? '';
$jvp = $_POST['jvp'] ?? '';
$lnn = $_POST['lnn'] ?? '';
$tiroid = $_POST['tiroid'] ?? '';
$thorax = $_POST['thorax'] ?? '';
$jantung = $_POST['jantung'] ?? '';
$paru = $_POST['paru'] ?? '';
$abdomen_pelvis = $_POST['abdomen_pelvis'] ?? '';
$punggung_pinggang = $_POST['punggung_pinggang'] ?? '';
$genitalia = $_POST['genitalia'] ?? '';
$ekstremitas = $_POST['ekstremitas'] ?? '';
$pemeriksaan_lain = $_POST['pemeriksaan_lain'] ?? '';

// Pemeriksaan Penunjang
$laboratorium = $_POST['laboratorium'] ?? '';
$ct_scan = $_POST['ct_scan'] ?? '';
$x_ray = $_POST['x_ray'] ?? '';
$usg = $_POST['usg'] ?? '';
$ecg = $_POST['ecg'] ?? '';
$lain_lain = $_POST['lain_lain'] ?? '';

// Assesmen & Planning
$diagnosis_utama = $_POST['diagnosis_utama'] ?? '';
$diagnosis_sekunder = $_POST['diagnosis_sekunder'] ?? '';
$planning_tindakan_terapi = $_POST['planning_tindakan_terapi'] ?? '';

// Tindak Lanjut
$tindak_lanjut = $_POST['tindak_lanjut'] ?? '';
$nama_ruang = $_POST['nama_ruang'] ?? '';
$nama_rs = $_POST['nama_rs'] ?? '';
$dokter_merawat = $_POST['dokter_merawat'] ?? '';

try {
    // Cek apakah data sudah ada untuk no_rawat ini
    $checkQuery = "SELECT id FROM form_asesmen_awal_medis_ranap WHERE no_rawat = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$no_rawat]);
    $existingData = $checkStmt->fetch();

    if ($existingData) {
        // Update data yang sudah ada
        $query = "UPDATE form_asesmen_awal_medis_ranap SET 
            tgl_masuk = ?, jam_masuk = ?, ruang = ?, kelas = ?, dikirim_oleh = ?, diantar_oleh = ?, kendaraan = ?,
            prioritas = ?, kebutuhan = ?, jalan_napas = ?, kesimpulan_napas = ?, pernapasan = ?, tipe_pernapasan = ?,
            auskultasi = ?, kesimpulan_pernapasan = ?, sirkulasi = ?, kulit_mukosa = ?, akral = ?, crt = ?,
            kesimpulan_sirkulasi = ?, gcs = ?, td = ?, nadi = ?, rr = ?, suhu = ?, spo2 = ?, bb = ?, keluhan = ?,
            riwayat_sekarang = ?, riwayat_dahulu = ?, riwayat_keluarga = ?, obat = ?, alergi = ?, keadaan_umum = ?,
            kepala = ?, konjungtiva = ?, sclera = ?, bibir_lidah = ?, mukosa = ?, leher = ?, deviasi_trakea = ?,
            jvp = ?, lnn = ?, tiroid = ?, thorax = ?, jantung = ?, paru = ?, abdomen_pelvis = ?, punggung_pinggang = ?,
            genitalia = ?, ekstremitas = ?, pemeriksaan_lain = ?, laboratorium = ?, ct_scan = ?, x_ray = ?, usg = ?,
            ecg = ?, lain_lain = ?, diagnosis_utama = ?, diagnosis_sekunder = ?, planning_tindakan_terapi = ?,
            tindak_lanjut = ?, nama_ruang = ?, nama_rs = ?, dokter_merawat = ?, updated_at = NOW()
            WHERE no_rawat = ?";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $tgl_masuk,
            $jam_masuk,
            $ruang,
            $kelas,
            $dikirim_oleh,
            $diantar_oleh,
            $kendaraan,
            $prioritas,
            $kebutuhan,
            $jalan_napas,
            $kesimpulan_napas,
            $pernapasan,
            $tipe_pernapasan,
            $auskultasi,
            $kesimpulan_pernapasan,
            $sirkulasi,
            $kulit_mukosa,
            $akral,
            $crt,
            $kesimpulan_sirkulasi,
            $gcs,
            $td,
            $nadi,
            $rr,
            $suhu,
            $spo2,
            $bb,
            $keluhan,
            $riwayat_sekarang,
            $riwayat_dahulu,
            $riwayat_keluarga,
            $obat,
            $alergi,
            $keadaan_umum,
            $kepala,
            $konjungtiva,
            $sclera,
            $bibir_lidah,
            $mukosa,
            $leher,
            $deviasi_trakea,
            $jvp,
            $lnn,
            $tiroid,
            $thorax,
            $jantung,
            $paru,
            $abdomen_pelvis,
            $punggung_pinggang,
            $genitalia,
            $ekstremitas,
            $pemeriksaan_lain,
            $laboratorium,
            $ct_scan,
            $x_ray,
            $usg,
            $ecg,
            $lain_lain,
            $diagnosis_utama,
            $diagnosis_sekunder,
            $planning_tindakan_terapi,
            $tindak_lanjut,
            $nama_ruang,
            $nama_rs,
            $dokter_merawat,
            $no_rawat
        ]);

        $message = "Data asesmen awal berhasil diperbarui";
    } else {
        // Insert data baru
        $query = "INSERT INTO form_asesmen_awal_medis_ranap (
            no_rawat, no_rkm_medis, tgl_masuk, jam_masuk, ruang, kelas, dikirim_oleh, diantar_oleh, kendaraan,
            prioritas, kebutuhan, jalan_napas, kesimpulan_napas, pernapasan, tipe_pernapasan, auskultasi,
            kesimpulan_pernapasan, sirkulasi, kulit_mukosa, akral, crt, kesimpulan_sirkulasi, gcs, td, nadi, rr,
            suhu, spo2, bb, keluhan, riwayat_sekarang, riwayat_dahulu, riwayat_keluarga, obat, alergi, keadaan_umum,
            kepala, konjungtiva, sclera, bibir_lidah, mukosa, leher, deviasi_trakea, jvp, lnn, tiroid, thorax,
            jantung, paru, abdomen_pelvis, punggung_pinggang, genitalia, ekstremitas, pemeriksaan_lain, laboratorium,
            ct_scan, x_ray, usg, ecg, lain_lain, diagnosis_utama, diagnosis_sekunder, planning_tindakan_terapi,
            tindak_lanjut, nama_ruang, nama_rs, dokter_merawat
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $no_rawat,
            $no_rkm_medis,
            $tgl_masuk,
            $jam_masuk,
            $ruang,
            $kelas,
            $dikirim_oleh,
            $diantar_oleh,
            $kendaraan,
            $prioritas,
            $kebutuhan,
            $jalan_napas,
            $kesimpulan_napas,
            $pernapasan,
            $tipe_pernapasan,
            $auskultasi,
            $kesimpulan_pernapasan,
            $sirkulasi,
            $kulit_mukosa,
            $akral,
            $crt,
            $kesimpulan_sirkulasi,
            $gcs,
            $td,
            $nadi,
            $rr,
            $suhu,
            $spo2,
            $bb,
            $keluhan,
            $riwayat_sekarang,
            $riwayat_dahulu,
            $riwayat_keluarga,
            $obat,
            $alergi,
            $keadaan_umum,
            $kepala,
            $konjungtiva,
            $sclera,
            $bibir_lidah,
            $mukosa,
            $leher,
            $deviasi_trakea,
            $jvp,
            $lnn,
            $tiroid,
            $thorax,
            $jantung,
            $paru,
            $abdomen_pelvis,
            $punggung_pinggang,
            $genitalia,
            $ekstremitas,
            $pemeriksaan_lain,
            $laboratorium,
            $ct_scan,
            $x_ray,
            $usg,
            $ecg,
            $lain_lain,
            $diagnosis_utama,
            $diagnosis_sekunder,
            $planning_tindakan_terapi,
            $tindak_lanjut,
            $nama_ruang,
            $nama_rs,
            $dokter_merawat
        ]);

        $message = "Data asesmen awal berhasil disimpan";
    }

    // Redirect dengan pesan sukses
    header('Location: ../asesmen_awal.php?status=success&message=' . urlencode($message) . '&no_rawat=' . $no_rawat . '&no_rkm_medis=' . $no_rkm_medis);
    exit;
} catch (PDOException $e) {
    // Redirect dengan pesan error
    error_log("Error saving asesmen data: " . $e->getMessage());
    header('Location: ../asesmen_awal.php?status=error&message=' . urlencode('Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()) . '&no_rawat=' . $no_rawat . '&no_rkm_medis=' . $no_rkm_medis);
    exit;
}
