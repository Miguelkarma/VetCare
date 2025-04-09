<style>
	.card-outline{
		border:#000 !important
	}
		.btn{
	background-color:rgb(212, 197, 176)!important;
	border-radius:0.5em!important;
	      color:rgb(10, 7, 2) !important;
	}

	 body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }
  	.card{
background-color:rgb(255, 246, 235)!important;
box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
-webkit-box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
-moz-box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
 border-radius:0.5em!important;
	}
  .table {
    border: 1px solid #675640; /* Set the border for the table */
    border-collapse: collapse; /* Ensures borders are merged */
 color:rgb(37, 24, 6) !important;
}

.table th, .table td {
    border: 1px solid #675640; /* Set borders for table cells */
}
	</style>

<div class="card card-outline ">
	<div class="card-header">
		<h3 class="card-title">List of Appointments</h3>
        <div class="card-tools">
			<a href="http://localhost/ovas/?page=appointment"  class="btn btn-flat btn-sm "><span class="fas fa-plus"></span>  Add New Appointment</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="table-responsive">
			<table class="table table-sm table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
					<col width="30%">

				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>Owner</th>
						<th>Status</th>
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
                <?php $name = $_settings->userdata('id'); ?>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `appointment_list` WHERE owner_id = $name order by unix_timestamp(`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo ($row['code']) ?></td>
							<td class=""><p class="truncate-1"><?php echo ucwords($row['owner_name']) ?></p></td>
							<td class="text-center">
								<?php 
									switch ($row['status']){
										case 0:
											echo '<span class="rounded-pill badge badge-warning">Pending</span>';
											break;
										case 1:
											echo '<span class="rounded-pill badge badge-success">Confirmed</span>';
											break;
										case 3:
											echo '<span class="rounded-pill badge badge-danger">Cancelled</span>';
											break;
									}
								?>
							</td>

							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>

				                  <div class="dropdown-menu" role="menu">
								  <a class="dropdown-item" href="./?page=appointment_user/view_details&id=<?php echo $row['id'] ?>" data-id=""><span class="fa fa-window-restore text-gray"></span> View</a>
								  <?php if($row['status'] <= 0): ?> 
								  <div class="dropdown-divider"></div>
				                  <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Cancel</a>
									<?php endif; ?>  
								</div>

							</td>

						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to cancel this appointment permanently?","delete_appointment",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });
	})
	function delete_appointment($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=cancel_appointment",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>