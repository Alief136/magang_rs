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
     <div class="card shadow p-4">
         <div class="text-center mb-4">
             <h4 class="fw-bold text-decoration-underline"><?= $title ?></h4>
         </div>

         <form>
             <!-- Identitas Pasien -->
             <div class="row mb-3">
                 <div class="col-md-4">
                     <label class="form-label fw-bold">Nama Pasien</label>
                     <input type="text" class="form-control" name="nama_pasien">
                 </div>
                 <div class="col-md-2">
                     <label class="form-label fw-bold">Sex</label>
                     <select class="form-select" name="sex">
                         <option value="">Pilih</option>
                         <option value="L">L</option>
                         <option value="P">P</option>
                     </select>
                 </div>
                 <div class="col-md-6">
                     <label class="form-label fw-bold">No. Rekam Medis</label>
                     <input type="text" class="form-control" name="no_rm" maxlength="8" style="font-family: monospace; letter-spacing: 1px;">
                 </div>
             </div>

             <div class="row mb-3">
                 <div class="col-md-4">
                     <label class="form-label fw-bold">Tanggal Lahir</label>
                     <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir_input">
                 </div>
                 <div class="col-md-2">
                     <label class="form-label fw-bold">Umur</label>
                     <input type="text" class="form-control" name="umur" id="umur_input" placeholder="bln/th" readonly>
                 </div>
                 <div class="col-md-3">
                     <label class="form-label fw-bold">Ruang</label>
                     <input type="text" class="form-control" name="ruang">
                 </div>
                 <div class="col-md-3">
                     <label class="form-label fw-bold">Kelas</label>
                     <select class="form-select" name="kelas">
                         <option value="">Pilih</option>
                         <option>III</option>
                         <option>II</option>
                         <option>I</option>
                         <option>VIP</option>
                     </select>
                 </div>
             </div>

             <div class="row mb-4">
                 <div class="col-md-12">
                     <label class="form-label fw-bold">Alamat</label>
                     <input type="text" class="form-control" name="alamat">
                 </div>
             </div>

             <!-- Informasi Medis -->
             <div class="medical-table-container">
                 <table class="table-medical">
                     <!-- 1. Indikasi Rawat Inap -->
                     <tr>
                         <td class="label-col"><strong>1. INDIKASI RAWAT INAP</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="3" name="indikasi_rawat_inap"></textarea>
                         </td>
                     </tr>

                     <!-- 2. Keluhan Lain -->
                     <tr>
                         <td class="label-col"><strong>2. KELUHAN LAIN</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="3" name="keluhan_lain"></textarea>
                         </td>
                     </tr>

                     <!-- 3. Riwayat Penyakit Dahulu -->
                     <tr>
                         <td class="label-col"><strong>3. RIWAYAT PENYAKIT DAHULU</strong></td>
                         <td class="input-col">
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
                         </td>
                     </tr>

                     <!-- 4. Pemeriksaan Fisik -->
                     <tr>
                         <td class="label-col"><strong>4. PEMERIKSAAN FISIK</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="4" name="pemeriksaan_fisik"></textarea>
                         </td>
                     </tr>

                     <!-- 5. Pemeriksaan Penunjang -->
                     <tr>
                         <td class="label-col"><strong>5. PEMERIKSAAN PENUNJANG</strong></td>
                         <td class="input-col">
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
                         </td>
                     </tr>

                     <!-- 6. Diagnosa -->
                     <tr>
                         <td class="label-col"><strong>6. DIAGNOSA</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="3" name="diagnosa"></textarea>
                         </td>
                     </tr>

                     <!-- 7. Tata Laksana -->
                     <tr>
                         <td class="label-col"><strong>7. TATA LAKSANA</strong></td>
                         <td class="input-col">
                             <div class="mb-3">
                                 <label class="form-label">Medikamentosa saat perawatan :</label>
                                 <textarea class="form-control" rows="4" name="medikamentosa_perawatan"></textarea>
                             </div>
                             <div class="mb-2">
                                 <label class="form-label">Medikamentosa saat pulang :</label>
                                 <textarea class="form-control" rows="4" name="medikamentosa_pulang"></textarea>
                             </div>
                         </td>
                     </tr>

                     <!-- 8. Keadaan Waktu Keluar RS -->
                     <tr>
                         <td class="label-col"><strong>8. KEADAAN WAKTU KELUAR RS</strong></td>
                         <td class="input-col">
                             <div class="row">
                                 <div class="col-md-4">
                                     <div class="form-check"><input class="form-check-input" type="radio" name="keadaan_keluar" value="Sembuh" id="sembuh"><label class="form-check-label" for="sembuh">Sembuh</label></div>
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
                             </div>
                         </td>
                     </tr>

                     <!-- 9. Cara Keluar RS -->
                     <tr>
                         <td class="label-col"><strong>9. CARA KELUAR RS</strong></td>
                         <td class="input-col">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-check"><input class="form-check-input" type="radio" name="cara_keluar" value="Diijinkan Pulang" id="ijin_pulang"><label class="form-check-label" for="ijin_pulang">Diijinkan Pulang</label></div>
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
                             </div>
                         </td>
                     </tr>

                     <!-- 10. Prognosis -->
                     <tr>
                         <td class="label-col"><strong>10. PROGNOSIS</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="3" name="prognosis"></textarea>
                         </td>
                     </tr>

                     <!-- 11. Sebab Meninggal -->
                     <tr>
                         <td class="label-col"><strong>11. SEBAB MENINGGAL</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="3" name="sebab_meninggal"></textarea>
                         </td>
                     </tr>

                     <!-- 12. Instruksi Tindak Lanjut -->
                     <tr>
                         <td class="label-col"><strong>12. INSTRUKSI TINDAK LANJUT</strong></td>
                         <td class="input-col">
                             <textarea class="form-control" rows="4" name="instruksi_tindak_lanjut"></textarea>
                         </td>
                     </tr>
                 </table>
             </div>




             <!-- Note -->
             <div class="alert alert-info mb-4">
                 <small><strong>NB :</strong> Dibuat 3 rangkap : 1. Putih: Rekam Medis, 2. Merah Muda: Pasien, 3. Kuning: Faskes Lanjutan</small>
             </div>

             <!-- Tanda Tangan -->
             <div class="row mb-3">
                 <div class="col-md-6 text-center">
                     <p class="mb-1">Jombang, <input type="date" class="form-control d-inline-block" name="tanggal_ttd" style="width: auto;" id="tanggal_ttd"></p>
                 </div>
                 <div class="col-md-6"></div>
             </div>

             <div class="row mb-4">
                 <div class="col-md-6 text-center">
                     <label class="form-label fw-bold">Pasien/Keluarga,</label>
                     <div style="height: 80px; border: 1px dashed #ccc; margin: 10px 0; display: flex; align-items: center; justify-content: center; color: #999;">
                         <small>Area Tanda Tangan</small>
                     </div>
                     <div class="border-top pt-2">
                         <input type="text" class="form-control text-center" name="nama_pasien_ttd" placeholder="( Nama Terang )">
                     </div>
                 </div>
                 <div class="col-md-6 text-center">
                     <label class="form-label fw-bold">DPJP,</label>
                     <div style="height: 80px; border: 1px dashed #ccc; margin: 10px 0; display: flex; align-items: center; justify-content: center; color: #999;">
                         <small>Area Tanda Tangan</small>
                     </div>
                     <div class="border-top pt-2">
                         <input type="text" class="form-control text-center" name="nama_dpjp" placeholder="( Nama Terang )">
                     </div>
                 </div>
             </div>

             <!-- Template Actions (Optional) -->
             <div class="text-center mt-4">
                 <button type="button" class="btn btn-outline-secondary me-2" onclick="window.print()">
                     <i class="fas fa-print"></i> Print Template
                 </button>
                 <button type="reset" class="btn btn-outline-warning">
                     <i class="fas fa-redo"></i> Reset Form
                 </button>
             </div>
         </form>
     </div>
 </div>

 <script src="../assets/js/main.js"></script>

 <?php include "../template/footer.php"; ?>