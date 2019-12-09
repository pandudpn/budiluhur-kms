<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Dokumen - dokumen</h4>
            <table class="table table-bordered table-hover" id="tableDocument">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama File</center></th>
                        <th><center>Deskripsi</center></th>
                        <th><center>Ukuran File</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?php 
$tambahan = '';
if($this->session->userdata('akses') < 3){
    $tambahan .= "<a href='".site_url('document/tambah')."' style='margin-left:10px' class='btn btn-info' id='TambahDokumen'><i class='mdi mdi-plus'></i> Tambah</a>";
}
$tambahan .= "<span id='Notifikasi' style='display: none;margin-left:10px;'></span>";
?>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableDocument').DataTable({
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
				url :"<?php echo site_url('document/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableDocument").append('<tbody><tr><th colspan="4"><center>Tidak menemukan data di Server</center></th></tr></tbody>');
				}
			}
		});
	});

    $(document).on('click', '#TambahDokumen', function(e){
		e.preventDefault();
		
		$('#ModalHeader').html('Tambah Dokumen');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>