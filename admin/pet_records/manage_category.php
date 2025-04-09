<style>body{
        font-family: "Abel", sans-serif;
  font-weight: 400;
  font-style: normal;
  }</style>

<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `pet_records` where pet_id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="category-form" >
    <?php if(isset($_GET['id']) && !empty($_GET['id'])): ?>
    <input type="hidden" name="pet_id" value="<?php echo $_GET['id']; ?>">
<?php endif; ?>
        <input type="hidden" name="delete_flag" value="0"> 
        <div class="form-group">
    <?php $owner_name = $_settings->userdata('firstname'); ?>
    <label for="owner_firstname" class="control-label">Owners Name</label>
    <div class="form-control-static"><?php echo isset($owner_name) ? $owner_name : ''; ?></div>
    <input type="hidden" name="owner_id" id="owner_id" value="<?php echo $_settings->userdata('id'); ?>" required>
</div>
        <fieldset>
                    <legend class="text-muted">Pet Information</legend>
                    <div class="form-group">
                        <label for="category_id" class="control-label">Pet Type</label>
                        <select name="category_id" id="category_id" class="form-control form-control-border select2">
                            <option value="" ></option>
                            <?php 
                            $categories = $conn->query("SELECT * FROM category_list where delete_flag = 0 ".(isset($category_id) && !empty($category_id) ? " or id = '{$category_id}'" : "")." order by name asc");
                            while($row = $categories->fetch_assoc()):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= isset($category_id) && in_array($row['id'],explode(',', $category_id)) ? "selected" : "" ?> <?= $row['delete_flag'] == 1 ? "disabled" : "" ?>><?= ucwords($row['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pet_name" class="control-label">Pet Name</label>
                        <input type="text" name="pet_name" id="pet_name" class="form-control form-control-border" placeholder="Siberian Husky" value ="<?php echo isset($pet_name) ? $pet_name: '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="breed" class="control-label">Breed</label>
                        <input type="text" name="breed" id="breed" class="form-control form-control-border" placeholder="Siberian Husky" value ="<?php echo isset($breed) ? $breed : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="age" class="control-label">Age</label>
                        <input type="text" name="age" id="age" class="form-control form-control-border" placeholder="1 yr. old" value ="<?php echo isset($age) ? $age : '' ?>" required>
                    </div>
                    <div class="form-group">
                    <label for="description" class="control-label">Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile1" name="img" onchange="displayImg(this,$(this))" accept=".png, .jpg, .jpeg, .ico">
                        <label class="custom-file-label" for="customFile1">Choose file</label>
                    </div>
                    </div>
                    <div class="form-group d-flex w-100 justify-content-center">
                        <img src="<?php echo validate_image($image_path ?? $_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                    </div>
                </fieldset>
    </form>
</div>
<script>
    	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

    $('#category_id').select2({
                placeholder:"Please Select Pet Type here.",
                width:'100%',
                dropdownParent:$('#uni_modal')
        })

    $(document).ready(function(){
		$('#category-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_petrecords",
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
        alert_toast(resp.msg, 'success')
        // Add a delay before reloading to allow the toast to display
        setTimeout(function(){
            location.reload()
        }, 1500); // 1.5 seconds delay
    }else if(resp.status == 'failed' && !!resp.msg){
        var el = $('<div>')
            el.addClass("alert alert-danger err-msg").text(resp.msg)
            _this.prepend(el)
            el.show('slow')
            $("html, body").scrollTop(0);
            end_loader()
    }else{
        alert_toast("An error occured",'error');
        end_loader();
        console.log(resp)
    }
}
			})
		})

	})
</script>