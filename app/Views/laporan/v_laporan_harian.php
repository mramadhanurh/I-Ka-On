<div class="col-md-12">
    <div class="card card-pink">
        <div class="card-header">
            <h3 class="card-title"><?= $subjudul ?></h3>
        </div>
        <div class="card-body">
            <div class="col-sm-8">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal :</label>
                    <div class="col-10 input-group">
                        <input type="date" name="tgl" id="tgl" class="form-control">
                        <span class="input-group-append">
                            <button onclick="ViewTabelLaporan()" class="btn btn-primary btn-flat">
                                <i class="fas fa-file-alt"></i> View Laporan
                            </button>
                            <button onclick="PrintLaporan()" class="btn btn-success btn-flat">
                                <i class="fas fa-print"></i> Print Laporan
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr>
                <div class="Tabel">
                    <!-- Tabel Laporan Harian akan di-load di sini -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function ViewTabelLaporan() {
        let tgl = $('#tgl').val();
        if (tgl == "") {
            Swal.fire('Tanggal Belum Dipilih!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('Laporan/ViewLaporanHarian') ?>",
                data: {
                    tgl: tgl,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        $('.Tabel').html(response.data);
                    }
                }
            });
        }
    }

    function PrintLaporan() {
        let tgl = $('#tgl').val();
        if (tgl == "") {
            Swal.fire('Tanggal Belum Dipilih!');
        } else {
            window.open('<?= base_url('Laporan/PrintLaporanHarian') ?>/' + tgl, 'NewWin', 'toolbar=no, width=1200, height=800, scrollbars=yes');
        }
    }
</script>
