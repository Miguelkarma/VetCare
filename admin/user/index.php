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
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username/Email</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="contact">Contact Info</label>
					<input type="text" name="contact" id="contact" class="form-control" value="<?php echo isset($meta['contact']) ? $meta['contact']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="address">Address</label>
					<textarea class="form-control" name="address" id="address" row="5"><?php echo isset($meta['address']) ? $meta['address']: '' ?></textarea>
				</div>

	<div class="form-group">
        <input type="hidden" name="old_password1" id="old_password1" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" class="form-control" autocomplete="off">
    </div>

	<div class="form-group">
        <label for="password">Enter old password</label>
        <input type="password" name="old_password" id="old_password" class="form-control" autocomplete="off">
        <small><i>Enter old password to confirm.</i></small>
    </div>


	<div class="form-group">
        <label for="password">New Password</label>
        <input type="password" name="password" id="password" class="form-control" autocomplete="off">
        <small><i>Leave this blank if you don't want to change the password.</i></small>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="off">
        <small id="passwordError" style="color: red; display: none;">Passwords do not match!</small>
    </div>

				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
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
</style>
<script>
document.getElementById("passwordForm").addEventListener("submit", function(event) {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password_confirmation").value;
    var errorText = document.getElementById("passwordError");

    if (password !== confirmPassword) {
        errorText.style.display = "block";
        event.preventDefault(); // Prevent form submission
    } else {
        errorText.style.display = "none";
    }
});
</script>
<script>
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
var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=change_password',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					$('#msg').html('<div class="alert alert-success">Change Password Successfully</div>')
					end_loader()
				}else if(resp == 5){
					$('#msg').html('<div class="alert alert-danger">Old Password Does not  match</div>')
					end_loader()
				}else{
					$('#msg').html('<div class="alert alert-danger">Error Fail</div>')
					end_loader()
				}
			}
		})
	})

</script>