<?php echo form_open('forums/tambah_category/'.$f, array('id' => 'formTambah')); ?>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-4">Nama Kategori</label>
    <div class="col-md-8">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kategori Baru">
    </div>
</div>
<div class="form-group row">
    <label for="deskripsi" class="col-form-label col-md-4">Deskripsi</label>
    <div class="col-md-8">
        <textarea name="deskripsi" id="deskripsi" cols="5" rows="5" class="form-control" placeholder="Penjelasan tentang Kategori baru"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="jurusan" class="col-form-label col-md-4">Jurusan</label>
    <div class="col-md-8">
        <select name="jurusan" id="jurusan" class="form-control">
            <option value="" selected disabed>-</option>
            <option value="FTI">Fakultas Teknologi Informasi</option>
            <option value="FIKOM">Fakultas Ilmu Komunikasi</option>
            <option value="FT">Fakultas Teknik</option>
            <option value="FEB">Fakultas Ekonomi Dan Bisnis</option>
            <option value="FISIP">Fakultas Ilmu Sosial Politik</option>
        </select>
    </div>
</div>
<?php echo form_close(); ?>
<div id="result"></div>
<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalHeader').html('Tambah Kategori');
        $('#ModalFooter').html(btn);

        $('#Yes').click(function(e){
            e.preventDefault();
            var url = "<?php echo $f; ?>";

            $.ajax({
                url: $('#formTambah').attr('action'),
                type: 'POST',
                data: $('#formTambah').serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#Yes').html('<i class="mdi mdi-loading mdi-spin"> Menunggu respon server.....</i>');
                    $('#Yes').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == 'success'){
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<a href="<?php echo base_url(); ?>forums/'+url+'" class="btn btn-primary">Ok</a>');
                            $('#ModalGue').modal('show');
                        }else{
                            $('#result').html(data.pesan);
                            $('#result').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#Yes').html('Simpan Data');
                            $('#Yes').removeClass('disabled');
                        }
                    }, 500);
                },
                error: function(){
                    setTimeout(function(){
                        $('#result').html('<font style="color:red" size="3">Terjadi kesalahan pada <b>Side-Server</b>. Silahkan Hubungi <b>Developer</b>.</font>');
                        $('#result').fadeIn('fast').show().delay(4000).fadeOut('slow');
                        $('#Yes').html('Simpan Data');
                        $('#Yes').removeClass('disabled');
                    }, 500);
                }
            })
        })
    });
</script>