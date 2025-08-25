<?php
if (!isset($title)) $title = "UNIPDU";
$base_url = "/magang_rs"; // ganti sesuai nama folder project kamu
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $base_url ?>/index.php">RUMAH SAKIT UNIPDU</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Rekam Medis
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= $base_url ?>/pages/penolakan.php">Penolakan Tindakan Kedokteran</a></li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/pages/persetujuan.php">Persetujuan Anestesi</a></li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/pages/resume_medis.php">Resume Medis</a></li>
                        <li><a class="dropdown-item" href="<?= $base_url ?>/pages/asesmen_awal.php">Asesmen Awal UGD</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>