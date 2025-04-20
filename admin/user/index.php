<?php 
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
    $meta[$k] = $v;
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
	.card{
      background-color:rgb(255, 246, 235)!important;
      box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
      -webkit-box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
      -moz-box-shadow: 6px 7px 28px -11px rgba(0,0,0,1);
      border-radius:0.5em!important;
	}
	.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color:rgb(156, 140, 122);        
        border-color: rgb(156, 140, 122);
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group col-6">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>">
				</div>
				<div class="form-group col-6">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" >
				</div>
				<div class="form-group col-6">
					<label for="username">Username/email</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>"   autocomplete="off">
				</div>
				<div class="form-group col-6">
                    <label for="contact">Contact Info</label>
                    <input type="tel" name="contact" id="contact" class="form-control" 
                           maxlength="13" 
                           placeholder="09XXXXXXXXX or +639XXXXXXXXX"
                           oninput="this.value = this.value.replace(/[^0-9+]/g, '')"
                           value="<?php echo isset($meta['contact']) ? $meta['contact']: '' ?>">
                    <small class="text-muted">Must be a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)</small>
                    <small id="contact_error" class="text-danger" style="display:none;"></small>
                </div>
				<div class="form-group col-6">
					<label for="address">Address</label>
					<textarea class="form-control" name="address" id="address" row="5"><?php echo isset($meta['address']) ? $meta['address']: '' ?></textarea>
				</div>
				
				<div class="password-section">
					<div class="form-group col-6">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="changePassword">
							<label class="custom-control-label" for="changePassword">Change Password</label>
						</div>
					</div>
					<div id="password-fields" style="display:none">
						<div class="form-group col-6">
							<label for="current_password">Current Password</label>
							<input type="password" name="current_password" id="current_password" class="form-control" autocomplete="off">
							<small class="text-secondary"><strong><i>Enter your current password to authorize the password change.</i></strong></small>
						</div>
						<div class="form-group col-6">
							<label for="new_password">New Password</label>
							<input type="password" name="new_password" id="new_password" class="form-control" autocomplete="off">
						</div>
						<div class="form-group col-6">
							<label for="confirm_password">Confirm New Password</label>
							<input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off">
							<small id="password_match_msg"></small>
						</div>
					</div>
				</div>
				
				<div class="form-group col-6">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-success mr-2" form="manage-user" id="submit_btn">Update Account</button>
			</div>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
	.password-match {
		color: green;
		font-weight: bold;
	}
	.password-mismatch {
		color: red;
		font-weight: bold;
	}
</style>
<script>
	function validateContactInfo() {
        var contactValue = $("#contact").val().trim();
        
        if (!(contactValue.match(/^09[0-9]{9}$/) || contactValue.match(/^\+639[0-9]{9}$/))) {
            $('#msg').html('<div class="alert alert-danger">Please enter a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)</div>');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
        return true;
    }
    
	$(function(){
		$('.select2').select2({
			width:'resolve'
		})
		
		// Toggle password fields
		$("#changePassword").on('change', function() {
			if($(this).is(":checked")) {
				$("#password-fields").slideDown();
			} else {
				$("#password-fields").slideUp();
				// Clear password fields when unchecked
				$("#current_password, #new_password, #confirm_password").val('');
				$("#password_match_msg").html('');
			}
		});
		
		// Password matching validation
		$("#confirm_password, #new_password").on('keyup', function() {
			validatePasswords();
		});
	})
	
	function validatePasswords() {
		var isValid = true;
		
		  
		if($("#changePassword").is(":checked")) {
        var newPassword = $("#new_password").val();
        var confirmPassword = $("#confirm_password").val();
        
        if(newPassword != "" || confirmPassword != "") {
            if(newPassword != confirmPassword) {
                $("#password_match_msg").html("Passwords do not match!").removeClass("password-match").addClass("password-mismatch");
                isValid = false;
            } else {
                $("#password_match_msg").html("Passwords match!").removeClass("password-mismatch").addClass("password-match");
            }
        } else {
            $("#password_match_msg").html("");
        }
    }
		
		return isValid;
	}
	
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		
		// validate contact information
        if(!validateContactInfo()) {
            return false;
        }
		
		// validate passwords if being changed
		if($("#changePassword").is(":checked")) {
        if(!validatePasswords()) {
            $('#msg').html('<div class="alert alert-danger">Please check your password entries</div>');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return false;
        }
    
			
		
		}
		
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					location.reload();
				} else if(resp == 2) {
					$('#msg').html('<div class="alert alert-danger">Current password is incorrect</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				} else if(resp == 3) {
					$('#msg').html('<div class="alert alert-danger">Username already exists</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				} else if(resp == 4) {
					$('#msg').html('<div class="alert alert-danger">New password and confirm password do not match</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				} else if(resp == 6) {
                    $('#msg').html('<div class="alert alert-danger">Please enter a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)</div>')
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                } else {
					$('#msg').html('<div class="alert alert-danger">An error occurred</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})
</script>