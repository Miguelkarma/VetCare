<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
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
<div class="card card-outline 	rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of Categories<small><em>(Pet Types)</em></small></h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm "><span class="fas fa-plus"></span>  Add New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="60%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT * from `category_list` where delete_flag = 0 order by `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="truncate-1"><?php echo $row['name'] ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-warning"></span> Edit</a>
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
        $('#create_new').click(function(){
			uni_modal("Add New Category","categories/manage_category.php")
		})
        $('.edit_data').click(function(){
			uni_modal("Update Category Details","categories/manage_category.php?id="+$(this).attr('data-id'))
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Category permanently?","delete_category",[$(this).attr('data-id')])
		})
		$('.view_data').click(function(){
			uni_modal("Category Details","categories/view_category.php?id="+$(this).attr('data-id'))
		})
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 3 }
            ],
        });
	})
	function delete_category($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_category",
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