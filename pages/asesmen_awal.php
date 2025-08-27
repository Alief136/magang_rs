<?php
if (session_status() === PHP_SESSION_NONE) session_start();




$title = "Form Asesmen Awal Medis Rawat Inap - UGD Dewasa";
include "../template/header.php";

// Helper section
function section($title)
{
    return "<h5 class='mt-4 mb-3 fw-bold border-bottom pb-2'>$title</h5>";
}
?>

<div class="container my-4">
    <div class="card shadow p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-decoration-underline"><?= $title ?></h4>
        </div>

        <form method="post" action="">
            <!-- Identitas Pasien -->
            <?= section("Identitas Pasien") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" class="form-control" name="nama">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_input">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Sex</label>
                    <select class="form-select" name="sex">
                        <option value="" disabled selected>Pilih...</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Umur</label>
                    <input type="text" class="form-control" name="umur" id="umur_input" placeholder="... bln/thn" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">No Rekam Medis</label>
                    <input type="text" class="form-control" name="no_rm">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Tgl Masuk</label>
                    <input type="date" class="form-control" name="tgl_masuk">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Jam</label>
                    <input type="time" class="form-control" name="jam_masuk">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat</label>
                    <input type="text" class="form-control" name="alamat">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Agama</label>
                    <select class="form-select" name="agama">
                        <option value="" disabled selected>Pilih...</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Status Perkawinan</label>
                    <select class="form-select" name="status">
                        <option value="" disabled selected>Pilih...</option>
                        <option>K</option>
                        <option>BK</option>
                        <option>C</option>
                        <option>J</option>
                        <option>D</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Ruang</label>
                    <input type="text" class="form-control" name="ruang">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kelas</label>
                    <select class="form-select" name="kelas">
                        <option value="" disabled selected>Pilih...</option>
                        <option>III</option>
                        <option>II</option>
                        <option>I</option>
                        <option>VIP</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Dikirim oleh</label>
                    <select class="form-select" name="dikirim_oleh">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Sendiri</option>
                        <option>Dokter/Bidan</option>
                        <option>RS/PKM/BP</option>
                        <option>Perusahaan</option>
                        <option>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Diantar oleh</label>
                    <select class="form-select" name="diantar_oleh">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Sendiri</option>
                        <option>Keluarga</option>
                        <option>Polisi</option>
                        <option>Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kendaraan Pengantar</label>
                    <select class="form-select" name="kendaraan">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Ambulance</option>
                        <option>Umum</option>
                        <option>Pribadi</option>
                        <option>Lainnya</option>
                    </select>
                </div>
            </div>


            <?= section("Prioritas & Kebutuhan Pasien") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Prioritas 0 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="prioritas" value="0">
                            <label class="form-check-label fw-bold">Prioritas 0</label>
                        </div>
                        <ul class="mt-2 mb-0 small">
                            <li>Pasien sudah meninggal</li>
                        </ul>
                    </div>
                </div>

                <!-- Prioritas 1 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="prioritas" value="1">
                            <label class="form-check-label fw-bold">Prioritas 1</label>
                        </div>
                        <ul class="mt-2 mb-0 small">
                            <li>Tersedak</li>
                            <li>Cidera Kepala Berat</li>
                            <li>Kejang</li>
                            <li>Penurunan Kesadaran</li>
                            <li>Kelainan Persalinan</li>
                            <li>Serangan Jantung</li>
                            <li>Lain - lain ......</li>
                        </ul>
                    </div>
                </div>

                <!-- Prioritas 2 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="prioritas" value="2">
                            <label class="form-check-label fw-bold">Prioritas 2</label>
                        </div>
                        <ul class="mt-2 mb-0 small">
                            <li>Luka Bakar</li>
                            <li>Cidera Kepala Sedang</li>
                            <li>Dehidrasi</li>
                            <li>Muntah Terus menerus</li>
                            <li>Hipertensi</li>
                            <li>Trauma sedang</li>
                            <li>Lain - lain .......</li>
                        </ul>
                    </div>
                </div>

                <!-- Prioritas 3 -->
                <div class="col-md-3">
                    <div class="card p-3 h-100">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="prioritas" value="3">
                            <label class="form-check-label fw-bold">Prioritas 3</label>
                        </div>
                        <ul class="mt-2 mb-0 small">
                            <li>Dislokasi</li>
                            <li>Patah Tulang tertutup</li>
                            <li>Nyeri minimal</li>
                            <li>Luka Minor / Lecet</li>
                            <li>Muntah Tanpa dehidrasi</li>
                            <li>Lain - lain ......</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kebutuhan Pasien -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kebutuhan Pasien</label>
                    <div class="form-check"><input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Preventif"><label class="form-check-label">Preventif</label></div>
                    <div class="form-check"><input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Kuratif"><label class="form-check-label">Kuratif</label></div>
                    <div class="form-check"><input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Rehabilitatif"><label class="form-check-label">Rehabilitatif</label></div>
                    <div class="form-check"><input type="checkbox" class="form-check-input" name="kebutuhan[]" value="Paliatif"><label class="form-check-label">Paliatif</label></div>
                </div>
            </div>





            <!-- Survey Primer -->
            <!-- Survey Primer -->
            <?= section("Survey Primer") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Jalan Napas -->
                <div class="col-md-4">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold">Jalan Napas</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Paten"><label class="form-check-label">Paten</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Obstruksi partial"><label class="form-check-label">Obstruksi partial</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Stridor"><label class="form-check-label">Stridor</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Snoring"><label class="form-check-label">Snoring</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Gurgling"><label class="form-check-label">Gurgling</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Obstruksi total"><label class="form-check-label">Obstruksi total</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Trauma jalan napas"><label class="form-check-label">Trauma jalan napas</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Risiko aspirasi"><label class="form-check-label">Risiko aspirasi</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Perdarahan / muntahan"><label class="form-check-label">Perdarahan / muntahan</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="jalan_napas" value="Benda asing"><label class="form-check-label">Benda asing</label></div>

                        <label class="form-label fw-bold mt-2">Kesimpulan</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_napas" value="Aman"><label class="form-check-label">Aman</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_napas" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                    </div>
                </div>

                <!-- Pernapasan -->
                <div class="col-md-4">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold">Pernapasan</label>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Paten"><label class="form-check-label">Paten</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Tidak Spontan"><label class="form-check-label">Tidak Spontan</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Reguler"><label class="form-check-label">Reguler</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Irreguler"><label class="form-check-label">Irreguler</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Gerakan Dada Simetris"><label class="form-check-label">Gerakan Dada Simetris</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Gerakan Dada Asimetris"><label class="form-check-label">Gerakan Dada Asimetris</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="pernapasan[]" value="Jejas Dinding Dada"><label class="form-check-label">Jejas Dinding Dada</label></div>

                        <label class="form-label fw-bold mt-2">Tipe Pernapasan</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Normal"><label class="form-check-label">Normal</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Takipneu"><label class="form-check-label">Takipneu</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Kussmaul"><label class="form-check-label">Kussmaul</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Biot"><label class="form-check-label">Biot</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Hiperventilasi"><label class="form-check-label">Hiperventilasi</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Cheyne Stoke"><label class="form-check-label">Cheyne Stoke</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="tipe_pernapasan" value="Apneustic"><label class="form-check-label">Apneustic</label></div>

                        <label class="form-label fw-bold mt-2">Auskultasi</label>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="auskultasi[]" value="Rhonki"><label class="form-check-label">Rhonki</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="auskultasi[]" value="Wheezing"><label class="form-check-label">Wheezing</label></div>

                        <label class="form-label fw-bold mt-2">Kesimpulan</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_pernapasan" value="Aman"><label class="form-check-label">Aman</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_pernapasan" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                    </div>
                </div>

                <!-- Sirkulasi -->
                <div class="col-md-4">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold">Sirkulasi</label>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Nadi Kuat"><label class="form-check-label">Nadi Kuat</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Nadi Lemah"><label class="form-check-label">Nadi Lemah</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Reguler"><label class="form-check-label">Reguler</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="sirkulasi[]" value="Irreguler"><label class="form-check-label">Irreguler</label></div>

                        <label class="form-label fw-bold mt-2">Kulit / Mukosa</label>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Normal"><label class="form-check-label">Normal</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Pucat"><label class="form-check-label">Pucat</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Jaundice"><label class="form-check-label">Jaundice</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Sianosis"><label class="form-check-label">Sianosis</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="kulit_mukosa[]" value="Berkeringat"><label class="form-check-label">Berkeringat</label></div>

                        <label class="form-label fw-bold mt-2">Akral</label>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="akral[]" value="Hangat"><label class="form-check-label">Hangat</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="akral[]" value="Dingin"><label class="form-check-label">Dingin</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="akral[]" value="Kering"><label class="form-check-label">Kering</label></div>
                        <div class="form-check"><input type="checkbox" class="form-check-input" name="akral[]" value="Basah"><label class="form-check-label">Basah</label></div>

                        <label class="form-label fw-bold mt-2">CRT</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="crt" value="<2 Detik"><label class="form-check-label">&lt; 2 Detik</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="crt" value=">2 Detik"><label class="form-check-label">&gt; 2 Detik</label></div>

                        <label class="form-label fw-bold mt-2">Kesimpulan</label>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_sirkulasi" value="Aman"><label class="form-check-label">Aman</label></div>
                        <div class="form-check"><input type="radio" class="form-check-input" name="kesimpulan_sirkulasi" value="Mengancam nyawa"><label class="form-check-label">Mengancam nyawa</label></div>
                    </div>
                </div>
            </div>



            <!-- Tanda Vital -->
            <?= section("Tanda Vital") ?>
            <div class="row mb-3">
                <div class="col-md-1"><label class="form-label fw-bold">GCS</label><input type="text" class="form-control" name="gcs"></div>
                <div class="col-md-2"><label class="form-label fw-bold">TD (mmHg)</label><input type="text" class="form-control" name="td"></div>
                <div class="col-md-2"><label class="form-label fw-bold">Nadi (/menit)</label><input type="text" class="form-control" name="nadi"></div>
                <div class="col-md-2"><label class="form-label fw-bold">RR (/menit)</label><input type="text" class="form-control" name="rr"></div>
                <div class="col-md-2"><label class="form-label fw-bold">Suhu (°C)</label><input type="text" class="form-control" name="suhu"></div>
                <div class="col-md-2"><label class="form-label fw-bold">SpO2 (%)</label><input type="text" class="form-control" name="spo2"></div>
                <div class="col-md-1"><label class="form-label fw-bold">BB (kg)</label><input type="text" class="form-control" name="bb"></div>
            </div>



            <!-- Subjektif -->
            <?= section("Subjektif") ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keluhan Utama</label>
                        <textarea class="form-control" name="keluhan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Riwayat Penyakit Sekarang</label>
                        <textarea class="form-control" name="riwayat_sekarang"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Riwayat Penyakit Dahulu</label>
                        <textarea class="form-control" name="riwayat_dahulu"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Riwayat Penyakit Keluarga</label>
                        <textarea class="form-control" name="riwayat_keluarga"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Obat-obatan</label>
                        <textarea class="form-control" name="obat"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alergi</label>
                        <textarea class="form-control" name="alergi"></textarea>
                    </div>
                </div>
            </div>

            <!-- Survey Sekunder -->
            <?= section("Survey Sekunder - Pemeriksaan Fisik (Objective)") ?>
            <table class="table table-bordered align-middle">
                <tbody>
                    <tr>
                        <td style="width:30%;" class="fw-bold">Keadaan Umum</td>
                        <td><textarea class="form-control" rows="2" name="keadaan_umum"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kepala</td>
                        <td><textarea class="form-control" rows="2" name="kepala"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Konjungtiva</td>
                        <td><textarea class="form-control" rows="2" name="konjungtiva"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Sclera</td>
                        <td><textarea class="form-control" rows="2" name="sclera"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Bibir / Lidah</td>
                        <td><textarea class="form-control" rows="2" name="bibir_lidah"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Mukosa</td>
                        <td><textarea class="form-control" rows="2" name="mukosa"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Leher</td>
                        <td><textarea class="form-control" rows="2" name="leher"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Deviasi Trakea</td>
                        <td><textarea class="form-control" rows="2" name="deviasi_trakea"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">JVP</td>
                        <td><textarea class="form-control" rows="2" name="jvp"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LNN</td>
                        <td><textarea class="form-control" rows="2" name="lnn"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tiroid</td>
                        <td><textarea class="form-control" rows="2" name="tiroid"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Thorax</td>
                        <td><textarea class="form-control" rows="2" name="thorax"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Jantung</td>
                        <td><textarea class="form-control" rows="2" name="jantung"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Paru</td>
                        <td><textarea class="form-control" rows="2" name="paru"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Abdomen & Pelvis</td>
                        <td><textarea class="form-control" rows="2" name="abdomen_pelvis"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Punggung & Pinggang</td>
                        <td><textarea class="form-control" rows="2" name="punggung_pinggang"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Genitalia</td>
                        <td><textarea class="form-control" rows="2" name="genitalia"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Ekstremitas</td>
                        <td><textarea class="form-control" rows="2" name="ekstremitas"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Pemeriksaan Lain</td>
                        <td><textarea class="form-control" rows="2" name="pemeriksaan_lain"></textarea></td>
                    </tr>
                </tbody>
            </table>


            <!-- Pemeriksaan Penunjang -->
            <?= section("Pemeriksaan Penunjang") ?>
            <table class="table table-bordered align-middle">
                <tbody>
                    <tr>
                        <td style="width:30%;" class="fw-bold">Laboratorium</td>
                        <td><textarea class="form-control" rows="2" name="laboratorium"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">CT Scan</td>
                        <td><textarea class="form-control" rows="2" name="ct_scan"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">X-ray</td>
                        <td><textarea class="form-control" rows="2" name="x_ray"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">USG</td>
                        <td><textarea class="form-control" rows="2" name="usg"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">ECG</td>
                        <td><textarea class="form-control" rows="2" name="ecg"></textarea></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Lain-lain</td>
                        <td><textarea class="form-control" rows="2" name="lain_lain"></textarea></td>
                    </tr>
                </tbody>
            </table>

            <!-- Assesmen & Planning -->
            <?= section("Assesmen & Planning") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Assesmen -->
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold">Diagnosis Utama</label>
                        <textarea class="form-control mb-3" rows="4" name="diagnosis_utama"></textarea>

                        <label class="form-label fw-bold">Diagnosis Sekunder</label>
                        <textarea class="form-control" rows="4" name="diagnosis_sekunder"></textarea>
                    </div>
                </div>

                <!-- Planning -->
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold">Tindakan dan Terapi</label>
                        <textarea class="form-control" rows="9" name="planning_tindakan_terapi"></textarea>
                    </div>
                </div>
            </div>



            <!-- Tindak Lanjut -->
            <!-- Tindak Lanjut -->
            <?= section("Tindak Lanjut") ?>
            <div class="row mb-3 d-flex align-items-stretch">
                <!-- Kiri -->
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <label class="form-label fw-bold d-block">Pilihan Tindak Lanjut</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="Pulang">
                            <label class="form-check-label">Pulang</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="MRS di ruang">
                            <label class="form-check-label">MRS di ruang</label>
                            <input type="text" class="form-control form-control-sm mt-1" name="ruang_mrs" placeholder="Nama Ruang">
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="Menolak tindakan / MRS">
                            <label class="form-check-label">Menolak tindakan / MRS</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="Dirujuk ke RS">
                            <label class="form-check-label">Dirujuk ke RS</label>
                            <input type="text" class="form-control form-control-sm mt-1" name="rs_rujuk" placeholder="Nama RS">
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="Meninggal">
                            <label class="form-check-label">Meninggal</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="tindaklanjut" value="DOA">
                            <label class="form-check-label">DOA</label>
                        </div>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="col-md-6">
                    <div class="card p-3 h-100">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dokter yang Merawat / DPJP</label>
                            <input type="text" class="form-control" name="dpjp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Terang dan Tanda Tangan</label>
                            <input type="text" class="form-control" name="ttd_dokter_jaga">
                            <small class="form-text text-muted">DOKTER JAGA</small>
                        </div>
                    </div>
                </div>
            </div>



            <!-- BUTTON -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/main.js"></script>
<?php include "../template/footer.php"; ?>