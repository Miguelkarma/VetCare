<style>.card-outline{
		background-color:#000 !important
	}
		.btn{
	background-color:rgb(212, 197, 176)!important;
	border-radius:0.5em!important;
	      color:rgb(10, 7, 2) !important;
	}
	.table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}


.table {
  width: 100%;
  margin-bottom: 1rem;
  border: 1px solid #675640;
  border-collapse: collapse;
  color: rgb(37, 24, 6) !important;
}

.table th, .table td {
  border: 1px solid #675640;
  padding: 0.5rem;
  vertical-align: middle;
}


@media (max-width: 767.98px) {
  
  .table img {
    max-width: 80px;
    max-height: 60px;
  }
  
 
  .table {
    font-size: 0.85rem;
  }
  

  @media (max-width: 575.98px) {
    .table .mobile-hide {
      display: none;
    }
  }
}


.dropdown-menu {
  position: relative;
}
	</style>

<div class="card card-outline ">
	<div class="card-header">
		<h3 class="card-title">List of Appointments</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="25%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>Owner</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
                <?php $name = $_settings->userdata('id'); ?>
					<?php 
						$i = 1;
                        
						$qry = $conn->query("SELECT * from `appointment_list` WHERE owner_id = $name  order by unix_timestamp(`date_created`) desc ");
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
			_conf("Are you sure to delete this appointment permanently?","delete_appointment",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_appointment($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_appointment",
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