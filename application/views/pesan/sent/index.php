<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="mdi mdi-email-check"></i> Pesan Terkirim</h4>
            <table class="table table-hover" id="tableOutbox">
                <thead>
                    <tr>
                        <th><center>Pesan Untuk</center></th>
                        <th><center>Subject</center></th>
                        <th><center>Isi</center></th>
                        <th><center>Tanggal</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableOutbox').DataTable({
			serverSide: true,
			stateSave : false,
			bAutoWidth: true,
			oLanguage: {
				sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman",
				sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				sInfoFiltered: "(difilter dari _MAX_ total data)", 
				sZeroRecords: "Pencarian tidak ditemukan", 
				sEmptyTable: "Kamu belum melakukan Pengiriman Pesan", 
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
				url :"<?php echo site_url('pesan/KotakKeluar'); ?>",
				type: "post",
				error: function(){ 
					$("#tableOutbox").append('<tbody><tr><th colspan="4"><center>Server bermasalah, Silahkan Hubungi <i>Developer</i></center></th></tr></tbody>');
				}
			}
		});

        setInterval(function(){
            $('#tableOutbox').DataTable().ajax.reload(null, false);
        }, 1000);
	});

	$(document).on('click', '.detailOutbox', function(e){
		e.preventDefault();

		$('#ModalHeader').html('Pesan Terkirim');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
		$('#ModalGue').modal('show');
	})
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>