<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Staff</h4>
            <table class="table table-hover" id="tableStaff">
                <thead>
                    <tr>
                        <th><center>No</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Email</center></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
		var dataTable = $('#tableStaff').DataTable({
			serverSide: true,
			stateSave : false,
			bAutoWidth: true,
			oLanguage: {
				sSearch: "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				sLengthMenu: "_MENU_ &nbsp;&nbsp;Data Per Halaman",
				sInfo: "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				sInfoFiltered: "(difilter dari _MAX_ total data)", 
				sZeroRecords: "Pencarian tidak ditemukan", 
				sEmptyTable: "Belum ada Data di dalam Database", 
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
				url :"<?php echo site_url('staff/showAllData'); ?>",
				type: "post",
				error: function(){ 
					$("#tableStaff").append('<tbody><tr><th colspan="3"><center>Server bermasalah, Silahkan Hubungi <i>Developer</i></center></th></tr></tbody>');
				}
			}
		});

        setInterval(function(){
            $('#tableStaff').DataTable().ajax.reload(null, false);
        }, 1000);
	});
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>