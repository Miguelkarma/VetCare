<?php 

if(isset($_GET['id'])){
    $qry = $conn->query("SELECT a.*,c.name as pet_type from `appointment_list` a inner join category_list c on a.category_id = c.id where a.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }else{
    echo "<script>alert('Unknown Appointment Request ID'); location.replace('./?page=appointments');</script>";
    }
}
else{
    echo "<script>alert('Appointment Request ID is required'); location.replace('./?page=appointments');</script>";
}
$service = "";
$total = 0;
$services = $conn->query("SELECT * FROM `service_list` where id in ({$service_ids}) order by `name` asc");
while($row = $services->fetch_assoc()){
    if(!empty($service)) $service .=", ";
    $service .=$row['name'];
    $total = $total + $row['fee'];
}
$service = (empty($service)) ? "N/A" : $service;

?>
<style>
    @media screen {
        .show-print{
            display:none;
        }
    }
    img#appointment-banner{
		height: 45vh;
		width: 20vw;
		object-fit: scale-down;
		object-position: center center;
	}
    .table.border-warning tr, .table.border-warning th, .table.border-warning td{
        border-color:var(--dark);
    }
    .det{
        color:rgb(75, 49, 12) !important;
    }
    .btn-flat{

        
        border-radius:0.3em!important;
        border:none!important;
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
</style>
<div class="content py-3">
    <div class="card card-outline  rounded-0">
        <div class="card-header rounded-0">
            <h5 class="card-title ">Appointment Request Details</h5>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div id="outprint">
                    <fieldset>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered border-warning">
                                    <colgroup>
                                        <col width="30%">
                                        <col width="70%">
                                    </colgroup>
                                    <tr>
                                        <th class=" px-2 py-1 det" style="background-color:#C7B299;">Appointment Request Code</th>
                                        <td><?= ($code) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend class="  border-bottom">Owner information</legend>
                                        <table class="table table-stripped table-bordered" data-placeholder='true' id="">
                                            <colgroup>
                                                <col width="70%">
                                                <col width="30%">
                                            </colgroup>
                                            <tbody>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Name</th>
                                                    <td class="py-1 px-2 text-right"><?= ucwords($owner_name) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Contact Number</th>
                                                    <td class="py-1 px-2 text-right"><?= ($contact) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Email</th>
                                                    <td class="py-1 px-2 text-right"><?= ($email) ?></td>
                                                </tr><tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Address</th>
                                                    <td class="py-1 px-2 text-right"><?= ($address) ?></td>
                                                </tr>
                                                </tr><tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Clinic Schedule</th>
                                                    <td class="py-1 px-2 text-right"><?= ($schedule) ?></td>
                                                </tr>
                                                </tr><tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Time Schedule</th>
                                                    <td class="py-1 px-2 text-right"><?= ($time_sched) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend class=" border-bottom">Pet information</legend>
                                        <table class="table table-stripped table-bordered" data-placeholder='true'>
                                            <colgroup>
                                                <col width="70%">
                                                <col width="30%">
                                            </colgroup>
                                            <tbody>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Pet Type</th>
                                                    <td class="py-1 px-2 text-right"><?= ($pet_type) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Breed</th>
                                                    <td class="py-1 px-2 text-right"><?= ($breed) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Age</th>
                                                    <td class="py-1 px-2 text-right"><?= ($age) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Service(s) Needed</th>
                                                    <td class="py-1 px-2 text-right"><?= ($service) ?></td>
                                                </tr>
                                                <tr class="border-warning">
                                                    <th class="py-1 px-2 det" style="background-color:#C7B299;">Total Fee</th>
                                                    <td class="py-1 px-2 text-right">Php <?= ($total) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <small class=" px-2">Status</small><br>
                                    <?php 
    switch ($status){
        case 0:
            echo '<span class="rounded-pill badge badge-warning">Pending</span>';
            break;
        case 1:
            echo '<span class="rounded-pill badge badge-success">Confirmed</span>';
            break;
        case 2:
            echo '<span class="rounded-pill badge badge-info">Completed</span>';
            break;
        case 3:
            echo '<span class="rounded-pill badge badge-danger">Cancelled</span>';
            break;
        case 4:
            echo '<span class="rounded-pill badge badge-dark">No Show</span>';
            break;
    }
?>
                                </div>
                            </div>
                    </fieldset>
                </div>
                
                <hr>
                <div class="rounded-0 text-center mt-3">
                <?php if($status <= 0): ?>
                        
                <?php endif; ?>
                <a class="btn btn-sm btn-flat btn-success" href="javascript:void(0)" id="update_status"><i class="fa fa-edit"></i> Update Status</a>
                        
                        <button class="btn btn-flat btn-sm bg-danger  border-0"  id="delete_data"><i class="fa fa-trash"></i> Delete</button>
                        <a class="btn btn-light border border-0 bg-light btn-sm" href="./?page=appointments" ><i class="fa fa-angle-left"></i> Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#delete_data').click(function(){
			_conf("Are you sure to delete <b><?= $code ?>\'s</b> from appointment permanently?","delete_appointment",['<?= $id ?>'])
		})
        $('#update_status').click(function(){
            uni_modal("Update Status","appointments/update_status.php?id=<?= $id ?>&status=<?= $status ?>")
        })
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
					location.replace('./?page=appointments');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>