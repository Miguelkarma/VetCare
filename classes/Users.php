<?php
require_once('../config.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
		if(!isset($_POST['status']) && $this->settings->userdata('login_type') == 1){
			$_POST['status'] = 1;
		}
		extract($_POST);
		$oid = $id;
		$data = '';
		
		// Check if it's an existing user trying to update
		if(!empty($id)) {
			// Check if the user is trying to change their password
			$changePassword = (!empty($current_password) && !empty($new_password));
			
			if($changePassword) {
				// Get current password from database
				$current = $this->conn->query("SELECT `password` FROM users WHERE id = '{$id}'")->fetch_array()['password'];
				if(md5($current_password) != $current) {
					return 2; // Current password is incorrect
				}
				
				// Verify new password matches confirmation if provided
				if($new_password != $confirm_password) {
					return 4; // Passwords don't match
				}
				
				// Use new_password for the update
				$password = $new_password;
			}
		} else {
			// For new users, confirm password must match
			if($password != $confirm_password) {
				return 4; // Passwords don't match
			}
		}
		
		// Check if username exists
		$chk = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3; // Username already exists
			exit;
		}
		
		// Validate contact information
        if(isset($contact) && !empty($contact)) {
            if(!(preg_match('/^09[0-9]{9}$/', $contact) || preg_match('/^\+639[0-9]{9}$/', $contact))) {
                return 6; // Contact number validation failed
            }
        }
		
		// Build data for update/insert
		foreach($_POST as $k => $v){
			if(in_array($k,array('firstname','address','lastname','username','type','contact'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		
		// Hash password if provided (either new user or password change requested)
		if((!empty($id) && !empty($new_password)) || (empty($id) && !empty($password))){
			$pass = !empty($new_password) ? $new_password : $password;
			$password = md5($pass);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}

		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 5; // Database insert error
			}

		}else{
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				if($id == $this->settings->userdata('id')){
					foreach($_POST as $k => $v){
						if($k != 'id' && !in_array($k, ['current_password', 'new_password', 'confirm_password'])){
							$this->settings->set_userdata($k,$v);
						}
					}
					
					// Update password in session if it was changed
					if(!empty($new_password)) {
						$this->settings->set_userdata('password', md5($new_password));
					}
				}
				$resp['status'] = 1;
			}else{
				$resp['status'] = 5; // Database update error
			}
			
		}
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/avatar-'.$id.'.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$resp['msg'].=" But Image failed to upload due to invalid file type.";
			}else{
				$new_height = 200; 
				$new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$resp['msg'].=" But Image failed to upload due to unkown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE users set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
						$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return isset($resp['status']) ? $resp['status'] : 1;
	}

	// Rest of the class remains unchanged
	public function change_password(){
		extract($_POST);
		$password = md5($password);
		if($old_password1 == md5($old_password)){
		$qry = $this->conn->query("UPDATE users SET password='$password' where id = $id ");
		if($qry){
			$resp['status'] = 1;
		}else{
			$resp['status'] = 2;
		}
		}else{
			$resp['status'] = 5;
		}

		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}

	public function delete_users(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$avatar = explode("?",$avatar)[0];
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function save_client(){
		extract($_POST);
		$data = '';
		if(isset($oldpassword)){
			if(md5($oldpassword) != $this->settings->userdata('password')){
				return json_encode(array("status"=>'failed',
										 "msg"=>'Old Password is Incorrect'));
			}
		}
		$chk = $this->conn->query("SELECT * FROM `client_list` where email ='{$email}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','oldpassword','cpassword','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}

		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO client_list set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				$resp['status'] = "success";
			}else{
				$resp['status'] = "failed";
				$resp['msg'] = "An error occurred while saving the data. Error: ". $this->conn->error;
			}

		}else{
			$qry = $this->conn->query("UPDATE client_list set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				if($id == $this->settings->userdata('id')){
					foreach($_POST as $k => $v){
						if($k != 'id'){
							if(!empty($data)) $data .=" , ";
							$this->settings->set_userdata($k,$v);
						}
					}
					
				}
				$resp['status'] = "success";
			}else{
				$resp['status'] = "failed";
				$resp['msg'] = "An error occurred while saving the data. Error: ". $this->conn->error;
			}
			
		}
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/client-'.$id.'.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$resp['msg'].=" But Image failed to upload due to invalid file type.";
			}else{
				$new_height = 200; 
				$new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$resp['msg'].=" But Image failed to upload due to unkown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE client_list set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
						$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
		
		return  json_encode($resp);
	}
	public function delete_client(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM client_list where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM client_list where id = $id");
		if($qry){
			$avatar = explode("?",$avatar)[0];
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function verify_client(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `client_list` set `status` = 1 where id = $id");
		if($update){
			$this->settings->set_flashdata('success','client Account has verified successfully.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	case 'save_client':
		echo $users->save_client();
	break;
	case 'delete_client':
		echo $users->delete_client();
	break;
	case 'verify_client':
		echo $users->verify_client();
	break;
	case 'change_password':
		echo $users->change_password();
	break;
	default:
		// echo $sysset->index();
		break;
}