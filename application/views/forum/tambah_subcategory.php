<?php echo form_open('forums/tambah_subcategory/'.$f, array('id' => 'formTambah')); ?>
<div class="form-group row">
    <label for="kategori" class="col-form-label col-md-4">Kategori</label>
    <div class="col-md-8">
        <select name="kategori" id="kategori" class="form-control">
            <option value="" selected disabed>-</option>
            <?php foreach($kategori AS $row){ ?>
            <option value="<?= $row->id_forkat; ?>"><?= $row->jurusan." - <b>".$row->nama_category."</b>"; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-4">Nama Subkategori</label>
    <div class="col-md-8">
        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Subkategori Baru">
    </div>
</div>
<div class="form-group row">
    <label for="deskripsi" class="col-form-label col-md-4">Deskripsi</label>
    <div class="col-md-8">
        <textarea name="deskripsi" id="deskripsi" cols="5" rows="5" class="form-control" placeholder="Penjelasan tentang Subkategori baru"></textarea>
    </div>
</div>
<?php echo form_close(); ?>
<div id="result"></div>
<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="Yes">Simpan Data</button>';
        $('#ModalHeader').html('Tambah Subkategori');
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