<input type="hidden" name="dari" id="dari" value="<?php echo $pesan->id_message; ?>">
<div class="form-group row">
    <label for="nama" class="col-form-label col-md-3">Nama</label>
    <div class="col-md-9" style="margin-top:6.5px;">
        <p><?php echo $pesan->nama; ?></p>
    </div>
</div>
<div class="form-group row">
    <label for="subject" class="col-form-label col-md-3">Subjek</label>
    <div class="col-md-9" style="margin-top:6.5px;">
        <p><?php echo $pesan->subject; ?></p>
    </div>
</div>
<div class="form-group row">
    <label for="isi" class="col-form-label col-md-3">Isi</label>
    <div class="col-md-9" style="margin-top:6.5px;">
        <p><?php echo $pesan->isi; ?></p>
    </div>
</div>
<?php if($pesan->file_name != ''){ ?>
<div class="form-group row">
    <label for="lampiran" class="col-form-label col-md-3">Lampiran</label>
    <div class="col-md-9" style="margin-top:6.5px;">
        <div class="row">
            <?php foreach($p->result() AS $row){ ?>
            <div class="col-md-4">
                <?php if(strlen($row->raw_name) > 7){ ?>
                <a title="<?= $row->file_name; ?>" href="<?= base_url('pesan/attachmentInboxDownload/'.$row->id_upload.'/'.$row->id_message.'/'.$row->file_download); ?>"><?= substr($row->raw_name, 0, 7). '....'.$row->extension; ?></a>
                <?php }else{ ?>
                <a title="<?= $row->file_name; ?>" href="<?= base_url('pesan/attachmentInboxDownload/'.$row->id_upload.'/'.$row->id_message.'/'.$row->file_download); ?>"><?= $row->raw_name."".$row->extension; ?></a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<script>
    $(document).ready(function(){
        var id  = $('#dari').val();
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<a href="<?php echo base_url(); ?>pesan/balasinbox/'+id+'" id="Balas" class="btn btn-primary">Balas</a>';

        $('#ModalFooter').html(btn);
    });
</script>