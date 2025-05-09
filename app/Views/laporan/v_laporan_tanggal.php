<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>
        </div>
        <div class="card-body">
            <div class="col-sm-8">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal :</label>
                    <div class="col-10 input-group">
                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control">
                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                        <span class="input-group-append">
                            <a id="exportExcel" href="#" class="btn btn-success btn-flat">
                                <i class="fas fa-print"></i> Export Excel
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr>
                <div class="Tabel">
                    <!-- Tabel Laporan Tanggal akan di-load di sini -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('exportExcel').addEventListener('click', function() {
        const tglMulai = document.getElementById('tgl_mulai').value;
        const tglSelesai = document.getElementById('tgl_selesai').value;

        if (tglMulai && tglSelesai) {
            const url = `<?= base_url('Laporan/exportExcelTanggal') ?>?tgl_mulai=${tglMulai}&tgl_selesai=${tglSelesai}`;
            this.setAttribute('href', url);
        } else {
            Swal.fire('Harap isi rentang tanggal!');
        }
    });
</script>