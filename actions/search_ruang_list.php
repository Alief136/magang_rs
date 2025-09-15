<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$data = [];
$q = $_GET['q'] ?? '';

// Pastikan query tidak kosong dan minimal 2 karakter
if (strlen($q) >= 2) {
    try {
        $sql = "SELECT DISTINCT nm_bangsal FROM kamar_inap_bangsal WHERE nm_bangsal LIKE ? LIMIT 10";
        $st = $pdo->prepare($sql);
        $st->execute(["%$q%"]);
        $data = $st->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        error_log("Error searching rooms: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Database error']);
        exit;
    }
}
echo json_encode($data);
