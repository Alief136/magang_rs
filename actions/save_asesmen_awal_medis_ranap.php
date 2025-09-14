<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php'; // Adjust path to your DB connection

// Get POST data
$no_rawat = $_POST['no_rawat'] ?? '';
$no_rkm_medis = $_POST['no_rkm_medis'] ?? '';
$keluhan_utama = $_POST['keluhan_utama'] ?? '';
$jalan_napas = $_POST['jalan_napas'] ?? [];
$kesimpulan_airway = $_POST['kesimpulan_airway'] ?? '';
$gcs = $_POST['gcs'] ?? '';
$nip_perawat = $_POST['nip_perawat'] ?? '';
$kd_dokter = $_POST['kd_dokter'] ?? '';
$dokter_jaga = $_POST['dokter_jaga'] ?? '';
// Add all other fields as per your form (around 70 fields)

// Validate all required fields
$required_fields = [
    'no_rawat' => $no_rawat,
    'no_rkm_medis' => $no_rkm_medis,
    'keluhan_utama' => $keluhan_utama,
    'jalan_napas' => $jalan_napas,
    'kesimpulan_airway' => $kesimpulan_airway,
    'gcs' => $gcs,
    'nip_perawat' => $nip_perawat,
    'kd_dokter' => $kd_dokter,
    'dokter_jaga' => $dokter_jaga,
    // Add all other fields
];
foreach ($required_fields as $field => $value) {
    if (empty($value) || (is_array($value) && count($value) === 0)) {
        header("Location: ../asesmen_awal.php?status=error&message=" . urlencode("Error: Field $field harus diisi!"));
        exit;
    }
}

// Validate nip_perawat exists in petugas table
$stmt_check_nip = $pdo->prepare("SELECT 1 FROM petugas WHERE nip = ? AND status = '1'");
$stmt_check_nip->execute([$nip_perawat]);
if ($stmt_check_nip->rowCount() === 0) {
    header("Location: ../asesmen_awal.php?status=error&message=" . urlencode("Error: NIP perawat tidak valid!"));
    exit;
}

// Validate kd_dokter and dokter_jaga exist in dokter table
$stmt_check_dokter = $pdo->prepare("SELECT 1 FROM dokter WHERE kd_dokter = ?");
$stmt_check_dokter->execute([$kd_dokter]);
if ($stmt_check_dokter->rowCount() === 0) {
    header("Location: ../asesmen_awal.php?status=error&message=" . urlencode("Error: Kode dokter tidak valid!"));
    exit;
}
$stmt_check_dokter->execute([$dokter_jaga]);
if ($stmt_check_dokter->rowCount() === 0) {
    header("Location: ../asesmen_awal.php?status=error&message=" . urlencode("Error: Dokter jaga tidak valid!"));
    exit;
}

// Convert checkbox arrays to JSON
$jalan_napas_json = json_encode($jalan_napas);
// Repeat for other checkbox fields: pernapasan, sirkulasi, etc.

// Deactivate previous assessments for the same no_rawat
$stmt_update = $pdo->prepare("UPDATE asesmen_awal_medis_ranap SET status='0' WHERE no_rawat = ? AND status='1'");
$stmt_update->execute([$no_rawat]);

// Insert new assessment
$status = '1'; // New assessment is active
$sql = "INSERT INTO asesmen_awal_medis_ranap (
    no_rawat, no_rkm_medis, tgl_input, kd_dokter, nip_perawat, dokter_jaga, keluhan_utama, jalan_napas, kesimpulan_airway, gcs,
    tgl_masuk, jam_masuk, ruang, kelas, dikirim_oleh, diantar_oleh, kendaraan_pengantar,
    prioritas_0, prioritas_1, prioritas_2, prioritas_3, preventif, kuratif, rehabilitatif, paliatif,
    pernapasan, tipe_pernapasan, auskultasi_pernapasan, kesimpulan_breathing,
    sirkulasi, kulit_mukosa, akral, crt, kesimpulan_circulation,
    td, nadi, rr, suhu, spo2, bb,
    riwayat_penyakit_sekarang, riwayat_penyakit_dahulu, riwayat_penyakit_keluarga, obat_obatan, alergi,
    keadaan_umum, kepala_wajah, konjungtiva, sklera, bibir_lidah, mukosa, leher, deviasi_trakea, jvp, lnn, tiroid,
    thorax, jantung, paru, abdomen_pelvis, punggung_pinggang, genitalia_ekstremitas, ekstremitas, pemeriksaan_lain,
    laboratorium, ct_scan, x_ray, usg, ecg, lain_lain_penunjang,
    diagnosis_utama, diagnosis_sekunder, tindakan_terapi, keputusan_akhir, nama_ruang, nama_rs, status
) VALUES (
    ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?,
    ?, ?, ?, ?, ?, ?, ?
)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $no_rawat,
        $no_rkm_medis,
        $kd_dokter,
        $nip_perawat,
        $dokter_jaga,
        $keluhan_utama,
        $jalan_napas_json,
        $kesimpulan_airway,
        $gcs,
        $_POST['tgl_masuk'],
        $_POST['jam_masuk'],
        $_POST['ruang'],
        $_POST['kelas'],
        $_POST['dikirim_oleh'],
        $_POST['diantar_oleh'],
        $_POST['kendaraan_pengantar'],
        $_POST['prioritas_0'],
        $_POST['prioritas_1'],
        $_POST['prioritas_2'],
        $_POST['prioritas_3'],
        $_POST['preventif'],
        $_POST['kuratif'],
        $_POST['rehabilitatif'],
        $_POST['paliatif'],
        json_encode($_POST['pernapasan'] ?? []),
        json_encode($_POST['tipe_pernapasan'] ?? []),
        json_encode($_POST['auskultasi_pernapasan'] ?? []),
        $_POST['kesimpulan_breathing'],
        json_encode($_POST['sirkulasi'] ?? []),
        json_encode($_POST['kulit_mukosa'] ?? []),
        json_encode($_POST['akral'] ?? []),
        $_POST['crt'],
        $_POST['kesimpulan_circulation'],
        $_POST['td'],
        $_POST['nadi'],
        $_POST['rr'],
        $_POST['suhu'],
        $_POST['spo2'],
        $_POST['bb'],
        $_POST['riwayat_penyakit_sekarang'],
        $_POST['riwayat_penyakit_dahulu'],
        $_POST['riwayat_penyakit_keluarga'],
        $_POST['obat_obatan'],
        $_POST['alergi'],
        $_POST['keadaan_umum'],
        $_POST['kepala_wajah'],
        $_POST['konjungtiva'],
        $_POST['sklera'],
        $_POST['bibir_lidah'],
        $_POST['mukosa'],
        $_POST['leher'],
        $_POST['deviasi_trakea'],
        $_POST['jvp'],
        $_POST['lnn'],
        $_POST['tiroid'],
        $_POST['thorax'],
        $_POST['jantung'],
        $_POST['paru'],
        $_POST['abdomen_pelvis'],
        $_POST['punggung_pinggang'],
        $_POST['genitalia_ekstremitas'],
        $_POST['ekstremitas'],
        $_POST['pemeriksaan_lain'],
        $_POST['laboratorium'],
        $_POST['ct_scan'],
        $_POST['x_ray'],
        $_POST['usg'],
        $_POST['ecg'],
        $_POST['lain_lain_penunjang'],
        $_POST['diagnosis_utama'],
        $_POST['diagnosis_sekunder'],
        $_POST['tindakan_terapi'],
        $_POST['keputusan_akhir'],
        $_POST['nama_ruang'],
        $_POST['nama_rs'],
        $status
    ]);
    header("Location: ../asesmen_awal.php?status=success&message=Data+berhasil+disimpan");
    exit;
} catch (PDOException $e) {
    error_log("Error insert asesmen: " . $e->getMessage());
    header("Location: ../asesmen_awal.php?status=error&message=" . urlencode("Error: " . $e->getMessage()));
    exit;
}
