<?php
// actions/patient_data.php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
date_default_timezone_set('Asia/Jakarta');

function fetchPatientData($pdo, $no_rawat = '', $no_rkm_medis = '', $preload = true)
{
    // Default data kosong untuk input manual
    $default = [
        'no_rkm_medis' => '',
        'nm_pasien' => '',
        'tgl_lahir' => '',
        'jk' => '',
        'alamat' => '',
        'agama' => '',
        'stts_nikah' => ''
    ];

    if (!$preload) {
        return [
            'pasien' => $default,
            'no_rawat' => '',
            'umur' => '',
            'success' => true
        ];
    }

    // Inisialisasi data pasien dari session atau default
    $pasien = $_SESSION['pasien_data'] ?? $default;
    $no_rawat_result = $no_rawat;

    // Jika no_rawat kosong tapi ada no_rkm_medis, ambil rawat terakhir
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
            $no_rawat_result = $stLast->fetchColumn() ?: '';
        } catch (PDOException $e) {
            error_log("Error in last rawat query: " . $e->getMessage());
            return [
                'pasien' => $default,
                'no_rawat' => '',
                'umur' => '',
                'success' => false,
                'error' => 'Gagal mengambil data rawat terakhir.'
            ];
        }
    }

    // Ambil data pasien berdasarkan no_rawat atau no_rkm_medis
    if ($no_rawat_result) {
        $sql = "SELECT rp.no_rawat, rp.no_rkm_medis, p.nm_pasien, p.tgl_lahir, p.jk, p.alamat, p.agama, p.stts_nikah
                FROM reg_periksa rp
                JOIN pasien p ON p.no_rkm_medis = rp.no_rkm_medis
                LEFT JOIN kamar_inap ki ON ki.no_rawat = rp.no_rawat
                WHERE (rp.no_rkm_medis = ? OR rp.no_rawat = ?)
                LIMIT 1";
        try {
            $st = $pdo->prepare($sql);
            $st->execute([$no_rkm_medis, $no_rawat_result]);
            $pasien = $st->fetch(PDO::FETCH_ASSOC) ?: $default;
            $_SESSION['pasien_data'] = $pasien;
        } catch (PDOException $e) {
            error_log("Error in main query: " . $e->getMessage());
            return [
                'pasien' => $default,
                'no_rawat' => '',
                'umur' => '',
                'success' => false,
                'error' => 'Gagal mengambil data pasien.'
            ];
        }
    } elseif ($no_rkm_medis) {
        $sql = "SELECT no_rkm_medis, nm_pasien, tgl_lahir, jk, alamat, agama, stts_nikah
                FROM pasien
                WHERE no_rkm_medis = ?
                LIMIT 1";
        try {
            $st = $pdo->prepare($sql);
            $st->execute([$no_rkm_medis]);
            $pasien = $st->fetch(PDO::FETCH_ASSOC) ?: $default;
            $_SESSION['pasien_data'] = $pasien;
        } catch (PDOException $e) {
            error_log("Error in fallback query: " . $e->getMessage());
            return [
                'pasien' => $default,
                'no_rawat' => '',
                'umur' => '',
                'success' => false,
                'error' => 'Gagal mengambil data pasien.'
            ];
        }
    }

    // Hitung umur
    $umur = '';
    if (!empty($pasien['tgl_lahir'])) {
        $birthDate = new DateTime($pasien['tgl_lahir']);
        $today = new DateTime(date('Y-m-d'));
        $diff = $today->diff($birthDate);
        $umur = $diff->y . ' thn ' . $diff->m . ' bln ' . $diff->d . ' hr';
    }

    return [
        'pasien' => $pasien,
        'no_rawat' => $no_rawat_result,
        'umur' => $umur,
        'success' => true
    ];
}

function calculateAge($tgl_lahir)
{
    if (empty($tgl_lahir)) return '';
    $birthDate = new DateTime($tgl_lahir);
    $today = new DateTime(date('Y-m-d'));
    $diff = $today->diff($birthDate);
    return $diff->y . ' thn ' . $diff->m . ' bln ' . $diff->d . ' hr';
}
