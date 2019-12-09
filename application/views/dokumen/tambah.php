<?= form_open_multipart('document/tambah', array('id' => 'formDocument')); ?>
<div class="form-group row">
    <label for="kategori" class="col-form-label col-md-3">Kategori</label>
    <div class="col-md-9">
        <select name="kategori" id="kategori" class="form-control">
            <option value="" selected disabled>-</option>
            <?php foreach($kategori AS $row){ ?>
            <option value="<?= $row->id_kategori; ?>"><?= $row->title; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="files" class="col-form-label col-md-3">File</label>
    <div class="col-md-9">
        <input type="file" class="form-control-file" id="files" name="files">
    </div>
</div>
<div class="form-group row">
    <label for="deskripsi" class="col-form-label col-md-3">Deskripsi</label>
    <div class="col-md-9">
        <textarea name="deskripsi" id="deskripsi" cols="5" rows="5" class="form-control" placeholder="Penjelasan tentang File tersebut"></textarea>
    </div>
</div>
<?= form_close(); ?>
<div id="respon"></div>

<script>
    $(document).ready(function(){
        var btn = '<button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();
            var formData = new FormData($('#formDocument')[0]);
            $.ajax({
                url: $('#formDocument').attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#Yes').html('<i class="mdi mdi-spin mdi-loading"> Menunggu respon server.....</i>');
                    $('#Yes').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == 'success'){
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                            $('#ModalGue').modal('hide');
                            $('#Notifikasi').html(data.pesan);
                            $('#Notifikasi').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#tableDocument').DataTable().ajax.reload(null, false);
                        }else{
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                            $('#respon').html(data.pesan);
                            $('#respon').fadeIn('fast').show().delay(4000).fadeOut('slow');
                        }
                    }, 2000);
                },
                error: function(){
                    setTimeout(function(){
                        $('#Yes').html('Simpan Data');
                        $('#Yes').removeClass('disabled');
                        $('#respon').html('<font style="color:red;" size="3">Terjadi Kesalahan pada <i>Side-Server</i>. Silahkan Periksa Kembali atau Hubungi <i><b>Developer</b></i>.</font>');
                        $('#respon').fadeIn('fast').show().delay(4000).fadeOut('slow');
                    }, 2000);
                }
            })
        })
    })
</script>