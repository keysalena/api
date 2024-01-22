<?php

//$api_url = 'http://localhost/karyawan_api/phprestapi.php?function=get_karyawan';
// Read JSON file
//$json_data = file_get_contents($api_url);
// Decode JSON data into PHP array
//$response_data = json_decode($json_data);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/api_server/phprestapi.php?function=get_karyawan',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
// Decode JSON data into PHP array
$response_data = json_decode($response);
// All user data exists in 'data' object
$user_data = $response_data->data;

// Cut long data into small & select only first 10 records
//$user_data = array_slice($user_data, 0, 9);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP Mysql REST API CRUD</title>
		
		<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    	<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
	</head>
	<body>
		<div class="container">
			<br />
			
			<h3 align="center">PHP Mysql REST API CRUD</h3>
			<br />
			<div align="right" style="margin-bottom:5px;">
				<!-- <button type="button" name="add_button" id="add_button" class="btn btn-success btn-xs">Add</button> -->
				<a href="tambah.php" class="btn btn-md btn-success" style="margin-bottom: 10px">TAMBAH DATA HALAMAN</a>
				<a name="add_button" id="add_button" class="btn btn-md btn-success" style="margin-bottom: 10px">TAMBAH DATA MODAL</a>
			</div>

			<div class="table-responsive">
			<table id="myTable" class="table table-striped nowrap" style="width:100%" >
					<thead>
						<tr>
							<th>ID</th>
							<th>NAMA</th>
							<th>JENIS KELAMIN</th>
							<th>ALAMAT</th>
							<th>AKSI</th>
							
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ($user_data as $user) {
					?>
					<tr>
                      <!-- <td><?php //echo $no++ ?></td> -->
                      <td><?php echo $user->id ?></td>
                      <td><?php echo $user->nama ?></td>
                      <td><?php echo $user->jenis_kelamin ?></td>
                      <td><?php echo $user->alamat ?></td>
                      <td>
                        <a href="edit.php?id=<?php echo $user->id ?>" class="btn btn-sm btn-primary">EDIT</a>
                        <a href="hapus.php?id=<?php echo $user->id ?>" class="btn btn-sm btn-danger">HAPUS</a>
                      </td>
                  </tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<div id="apicrudModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="api_crud_form">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Add Data</h4>
		      	</div>
		      	<div class="modal-body">		      		
			        <div class="form-group">
			        	<label>NAMA</label>
			        	<input type="text" name="nama" id="nama" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>JENIS KELAMIN</label>
			        	<input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label>ALAMAT</label>
			        	<input type="text" name="alamat" id="alamat" class="form-control" />
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<input type="hidden" name="hidden_id" id="hidden_id" />
			    	<input type="hidden" name="action" id="action" value="insert" />
			    	<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      		</div>
			</form>
		</div>
  	</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#add_button').click(function(){
		$('#action').val('insert');
		$('#button_action').val('Insert');
		$('.modal-title').text('Add Data');
		$('#apicrudModal').modal('show');
	});
});

$(document).ready(function() {
      $('#myTable').DataTable( {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );
} );
</script>