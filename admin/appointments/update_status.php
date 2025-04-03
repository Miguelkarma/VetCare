
<div class="container-fluid">
    <form action="" id="update-form">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
        <?php 
        require_once('../../config.php');
						$i = 1;
                        $ap_id = $_GET['id'];
						$qry = $conn->query("SELECT * from `appointment_list` WHERE id='$ap_id' order by unix_timestamp(`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
                            $category_id = $row['category_id'];
                            $service_ids = $row['service_ids'];
                            $status = $row['status'];
                            


$service = "";
$total = 0;
$services = $conn->query("SELECT * FROM `service_list` where id in ({$service_ids}) order by `name` asc");
while($row2 = $services->fetch_assoc()){
    if(!empty($service)) $service .=", ";
    $service .=$row2['name'];
    $total = $total + $row2['fee'];
}
$service = (empty($service)) ? "N/A" : $service;

					?>

            <div class="form-group">
                <small class="text-muted ">Status</small>
                <select name="status" id="status" class="form-control form-control-sm form-control-border" required>
                    <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Pending</option>
                    <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Confirmed</option>
                    <option value="3" <?= isset($status) && $status == 3 ? "selected" : "" ?>>Cancelled</option>
                </select>
            </div>
            <fieldset>
             

                    <div class="form-group">
                        <label for="time_sched" class="control-label">Schedule Date</label>
                        <input type="date" name="schedule" id="schedule" class="form-control form-control-border" value ="<?php echo isset($row['schedule']) ? $row['schedule'] : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="time_sched" class="control-label">Schedule Time</label>
                        <input type="time" name="time_sched" id="time_sched" class="form-control form-control-border" placeholder="1 yr. old" value ="<?php echo isset($row['time_sched']) ? $row['time_sched'] : '' ?>" required>
                    </div>
             
            
               
                </fieldset>
        <?php endwhile; ?>
    </form>
</div>
<script>
    $(function(){
        $('#update-form').submit(function(e){
            e.preventDefault()
            var _this = $("#entry-form")
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=update_appointment_status",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload();
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html, body,.modal').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
        })

        $(document).ready(function(){
		 $('.summernote').summernote({
		        height: '20vh',
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
					['insert', ['link', 'picture']],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
	})

    })
</script>