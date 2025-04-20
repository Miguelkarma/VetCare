<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
	.new{
		background-color: #eacda3 !important;
		border:none !important;
		   color:rgb(75, 49, 12) !important;
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
		<h3 class="card-title">List of System Users</h3>
		<div class="card-tools">
			<a href="?page=user/manage_user" class="new btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="table-responsive">
			<table class="table table-sm table-hover table-striped table-bordered ">
				<!-- <colgroup>
					<col width="5%">
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
				</colgroup> -->
				<thead>
					<tr>
						<th>#</th>
						<th>Avatar</th>
						<th>Name</th>
						<th>Username</th>
						<th>User Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name from `users` where id != '1' order by concat(firstname,' ',lastname) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['username'] ?></p></td>
							<td >
							<?php if($row['type'] == 1 ){?>
								<p class="m-0">Administrator</p>
							<?php }else if($row['type'] == 2 ){?>
								<p class="m-0">Staff</p>
							<?php }else{ ?>
								<p class="m-0">Client</p>
							<?php } ?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=user/manage_user&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
									<?php if($row['status'] != 1): ?>
				                    <a class="dropdown-item verify_user" href="javascript:void(0)" data-id="<?= $row['id'] ?>"  data-name="<?= $row['username'] ?>"><span class="fa fa-check text-primary"></span> Verify</a>
				                    <div class="dropdown-divider"></div>
									<?php endif; ?>
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
			_conf("Are you sure to delete this User permanently?","delete_user",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
		$('.verify_user').click(function(){
			_conf("Are you sure to verify <b>"+$(this).attr('data-name')+"<b/>?","verify_user",[$(this).attr('data-id')])
		})
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
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
			url:_base_url_+"classes/Users.php?f=verify_user",
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