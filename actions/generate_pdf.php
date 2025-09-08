<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Adjust path if TCPDF is installed via Composer
require_once __DIR__ . '/../config/db.php';
date_default_timezone_set('Asia/Jakarta');

if (!function_exists('esc')) {
    function esc($s)
    {
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}

// Initialize TCPDF
use TCPDF;

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator('RS System');
$pdf->SetAuthor('RS System');
$pdf->SetTitle('Asesmen Awal Medis Rawat Inap - UGD Dewasa');
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

// Get form data
$pasien = $_SESSION['pasien_data'] ?? ['no_rkm_medis' => '', 'nm_pasien' => '', 'tgl_lahir' => '', 'jk' => '', 'alamat' => '', 'agama' => '', 'stts_nikah' => ''];
$no_rawat = $_POST['no_rawat'] ?? '';
$no_rkm_medis = $_POST['no_rkm_medis'] ?? '';
$umur = '';
if (!empty($pasien['tgl_lahir'])) {
    $birthDate = new DateTime($pasien['tgl_lahir']);
    $today = new DateTime(date('Y-m-d'));
    $diff = $today->diff($birthDate);
    $umur = $diff->y . ' thn ' . $diff->m . ' bln ' . $diff->d . ' hr';
}

// Map status perkawinan
$status_perkawinan = [
    'MENIKAH' => 'K',
    'BELUM MENIKAH' => 'BK',
    'CERAI HIDUP' => 'C',
    'JANDA' => 'J',
    'DUDA' => 'D'
];
$status = $status_perkawinan[$pasien['stts_nikah'] ?? ''] ?? '';

// Form data
$tgl_masuk = $_POST['tgl_masuk'] ?? '';
$jam_masuk = $_POST['jam_masuk'] ?? '';
$ruang = $_POST['ruang'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$dikirim_oleh = $_POST['dikirim_oleh'] ?? '';
$diantar_oleh = $_POST['diantar_oleh'] ?? '';
$kendaraan = $_POST['kendaraan'] ?? '';
$prioritas = $_POST['prioritas'] ?? '';
$kebutuhan = $_POST['kebutuhan'] ?? [];
$jalan_napas = $_POST['jalan_napas'] ?? [];
$kesimpulan_napas = $_POST['kesimpulan_napas'] ?? '';
$pernapasan = $_POST['pernapasan'] ?? [];
$tipe_pernapasan = $_POST['tipe_pernapasan'] ?? '';
$auskultasi = $_POST['auskultasi'] ?? [];
$kesimpulan_pernapasan = $_POST['kesimpulan_pernapasan'] ?? '';
$sirkulasi = $_POST['sirkulasi'] ?? [];
$kulit_mukosa = $_POST['kulit_mukosa'] ?? [];
$akral = $_POST['akral'] ?? [];
$crt = $_POST['crt'] ?? '';
$kesimpulan_sirkulasi = $_POST['kesimpulan_sirkulasi'] ?? '';
$gcs = $_POST['gcs'] ?? '';
$td = $_POST['td'] ?? '';
$nadi = $_POST['nadi'] ?? '';
$rr = $_POST['rr'] ?? '';
$suhu = $_POST['suhu'] ?? '';
$spo2 = $_POST['spo2'] ?? '';
$bb = $_POST['bb'] ?? '';
$keluhan = $_POST['keluhan'] ?? '';
$riwayat_sekarang = $_POST['riwayat_sekarang'] ?? '';
$riwayat_dahulu = $_POST['riwayat_dahulu'] ?? '';
$riwayat_keluarga = $_POST['riwayat_keluarga'] ?? '';
$obat = $_POST['obat'] ?? '';
$alergi = $_POST['alergi'] ?? '';
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
$laboratorium = $_POST['laboratorium'] ?? '';
$ct_scan = $_POST['ct_scan'] ?? '';
$x_ray = $_POST['x_ray'] ?? '';
$usg = $_POST['usg'] ?? '';
$ecg = $_POST['ecg'] ?? '';
$lain_lain = $_POST['lain_lain'] ?? '';
$diagnosis_utama = $_POST['diagnosis_utama'] ?? '';
$diagnosis_sekunder = $_POST['diagnosis_sekunder'] ?? '';
$planning_tindakan_terapi = $_POST['planning_tindakan_terapi'] ?? '';
$tindak_lanjut = $_POST['tindak_lanjut'] ?? '';
$nama_ruang = $_POST['nama_ruang'] ?? '';
$nama_rs = $_POST['nama_rs'] ?? '';
$dokter_merawat = $_POST['dokter_merawat'] ?? '';

// Helper function to format checkbox arrays
function formatCheckboxes($array, $options)
{
    $result = [];
    foreach ($options as $option) {
        $result[] = in_array($option, $array) ? "[X] $option" : "[ ] $option";
    }
    return implode("<br>", $result);
}

// HTML content for PDF
$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid black; padding: 3mm; font-size: 10pt; }
    th { background-color: #f0f0f0; font-weight: bold; }
    h1 { font-size: 14pt; text-align: center; }
    h2 { font-size: 12pt; }
    .section { margin-bottom: 5mm; }
    .checkbox { font-size: 9pt; }
</style>
<h1>ASESMEN AWAL MEDIS UGD RAWAT INAP DEWASA</h1>

<div class="section">
    <h2>I. Identitas Pasien</h2>
    <table>
        <tr><th>Nama</th><td>' . esc($pasien['nm_pasien']) . '</td><th>Tgl Lahir</th><td>' . esc($pasien['tgl_lahir']) . '</td><th>Sex</th><td>' . esc($pasien['jk']) . '</td></tr>
        <tr><th>Umur</th><td>' . esc($umur) . '</td><th>Agama</th><td>' . esc($pasien['agama']) . '</td><th>Status</th><td>' . esc($status) . '</td></tr>
        <tr><th>Alamat</th><td colspan="5">' . esc($pasien['alamat']) . '</td></tr>
        <tr><th>No RM</th><td>' . esc($no_rkm_medis) . '</td><th>No Rawat</th><td>' . esc($no_rawat) . '</td><th>Tgl Masuk</th><td>' . esc($tgl_masuk . ' ' . $jam_masuk) . '</td></tr>
        <tr><th>Ruang</th><td>' . esc($ruang) . '</td><th>Kelas</th><td>' . esc($kelas) . '</td><th></th><td></td></tr>
        <tr><th>Dikirim oleh</th><td>' . esc($dikirim_oleh) . '</td><th>Diantar oleh</th><td>' . esc($diantar_oleh) . '</td><th>Kendaraan</th><td>' . esc($kendaraan) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>II. Prioritas & Kebutuhan Pasien</h2>
    <table>
        <tr><th>Prioritas</th><td>' . esc($prioritas) . '</td></tr>
        <tr><th>Kebutuhan</th><td>' . esc(implode(', ', $kebutuhan)) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>III. Survey Primer</h2>
    <table>
        <tr><th>Jalan Napas</th><td class="checkbox">' . formatCheckboxes($jalan_napas, ['Paten', 'Obstruksi partial', 'Stridor', 'Snoring', 'Gurgling', 'Obstruksi total', 'Trauma jalan napas', 'Risiko aspirasi', 'Perdarahan / muntahan', 'Benda asing']) . '<br><b>Kesimpulan:</b> ' . esc($kesimpulan_napas) . '</td></tr>
        <tr><th>Pernapasan</th><td class="checkbox">' . formatCheckboxes($pernapasan, ['Paten', 'Tidak Spontan', 'Reguler', 'Irreguler', 'Gerakan Dada Simetris', 'Gerakan Dada Asimetris', 'Jejas Dinding Dada']) . '<br><b>Tipe Pernapasan:</b> ' . esc($tipe_pernapasan) . '<br><b>Auskultasi:</b> ' . formatCheckboxes($auskultasi, ['Rhonki', 'Wheezing']) . '<br><b>Kesimpulan:</b> ' . esc($kesimpulan_pernapasan) . '</td></tr>
        <tr><th>Sirkulasi</th><td class="checkbox">' . formatCheckboxes($sirkulasi, ['Nadi Kuat', 'Nadi Lemah', 'Reguler', 'Irreguler']) . '<br><b>Kulit/Mukosa:</b> ' . formatCheckboxes($kulit_mukosa, ['Normal', 'Pucat', 'Jaundice', 'Sianosis', 'Berkeringat']) . '<br><b>Akral:</b> ' . formatCheckboxes($akral, ['Hangat', 'Dingin', 'Kering', 'Basah']) . '<br><b>CRT:</b> ' . esc($crt) . '<br><b>Kesimpulan:</b> ' . esc($kesimpulan_sirkulasi) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>IV. Tanda Vital</h2>
    <table>
        <tr><th>GCS</th><td>' . esc($gcs) . '</td><th>TD (mmHg)</th><td>' . esc($td) . '</td><th>Nadi (/menit)</th><td>' . esc($nadi) . '</td></tr>
        <tr><th>RR (/menit)</th><td>' . esc($rr) . '</td><th>Suhu (°C)</th><td>' . esc($suhu) . '</td><th>SpO2 (%)</th><td>' . esc($spo2) . '</td></tr>
        <tr><th>BB (kg)</th><td>' . esc($bb) . '</td><th></th><td></td><th></th><td></td></tr>
    </table>
</div>

<div class="section">
    <h2>V. Subjektif</h2>
    <table>
        <tr><th>Keluhan Utama</th><td>' . esc($keluhan) . '</td></tr>
        <tr><th>Riwayat Penyakit Sekarang</th><td>' . esc($riwayat_sekarang) . '</td></tr>
        <tr><th>Riwayat Penyakit Dahulu</th><td>' . esc($riwayat_dahulu) . '</td></tr>
        <tr><th>Riwayat Penyakit Keluarga</th><td>' . esc($riwayat_keluarga) . '</td></tr>
        <tr><th>Obat-obatan</th><td>' . esc($obat) . '</td></tr>
        <tr><th>Alergi</th><td>' . esc($alergi) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>VI. Survey Sekunder - Pemeriksaan Fisik (Objective)</h2>
    <table>
        <tr><th>Keadaan Umum</th><td>' . esc($keadaan_umum) . '</td></tr>
        <tr><th>Kepala</th><td>' . esc($kepala) . '</td></tr>
        <tr><th>Konjungtiva</th><td>' . esc($konjungtiva) . '</td></tr>
        <tr><th>Sclera</th><td>' . esc($sclera) . '</td></tr>
        <tr><th>Bibir/Lidah</th><td>' . esc($bibir_lidah) . '</td></tr>
        <tr><th>Mukosa</th><td>' . esc($mukosa) . '</td></tr>
        <tr><th>Leher</th><td>' . esc($leher) . '</td></tr>
        <tr><th>Deviasi Trakea</th><td>' . esc($deviasi_trakea) . '</td></tr>
        <tr><th>JVP</th><td>' . esc($jvp) . '</td></tr>
        <tr><th>LNN</th><td>' . esc($lnn) . '</td></tr>
        <tr><th>Tiroid</th><td>' . esc($tiroid) . '</td></tr>
        <tr><th>Thorax</th><td>' . esc($thorax) . '</td></tr>
        <tr><th>Jantung</th><td>' . esc($jantung) . '</td></tr>
        <tr><th>Paru</th><td>' . esc($paru) . '</td></tr>
        <tr><th>Abdomen & Pelvis</th><td>' . esc($abdomen_pelvis) . '</td></tr>
        <tr><th>Punggung & Pinggang</th><td>' . esc($punggung_pinggang) . '</td></tr>
        <tr><th>Genitalia</th><td>' . esc($genitalia) . '</td></tr>
        <tr><th>Ekstremitas</th><td>' . esc($ekstremitas) . '</td></tr>
        <tr><th>Pemeriksaan Lain</th><td>' . esc($pemeriksaan_lain) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>VII. Pemeriksaan Penunjang</h2>
    <table>
        <tr><th>Laboratorium</th><td>' . esc($laboratorium) . '</td></tr>
        <tr><th>CT Scan</th><td>' . esc($ct_scan) . '</td></tr>
        <tr><th>X-ray</th><td>' . esc($x_ray) . '</td></tr>
        <tr><th>USG</th><td>' . esc($usg) . '</td></tr>
        <tr><th>ECG</th><td>' . esc($ecg) . '</td></tr>
        <tr><th>Lain-lain</th><td>' . esc($lain_lain) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>VIII. Assesmen & Planning</h2>
    <table>
        <tr><th>Diagnosis Utama</th><td>' . esc($diagnosis_utama) . '</td></tr>
        <tr><th>Diagnosis Sekunder</th><td>' . esc($diagnosis_sekunder) . '</td></tr>
        <tr><th>Tindakan dan Terapi</th><td>' . esc($planning_tindakan_terapi) . '</td></tr>
    </table>
</div>

<div class="section">
    <h2>IX. Tindak Lanjut</h2>
    <table>
        <tr><th>Tindak Lanjut</th><td>' . esc($tindak_lanjut) . (in_array($tindak_lanjut, ['MRS di ruang', 'Dirujuk ke RS']) ? ' (' . esc($tindak_lanjut === 'MRS di ruang' ? $nama_ruang : $nama_rs) . ')' : '') . '</td></tr>
        <tr><th>Dokter yang Merawat / DPJP</th><td>' . esc($dokter_merawat) . '</td></tr>
    </table>
</div>
';

// Write HTML to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$filename = 'Asesmen_Awal_Medis_' . $no_rkm_medis . '_' . date('YmdHis') . '.pdf';
$pdf->Output($filename, 'I'); // 'I' for inline display in browser
