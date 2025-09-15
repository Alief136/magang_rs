<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php'; // Adjusted path based on directory structure

// Get no_rawat from URL
$no_rawat = isset($_GET['no_rawat']) ? $_GET['no_rawat'] : '';
if (empty($no_rawat)) {
    die("Error: No patient record specified.");
}

// Fetch patient history
try {
    $sql = "SELECT no_rkm_medis, keluhan_utama, diagnosis_utama, diagnosis_sekunder, tindakan_terapi, 
                   tgl_masuk, jam_masuk, ruang, kelas, dokter_jaga, status 
            FROM asesmen_awal_medis_ranap 
            WHERE no_rawat = ? AND status = 'Aktif'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$no_rawat]);
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$patient) {
        die("No active records found for no_rawat: " . htmlspecialchars($no_rawat));
    }
} catch (PDOException $e) {
    die("Error fetching patient history: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pasien - <?php echo htmlspecialchars($no_rawat); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../template/header.php'; ?>

    <div class="container">
        <h2>Riwayat Pasien</h2>
        <table class="table">
            <tr>
                <th>No. Rawat</th>
                <td><?php echo htmlspecialchars($no_rawat); ?></td>
            </tr>
            <tr>
                <th>No. Rekam Medis</th>
                <td><?php echo htmlspecialchars($patient['no_rkm_medis']); ?></td>
            </tr>
            <tr>
                <th>Keluhan Utama</th>
                <td><?php echo htmlspecialchars($patient['keluhan_utama']); ?></td>
            </tr>
            <tr>
                <th>Diagnosis Utama</th>
                <td><?php echo htmlspecialchars($patient['diagnosis_utama']); ?></td>
            </tr>
            <tr>
                <th>Diagnosis Sekunder</th>
                <td><?php echo htmlspecialchars($patient['diagnosis_sekunder']); ?></td>
            </tr>
            <tr>
                <th>Tindakan/Terapi</th>
                <td><?php echo htmlspecialchars($patient['tindakan_terapi']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td><?php echo htmlspecialchars($patient['tgl_masuk']); ?></td>
            </tr>
            <tr>
                <th>Jam Masuk</th>
                <td><?php echo htmlspecialchars($patient['jam_masuk']); ?></td>
            </tr>
            <tr>
                <th>Ruang</th>
                <td><?php echo htmlspecialchars($patient['ruang']); ?></td>
            </tr>
            <tr>
                <th>Kelas</th>
                <td><?php echo htmlspecialchars($patient['kelas']); ?></td>
            </tr>
            <tr>
                <th>Dokter Jaga</th>
                <td><?php echo htmlspecialchars($patient['dokter_jaga']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($patient['status']); ?></td>
            </tr>
        </table>
        <a href="asesmen_awal.php?no_rawat=<?php echo urlencode($no_rawat); ?>" class="btn">Kembali ke Asesmen</a>
    </div>

    <?php include __DIR__ . '/../template/footer.php'; ?>
</body>

</html>