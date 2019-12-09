<?= form_open('kategori/tambah', array('id' => 'formKategori')); ?>
<div class="form-group row">
    <label for="judul" class="col-form-label col-md-3">Judul</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Kategori" autofocus>
    </div>
</div>
<div class="form-group row">
    <label for="deskripsi" class="col-form-label col-md-3">Deskripsi</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Penjelesan Kategori">
    </div>
</div>
<?= form_close(); ?>
<div id="respon"></div>

<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="submit" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();
            simpanData();
        });

        $('#Yes').keypress(function(e){
            e.preventDefault();
            if(e.keyCode == 13 || e.which == 13){
                simpanData();
            }
        })
    });

    function simpanData(){
        $.ajax({
            url: $('#formKategori').attr('action'),
            type: 'POST',
            data: $('#formKategori').serialize(),
            cache: false,
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
                        $('#tableKategori').DataTable().ajax.reload(null, false);
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
                    $('#respon').html('<font style="color:red" size="3">Terjadi Kesalahan pada <i>Side-Server</i>. Silahkan Periksa Kembali atau Hubungi <i><b>Developer</b></i>.</font>');
                    $('#respon').fadeIn('fast').show().delay(4000).fadeOut('slow');
                }, 2000);
            }
        });
    }
</script>