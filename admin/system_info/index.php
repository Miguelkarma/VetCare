<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php if($_settings->chk_flashdata('error')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('error') ?>",'error')
</script>
<?php endif;?>


<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: scale-down;
		border-radius: 100% 100%;
	}
	img#cimg2{
		height: 50vh;
		width: 100%;
		object-fit: contain;
		/* border-radius: 100% 100%; */
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
</style>
<div class="col-lg-12">
	<div class="card card-outline rounded-0 shadow">
		<div class="card-header">
			<h5 class="card-title">System information</h5>
			<!-- <div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-info new_department" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div> -->
		</div>
		<div class="card-body">
			<form action="" id="system-frm">
			<div id="msg" class="form-group"></div>
			<div class="form-group">
				<label for="name" class="control-label">System Name </label>
				<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo $_settings->info('name') ?>">
			</div>
			<div class="form-group">
				<label for="short_name" class="control-label">System Short Name1 </label>
				<input type="text" class="form-control form-control-sm" name="short_name" id="short_name" value="<?php echo  $_settings->info('short_name') ?>">
			</div>
			<div class="form-group">
				<label for="content[about_us]" class="control-label">About Us</label>
				<textarea type="text" class="form-control form-control-sm summernote" name="content[about_us]" id="about_us"><?php echo  is_file(base_app.'about_us.html') ? file_get_contents(base_app.'about_us.html') : '' ?></textarea>
			</div>
			<div class="form-group">
				<label for="" class="control-label">System Logo</label>
				<div class="custom-file">
	              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
	              <label class="custom-file-label" for="customFile">Choose file</label>
	            </div>
			</div>
			<div class="form-group d-flex justify-content-center">
				<img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
			
			<fieldset>
				<legend>Other information</legend>
				<div class="form-group">
    <label for="contact" class="control-label">Contact Number</label>
    <input type="tel" class="form-control form-control-sm" name="contact" id="contact" 
           value="<?php echo $_settings->info('contact') ?>"
           maxlength="13" 
           placeholder="09XXXXXXXXX or +639XXXXXXXX" 
           oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
    <small id="contact-error" class="text-danger" style="display:none;"></small>
</div>
<div class="form-group">
    <label for="contact2" class="control-label">Secondary Contact Number (Optional)</label>
    <input type="tel" class="form-control form-control-sm" name="contact2" id="contact2" 
           value="<?php echo $_settings->info('contact2') ?>"
           maxlength="13" 
           placeholder="09XXXXXXXXX or +639XXXXXXXX" 
           oninput="this.value = this.value.replace(/[^0-9+]/g, '')">
    <small id="contact2-error" class="text-danger" style="display:none;"></small>
</div>
				<div class="form-group">
					<label for="address" class="control-label">Clinic Address</label>
					<textarea rows="3" class="form-control form-control-sm" name="address" id="address" style="resize:none"><?php echo $_settings->info('address') ?></textarea>
				</div>
			</fieldset>
			<fieldset>
				<legend>Appointment information</legend>
				<div class="form-group">
					<label for="max_appointment" class="control-label">Maximum Patient a day</label>
					<input type="number" class="form-control form-control-sm col-sm-3" name="max_appointment" id="max_appointment" value="<?php echo $_settings->info('max_appointment') ?>">
				</div>
				<div class="form-group">
					<label for="clinic_schedule" class="control-label">Clinic Daily Schedule <small><em>i.e.(8:00 AM - 5:30 PM)</em></small></label>
					<input type="text" class="form-control form-control-sm col-sm-3" name="clinic_schedule" id="clinic_schedule" value="<?php echo $_settings->info('clinic_schedule') ?>">
				</div>
			</fieldset>
			</form>
		</div>
		<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-info" form="system-frm">Update</button>
				</div>
			</div>
		</div>

	</div>
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
	function displayImg2(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        	$('#cimg2').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	function displayImg3(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        	$('#cimg3').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		 $('.summernote').summernote({
		        height: '60vh',
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
	$(document).ready(function(){
    $('#system-frm').submit(function(e){
        e.preventDefault();
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_+"classes/SystemSettings.php?f=update_settings",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: function(err){
                console.log(err)
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp =='object' && resp.status == 'success'){
                    alert_toast(resp.msg, 'success');
                    location.reload();
                }else if(resp.status == 'failed' && !!resp.msg){
                    // This is where you'd display the specific error message
                    alert_toast(resp.msg, 'error');
                }else{
                    alert_toast("An error occurred", 'error');
                }
                end_loader();
            }
        })
    })
});

</script>