//asesmen_awal
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
