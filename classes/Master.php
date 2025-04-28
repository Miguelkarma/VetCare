<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_message(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `message_list` set {$data} ";
		}else{
			$sql = "UPDATE `message_list` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Your message has successfully sent.";
			else
				$resp['msg'] = "Message details has been updated successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success' && !empty($id))
		$this->settings->set_flashdata('success',$resp['msg']);
		if($resp['status'] =='success' && empty($id))
		$this->settings->set_flashdata('pop_msg',$resp['msg']);
		return json_encode($resp);
	}
	function delete_message(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `message_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Message has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and delete_flag = 0 ".($id > 0 ? " and id != '{$id}'" : ""));
		if($check->num_rows > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category name already exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Category has successfully added.";
				else
					$resp['msg'] = "Category details has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
		}
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	function save_petrecords(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string(htmlspecialchars($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `pet_records` where `pet_name` = '{$this->conn->real_escape_string($pet_name)}' and delete_flag = 0 ".(!empty($pet_id) ? " and pet_id != {$pet_id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Pet Record already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($pet_id)){
			$sql = "INSERT INTO `pet_records` set {$data} ";
		}else{
			$sql = "UPDATE `pet_records` set {$data} where pet_id = '{$pet_id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($pet_id) ? $pet_id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Pet Records successfully saved.";
			else
				$resp['msg'] = "Pet Records successfully updated.";
			if(!empty($_FILES['img']['tmp_name'])){
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$dir = "uploads/pet_images/";
				if(!is_dir(base_app.$dir))
					mkdir(base_app.$dir);
				$fname = $dir.$cid.'.png';
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] .= "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] .= "Image is invalid";
				}
				$temp = imagescale($uploadfile,200,200);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname);
				if($upload){
					$qry = $this->conn->query("UPDATE pet_records set image_path = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where pet_id = '{$cid}' ");
				}
				imagedestroy($temp);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}

	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set delete_flag=1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Category has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_service(){
		$_POST['category_ids'] = implode(',',$_POST['category_ids']);
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `service_list` set {$data} ";
		}else{
			$sql = "UPDATE `service_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `service_list` where `name` ='{$name}' and category_ids = '{$category_ids}' and delete_flag = 0 ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Service already exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Service has successfully added.";
				else
					$resp['msg'] = "Service has been updated successfully.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "An error occured.";
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function delete_service(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `service_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Service has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_appointment(){
		
		if(empty($_POST['id'])){
			$prefix="OVAS-".date("Ym");
			$code = sprintf("%'.04d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `appointment_list` where code = '{$prefix}{$code}' ")->num_rows;
				if($check <= 0){
					$_POST['code'] = $prefix.$code;
					break;
				}else{
					$code = sprintf("%'.04d",ceil($code)+1);
				}
			}
		}
		$_POST['service_ids'] = implode(",", $_POST['service_id']);
		extract($_POST);
	
		// Email validation
		if(isset($_POST['email']) && !empty($_POST['email'])) {
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Please enter a valid email address';
				return json_encode($resp);
			}
		}
	
		// Contact validation
		if(isset($_POST['contact']) && !empty($_POST['contact'])) {
			$contact = $_POST['contact'];
			if(!(preg_match('/^09[0-9]{9}$/', $contact) || preg_match('/^\+639[0-9]{9}$/', $contact))) {
				$resp['status'] = 'failed';
				$resp['msg'] = 'Please enter a valid mobile number (09XXXXXXXXX or +639XXXXXXXXX)';
				return json_encode($resp);
			}
		}
		
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `appointment_list` set {$data} ";
		}else{
			$sql = "UPDATE `appointment_list` set {$data} where id = '{$id}' ";
		}
		
		// Get max appointments per block
		$max_per_block = ceil($this->settings->info('max_appointment') / 2);
		
		// Check if the time block is fully booked
		$block_query = $this->conn->query("SELECT COUNT(*) as count FROM `appointment_list` 
										  WHERE date(schedule) = '{$schedule}' 
										  AND time_sched = '{$time_sched}' 
										  AND `status` in (0,1)" . (empty($id) ? "" : " AND id != '{$id}'"));
		$block_result = $block_query->fetch_assoc();
		$slot_taken = $block_result['count'];
		
		if($slot_taken >= $max_per_block){
			$resp['status'] = 'failed';
			$resp['msg'] = "Sorry, the selected time block is already fully booked.";
			return json_encode($resp);
		}
		
		// If we've passed all checks, save the appointment
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['id'] = $rid;
			$resp['code'] = $code;
			$resp['status'] = 'success';
	
			if(empty($id))
				$resp['msg'] = "New Appointment Details has successfully added.</b>.";
			else
				$resp['msg'] = "Appointment Details has been updated successfully.";
		
			
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
	
		if($resp['status'] =='success')
			$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	function cancel_appointment(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `appointment_list` SET status = 3 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Appointment Details has been canceled successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_appointment(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `appointment_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Appointment has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	

	function update_appointment_status(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		// Get max appointments per block
		$max_appointment = $this->settings->info('max_appointment') ?: 10;
		$max_per_block = ceil($max_appointment / 2);
		
		// Only check for time conflicts if status is pending or confirmed
		if($status == 0 || $status == 1) {
			// Count how many appointments are already in this time block
			$count_query = $this->conn->query("SELECT COUNT(*) as count FROM `appointment_list` 
				WHERE date(schedule) = '{$schedule}' 
				AND time_sched = '{$time_sched}' 
				AND `status` in (0,1)
				AND id != '{$id}'");
			
			$count_result = $count_query->fetch_assoc();
			$current_count = $count_result['count'];
			
			if($current_count >= $max_per_block) {
				$resp['status'] = 'failed';
				$resp['msg'] = "This time block has reached its maximum capacity of {$max_per_block} appointments.";
				return json_encode($resp);
			}
		}
	
		$del = $this->conn->query("UPDATE `appointment_list` set status = '{$status}', time_sched = '$time_sched', schedule = '$schedule' where id = '{$id}'");
		
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Appointment Request status has successfully updated.");
			
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function add_doctor_note(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!is_numeric($v))
					$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		$insrt = $this->conn->query("INSERT INTO `clinic_history` ( `owner_id`, `category_id`, `breed`, `age`, `service_ids`, `pet_id`, `notes`) VALUES ('$owner_id', '$category_id', '$breed', '$age', '$service_ids', '$pet_id', '$notes') ");
	
		if($insrt){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Appointment Request status has successfully updated.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_petrecords(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `pet_records` set delete_flag=1 where pet_id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Pet record has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function check_time_availability(){
		extract($_POST);
		
		// Get max appointments per block
		$max_appointment = $this->settings->info('max_appointment') ?: 10;
		$max_per_block = ceil($max_appointment / 2);
		
		// Only check if status is pending or confirmed (0 or 1)
		$status_check = isset($status) && in_array($status, [0,1]) ? " AND `status` in (0,1)" : "";
		
		$where = "date(schedule) = '{$schedule}' AND time_sched = '{$time_sched}' {$status_check}";
		if(isset($id) && !empty($id)) {
			$where .= " AND id != '{$id}'";
		}
		
		// Count how many appointments are in this time block
		$check = $this->conn->query("SELECT COUNT(*) as count FROM `appointment_list` WHERE {$where}");
		$row = $check->fetch_assoc();
		$count = $row['count'];
		
		if($count >= $max_per_block) {
			$resp['available'] = false;
			$resp['max_per_block'] = $max_per_block;
			$resp['msg'] = "This time block has reached its maximum capacity of {$max_per_block} appointments.";
		} else {
			$resp['available'] = true;
		}
		
		return json_encode($resp);
	}

	function auto_update_appointment_status(){
    global $conn;
    
    // Get current date and time
    $today = date('Y-m-d');
    $now = date('H:i:s');
    
    // Get business hours from settings
    $business_end = $_settings->info('business_hours_end') ?: '19:00';
    
    // Convert to 24-hour format for comparison
    $end_time = date('H:i:s', strtotime($business_end));
    
    // Update confirmed appointments to completed
    $update_query = "UPDATE `appointment_list` SET `status` = 2 
                    WHERE `status` = 1 
                    AND ((`schedule` < '$today') 
                        OR (`schedule` = '$today' AND '$now' > '$end_time'))";
    
    $update = $conn->query($update_query);
    
    // Optional: Identify no-shows (appointments from yesterday that weren't completed/cancelled)
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $no_show_query = "UPDATE `appointment_list` SET `status` = 4 
                      WHERE `status` = 1 
                      AND `schedule` = '$yesterday'";
    
    $no_show = $conn->query($no_show_query);
    
    return true;
}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_appointment':
		echo $Master->save_appointment();
	break;
	case 'delete_appointment':
		echo $Master->delete_appointment();
	break;
	case 'cancel_appointment':
		echo $Master->cancel_appointment();
	break;
	case 'update_appointment_status':
		echo $Master->update_appointment_status();
	break;
	case 'add_doctor_note':
		echo $Master->add_doctor_note();
	break;
	case 'save_message':
		echo $Master->save_message();
	break;
	case 'delete_message':
		echo $Master->delete_message();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_service':
		echo $Master->save_service();
	break;
	case 'delete_service':
		echo $Master->delete_service();
	break;
	case 'save_petrecords':
		echo $Master->save_petrecords();
	break;
	case 'delete_petrecords':
		echo $Master->delete_petrecords();
	break;
	case 'check_time_availability':
		echo $Master->check_time_availability();
	break;
	default:
		// echo $sysset->index();
		break;
}