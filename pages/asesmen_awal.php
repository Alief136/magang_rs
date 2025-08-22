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
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tgl Masuk & Jam</label>
                    <input type="datetime-local" class="form-control" name="tgl_masuk">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea class="form-control" name="alamat"></textarea>
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

            <?= section("Prioritas") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Prioritas</label>
                    <select class="form-select" name="prioritas">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Prioritas 0</option>
                        <option>Prioritas 1</option>
                        <option>Prioritas 2</option>
                        <option>Prioritas 3</option>
                        <option>Pasien sudah meninggal</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kebutuhan Pasien</label>
                    <select class="form-select" name="kebutuhan[]" multiple>
                        <option value="" disabled selected>Pilih...</option>
                        <option>Preventif</option>
                        <option>Kuratif</option>
                        <option>Rehabilitatif</option>
                        <option>Paliatif</option>
                    </select>
                    <small class="form-text text-muted">Untuk memilih lebih dari satu, tekan Ctrl (Windows) / Command (Mac) dan klik pilihan.</small>
                </div>
            </div>

            <?= section("Survey Primer") ?>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Jalan Napas</label>
                    <select class="form-select" name="jalan_napas">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Paten</option>
                        <option>Obstruksi partial</option>
                        <option>Stridor</option>
                        <option>Snoring</option>
                        <option>Gurgling</option>
                        <option>Obstruksi total</option>
                        <option>Trauma jalan napas</option>
                        <option>Risiko aspirasi</option>
                        <option>Perdarahan / muntahan</option>
                        <option>Benda asing</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Kesimpulan</label>
                    <select class="form-select" name="kesimpulan_napas">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Aman</option>
                        <option>Mengancam nyawa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Pernapasan</label>
                    <select class="form-select" name="pernapasan">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Paten</option>
                        <option>Tidak Spontan</option>
                        <option>Reguler</option>
                        <option>Irreguler</option>
                        <option>Gerakan Dada Simetris</option>
                        <option>Gerakan Dada Asimetris</option>
                        <option>Jejas Dinding Dada</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Tipe Pernapasan</label>
                    <select class="form-select" name="tipe_pernapasan">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Normal</option>
                        <option>Takipneu</option>
                        <option>Kussmaul</option>
                        <option>Biot</option>
                        <option>Hiperventilasi</option>
                        <option>Cheyne Stoke</option>
                        <option>Apneustic</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Auskultasi</label>
                    <select class="form-select" name="auskultasi[]" multiple>
                        <option value="" disabled selected>Pilih...</option>
                        <option>Rhonki</option>
                        <option>Wheezing</option>
                    </select>
                    <small class="form-text text-muted">Untuk memilih lebih dari satu, tekan Ctrl (Windows) / Command (Mac) dan klik pilihan.</small>
                    <label class="form-label fw-bold mt-2">Kesimpulan</label>
                    <select class="form-select" name="kesimpulan_pernapasan">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Aman</option>
                        <option>Mengancam nyawa</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Sirkulasi</label>
                    <select class="form-select" name="sirkulasi">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Nadi Kuat</option>
                        <option>Nadi Lemah</option>
                        <option>Reguler</option>
                        <option>Ireguler</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Kulit / Mukosa</label>
                    <select class="form-select" name="kulit_mukosa">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Normal</option>
                        <option>Pucat</option>
                        <option>Jaundice</option>
                        <option>Sianosis</option>
                        <option>Berkeringat</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Akral</label>
                    <select class="form-select" name="akral">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Hangat</option>
                        <option>Dingin</option>
                        <option>Kering</option>
                        <option>Basah</option>
                    </select>
                    <label class="form-label fw-bold mt-2">CRT</label>
                    <select class="form-select" name="crt">
                        <option value="" disabled selected>Pilih...</option>
                        <option>&lt;2 Detik</option>
                        <option>&gt;2 Detik</option>
                    </select>
                    <label class="form-label fw-bold mt-2">Kesimpulan</label>
                    <select class="form-select" name="kesimpulan_sirkulasi">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Aman</option>
                        <option>Mengancam nyawa</option>
                    </select>
                </div>
            </div>

            <?= section("Tanda Vital") ?>
            <div class="row mb-3">
                <div class="col-md-2"><label class="form-label fw-bold">GCS</label><input type="text" class="form-control" name="gcs"></div>
                <div class="col-md-2"><label class="form-label fw-bold">TD (mmHg)</label><input type="text" class="form-control" name="td"></div>
                <div class="col-md-2"><label class="form-label fw-bold">Nadi (/menit)</label><input type="text" class="form-control" name="nadi"></div>
                <div class="col-md-2"><label class="form-label fw-bold">RR (/menit)</label><input type="text" class="form-control" name="rr"></div>
                <div class="col-md-2"><label class="form-label fw-bold">Suhu (°C)</label><input type="text" class="form-control" name="suhu"></div>
                <div class="col-md-2"><label class="form-label fw-bold">SpO2 (%)</label><input type="text" class="form-control" name="spo2"></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><label class="form-label fw-bold">BB (kg)</label><input type="text" class="form-control" name="bb"></div>
            </div>

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

            <?= section("Survey Sekunder - Pemeriksaan Fisik") ?>
            <table class="table table-bordered align-middle">
                <tbody>
                    <?php
                    $pemeriksaanFisik = [
                        "Keadaan Umum",
                        "Kepala",
                        "Konjungtiva",
                        "Sclera",
                        "Bibir / Lidah",
                        "Mukosa",
                        "Leher",
                        "Deviasi trakea",
                        "JVP",
                        "LNN",
                        "Tiroid",
                        "Thorax",
                        "Jantung",
                        "Paru",
                        "Abdomen & Pelvis",
                        "Punggung & Pinggang",
                        "Genitalia",
                        "Ekstremitas",
                        "Pemeriksaan Lain"
                    ];
                    foreach ($pemeriksaanFisik as $pf) {
                        $name = strtolower(str_replace([' ', '/'], ['_', ''], $pf));
                        echo "
                        <tr>
                            <td style='width:30%;' class='fw-bold'>$pf</td>
                            <td><textarea class='form-control' rows='2' name='$name'></textarea></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?= section("Pemeriksaan Penunjang") ?>
            <table class="table table-bordered align-middle">
                <tbody>
                    <?php
                    $pemeriksaanPenunjang = [
                        "Laboratorium",
                        "X-ray",
                        "ECG",
                        "CT Scan",
                        "USG",
                        "Lain-lain"
                    ];
                    foreach ($pemeriksaanPenunjang as $pp) {
                        $name = strtolower(str_replace([' ', '-'], ['_', ''], $pp));
                        echo "
                        <tr>
                            <td style='width:30%;' class='fw-bold'>$pp</td>
                            <td><textarea class='form-control' rows='2' name='$name'></textarea></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?= section("Assesmen") ?>
            <div class="mb-3"><label class="form-label fw-bold">Diagnosis Utama</label><textarea class="form-control" name="diagnosis_utama"></textarea></div>
            <div class="mb-3"><label class="form-label fw-bold">Diagnosis Sekunder</label><textarea class="form-control" name="diagnosis_sekunder"></textarea></div>

            <?= section("Planning") ?>
            <div class="mb-3"><label class="form-label fw-bold">Tindakan dan Terapi</label><textarea class="form-control" name="planning_tindakan_terapi"></textarea></div>

            <?= section("Tindak Lanjut") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tindak Lanjut</label>
                    <select class="form-select" name="tindaklanjut">
                        <option value="" disabled selected>Pilih...</option>
                        <option>Pulang</option>
                        <option>MRS di ruang</option>
                        <option>Menolak tindakan / MRS</option>
                        <option>Dirujuk ke RS</option>
                        <option>Meninggal</option>
                        <option>DOA</option>
                    </select>
                    <div class="mt-2" id="input_tindaklanjut">
                        <input type="text" class="form-control form-control-sm mt-1" name="ruang_mrs" placeholder="Nama Ruang" style="display:none;">
                        <input type="text" class="form-control form-control-sm mt-1" name="rs_rujuk" placeholder="Nama RS" style="display:none;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Dokter yang Merawat / DPJP</label>
                    <input type="text" class="form-control" name="dpjp">
                </div>
            </div>

            <?= section("Tanda Tangan") ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Terang dan Tanda Tangan</label>
                    <input type="text" class="form-control" name="ttd_dokter_jaga">
                    <small class="form-text text-muted">DOKTER JAGA</small>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary">Cetak PDF</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Skrip untuk Tindak Lanjut
        const tindaklanjutDropdown = document.querySelector('select[name="tindaklanjut"]');
        const ruangMrsInput = document.querySelector('input[name="ruang_mrs"]');
        const rsRujukInput = document.querySelector('input[name="rs_rujuk"]');

        tindaklanjutDropdown.addEventListener('change', function() {
            ruangMrsInput.style.display = 'none';
            rsRujukInput.style.display = 'none';
            if (this.value === 'MRS di ruang') {
                ruangMrsInput.style.display = 'block';
            } else if (this.value === 'Dirujuk ke RS') {
                rsRujukInput.style.display = 'block';
            }
        });

        // Skrip untuk menghitung umur
        const tglLahirInput = document.getElementById('tgl_lahir_input');
        const umurInput = document.getElementById('umur_input');

        tglLahirInput.addEventListener('change', function() {
            if (this.value) {
                const birthDate = new Date(this.value);
                const today = new Date();
                let ageInYears = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                const dayDifference = today.getDate() - birthDate.getDate();

                if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
                    ageInYears--;
                }

                if (ageInYears > 0) {
                    umurInput.value = ageInYears + ' thn';
                } else {
                    let ageInMonths = monthDifference + (ageInYears * 12);
                    if (dayDifference < 0) {
                        ageInMonths--;
                    }
                    umurInput.value = ageInMonths + ' bln';
                }
            }
        });
    });
</script>

<?php include "../template/footer.php"; ?>