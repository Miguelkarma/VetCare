<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
		.btn{
	background-color:rgb(212, 197, 176)!important;
	border-radius:0.5em!important;
	      color:rgb(10, 7, 2) !important;
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
  .modal-content{
 background-color:#ebe5dd!important;
 	      color:rgb(10, 7, 2) !important;
        }
		.modal-header{
			border:none!important;
		}
		.modal-footer{
			border:none!important;
		}	
	body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
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
<div class="card card-outline  rounded-0">
	<div class="card-header">
		<h3 class="card-title">List of Inquiries</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="table-responsive">
			<table class="table table-sm table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="30%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Inquirer</th>
						<th>Email</th>
						<th>Message</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `message_list`  order by status asc, unix_timestamp(date_created) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo ucwords($row['fullname']) ?></td>
							<td><?php echo ($row['email']) ?></td>
							<td class="truncate-1"><?php echo ($row['message']) ?></td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-pill badge-success">Read</span>
								<?php else: ?>
								<span class="badge badge-pill badge-warning">Unread</span>
								<?php endif; ?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
			_conf("Are you sure to delete this Inquiry permanently?","delete_message",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.view_details').click(function(){
			uni_modal('Inquiry Details',"inquiries/view_details.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.table').dataTable();
		$('#uni_modal').on('hide.bs.modal',function(){
			location.reload()
		})
	})
	function delete_message($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_message",
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
	function verify_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=verify_inquiries",
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