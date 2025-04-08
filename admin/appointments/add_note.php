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

   
            <fieldset>
                    <legend class="text-muted">Pet Information</legend>
                    <div class="form-group">
                    <input type="hidden" name="owner_id" id="owner_id" class="form-control form-control-border" placeholder="Siberian Husky" value ="<?php echo isset($row['owner_id']) ? $row['owner_id']: '' ?>" required>
                    </div>
                    <div class="form-group">
                    <label for="breed" class="control-label">Pet Type</label>
                    <input type="hidden" name="pet_id" id="pet_id" class="form-control form-control-border" placeholder="Siberian Husky" value ="<?php echo isset($row['pet_id']) ? $row['pet_id'] : '' ?>" required>
                    
                    <select name="category_id" id="category_id" class="form-control form-control-border select2">
                            <option value="" selected disabled></option>
                            <?php 
                            $categories = $conn->query("SELECT * FROM category_list where delete_flag = 0 ".(isset($category_id) && !empty($category_id) ? " or id = '{$category_id}'" : "")." order by name asc");
                            while($row1 = $categories->fetch_assoc()):
                            ?>
                            <option value="<?= $row1['id'] ?>" <?= isset($category_id) && in_array($row1['id'],explode(',', $category_id)) ? "selected" : "" ?> <?= $row1['delete_flag'] == 1 ? "disabled" : "" ?>><?= ucwords($row1['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="breed" class="control-label">Breed</label>
                        <input type="text" name="breed" id="breed" class="form-control form-control-border" placeholder="Siberian Husky" value ="<?php echo isset($row['breed']) ? $row['breed'] : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="age" class="control-label">Age</label>
                        <input type="text" name="age" id="age" class="form-control form-control-border" placeholder="1 yr. old" value ="<?php echo isset($row['age']) ? $row['age'] : '' ?>" required>
                    </div>
                    <div class="form-group">
                    <tr class="border-info">
                                                    <th class="py-1 px-2 text-light bg-gradient-info">Service(s) Needed :</th>
                                                    <td class="py-1 px-2 text-right"><?= ($service) ?></td>
                                                </tr>
                            </div>

                    
                    <div class="form-group">
				    <label for="notes" class="control-label">Doctor's Note</label>
				    <textarea type="text" class="form-control form-control-sm summernote" name="notes" id="notes"></textarea>
			        </div>
    
                    <div class="form-group">
                        <input type="hidden" name="service_ids" id="service_ids" class="form-control form-control-border" placeholder="1 yr. old" value ="<?php echo isset($row['service_ids']) ? $row['service_ids'] : '' ?>" required>
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
                url:_base_url_+"classes/Master.php?f=add_doctor_note",
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