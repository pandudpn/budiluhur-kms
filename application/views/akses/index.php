<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Hak Akses</h4>
            <table class="table table-bordered table-hover" id="tableAkses">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Membuat</center></th>
                        <th><center>Membaca</center></th>
						<th><center>Mengubah</center></th>
                        <th><center>Menghapus</center></th>
						<th><center>Hapus</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php 
$tambahan = '';
$tambahan .= "<a href='".site_url('akses/tambah')."' style='margin-left:10px' class='btn btn-info' id='TambahUser'><i class='mdi mdi-plus'></i> Tambah</a>";
$tambahan .= "<span id='Notifikasi' style='display: none;margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableAkses').DataTable({
			serverSide: true,
			stateSave : false,
			bAutoWidth: true,
			oLanguage: {
				sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				sInfoFiltered: "(difilter dari _MAX_ total data)", 
				sZeroRecords: "Pencarian tidak ditemukan", 
				sEmptyTable: "Belum ada data di dalam Database!", 
				sLoadingRecords: "Harap Tunggu...", 
				oPaginate: {
					sPrevious: "Prev",
					sNext: "Next"
				}
			},
			columnDefs: [ 
				{
					targets: 'no-sort',
					orderable: false,
				}
	        ],
			sPaginationType: "simple_numbers", 
			iDisplayLength: 10,
			aLengthMenu: [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			ajax:{
				url :"<?php echo site_url('akses/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableAkses").append('<tbody><tr><th colspan="6"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

	$(document).on('click', '#HapusAkses', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus ini?');
		$('#ModalFooter').html("<button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button><button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"'>Ya, saya yakin</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
            beforeSend: function(){
                $('#Notifikasi').html('<font size="2"><i class="mdi mdi-loading mdi-spin"> Memproses....</i></font>');
                $('#Notifikasi').fadeIn('fast').show();
            },
			success: function(data){
				setTimeout(function(){
                    if(data.status == 'success'){
						$('#Notifikasi').html(data.pesan);
						$("#Notifikasi").delay(4000).fadeOut('slow');
						$('#tableAkses').DataTable().ajax.reload( null, false );
					}else{
						$('#ModalHeader').html('<div class="col"><div class="text-center">Error</div></div>');
						$('#ModalContent').html(data.pesan);
						$('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
						$('#ModalGue').modal('show');
					}
                }, 2000)
			},
			error: function(){
				setTimeout(function(){
					$('#ModalHeader').html('<div class="col"><div class="text-center">Error</div></div>');
					$('#ModalContent').html('<font style="color:red;" size="3">Terjadi Kesalahan, Silahkan Periksa Kembali atau Hubungi <i><b>Developer</b></i>.</font>');
					$('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
					$('#ModalGue').modal('show');
				}, 2000);
			}
		});
	});

	$(document).on('keyup', '#nama', function(e){
        e.preventDefault();

		var nama = $(this).val();
		$.ajax({
			url: '<?php echo base_url(); ?>akses/cek_nama_akses',
			type: 'POST',
			data: 'nama='+nama,
			dataType: 'json',
			cache: false,
			success: function(data){
				if(data.status == 0){
					$('#cek_nama').html(data.pesan);
					$('#Yes').addClass('disabled');
				}else if(data.status == 1){
					$('#cek_nama').html(data.pesan);
					$('#Yes').removeClass('disabled');
				}
			}
		});
    });

	$(document).on('click', '#EditAkses', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Edit Akses');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

    $(document).on('click', '#TambahUser', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Tambah Akses');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>