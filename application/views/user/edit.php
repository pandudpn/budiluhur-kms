<?= form_open('user/edit/'.$id, array('id' => 'formUser')); ?>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $user->nama; ?>" placeholder="Masukan Nama Panjang" autofocus>
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-form-label col-md-3">Email</label>
    <div class="col-md-9">
        <input type="email" class="form-control" id="email" name="email" value="<?= $user->email; ?>" placeholder="example@email.com">
        <div id="cek_email"></div>
    </div>
</div>
<div class="form-group row">
    <label for="akses" class="col-form-label col-md-3">Tipe User</label>
    <div class="col-md-9">
        <select name="akses" id="akses" class="form-control">
            <option value="" selected disabled>-</option>
            <?php foreach($akses AS $row){ ?>
            <option value="<?= $row->id_akses; ?>" <?php if($user->id_akses == $row->id_akses) echo 'selected'; ?>><?= $row->nama_akses; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?= form_close(); ?>
<div id="respon"></div>

<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();

            var nama        = $('#nama').val();
            var email       = $('#email').val();
            var akses       = $('#akses').val();

            if(nama == '' || email == '' || akses == ''){
                $('#respon').html('<font style="color:red;" size="3">Data Tidak Boleh Kosong</font>');
            }else{
                $('#respon').html('');
                var formData = new FormData($('#formUser')[0]);

                $.ajax({
                    url: $('#formUser').attr('action'),
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
                                $('#tableUser').DataTable().ajax.reload(null, false);
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
        });
    });
</script>