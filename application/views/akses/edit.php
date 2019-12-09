<?php echo form_open('akses/edit/'.$id, ['id' => 'formEdit']); ?>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama Akses</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $akses->nama_akses; ?>" placeholder="Nama untuk Akses">
    </div>
</div>
<div class="form-group row">
    <label for="hak" class="col-form-label col-md-3">Hak</label>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="custom-control custom-checkbox" style="margin-top: 5px;">
                    <input type="checkbox" class="custom-control-input" id="c" name="buat" value="c" <?php if(substr($akses->hak, 0, 1) == 'c')echo "checked"; ?>>
                    <label class="custom-control-label" for="c" style="margin-top: 5px;">Membuat</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-control custom-checkbox" style="margin-top: 5px;">
                    <input type="checkbox" class="custom-control-input" id="r" name="baca" value="r" <?php if(substr($akses->hak, 0, 1) == 'r' || strpos($akses->hak, 'r'))echo "checked"; ?>>
                    <label class="custom-control-label" for="r" style="margin-top: 5px;">Membaca</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-control custom-checkbox" style="margin-top: 5px;">
                    <input type="checkbox" class="custom-control-input" id="u" name="ubah" value="u" <?php if(substr($akses->hak, 0, 1) == 'u' || strpos($akses->hak, 'u'))echo "checked"; ?>>
                    <label class="custom-control-label" for="u" style="margin-top: 5px;">Mengubah</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-control custom-checkbox" style="margin-top: 5px;">
                    <input type="checkbox" class="custom-control-input" id="d" name="hapus" value="d" <?php if(substr($akses->hak, 0, 1) == 'd' || strpos($akses->hak, 'd'))echo "checked"; ?>>
                    <label class="custom-control-label" for="d" style="margin-top: 5px;">Menghapus</label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<div id="result"></div>

<script>
    $(document).ready(function(){
        var btn = "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
            btn += "<button type='button' class='btn btn-primary' id='Yes'>Simpan Data</button>";
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();

            if($('#nama').val() == ''){
                $('#result').html("<font style='color:red;' size='3'>Nama Akses Harus Disini</font>");
            }else{
                $('#result').html('');

                $.ajax({
                    url: $('#formEdit').attr('action'),
                    type: 'POST',
                    data: $('#formEdit').serialize(),
                    cache: false,
                    dataType: 'json',
                    beforeSend: function(){
                        $('#Yes').html("<i class='mdi mdi-loading mdi-spin'> Menunggu respon server.....</i>");
                        $('#Yes').addClass("disabled");
                    },
                    success: function(data){
                        setTimeout(function(){
                            if(data.status == 'success'){
                                $('#Yes').html("Simpan Data");
                                $('#Yes').removeClass('disabled');
                                $('#Notifikasi').html(data.pesan);
                                $('#Notifikasi').fadeIn('fast').show().delay(4000).fadeOut('slow');
                                $('#ModalGue').modal('hide');
                                $('#tableAkses').DataTable().ajax.reload(null, false);
                            }else{
                                $('#Yes').html('Simpan Data');
                                $('#Yes').removeClass('disabled');
                                $('#result').html(data.pesan);
                                $('#result').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            }
                        }, 1000);
                    }
                })
            }
        })
    });
</script>