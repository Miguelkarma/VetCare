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
	
		// Contact validation (existing code)
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
		$slot_taken = $this->conn->query("SELECT * FROM `appointment_list` where date(schedule) = '{$schedule}' and `status` in (0,1)")->num_rows;
		if($slot_taken >= $this->settings->info('max_appointment')){
			$resp['status'] = 'failed';
			$resp['msg'] = "Sorry, the Appointment Schedule is already full.";
		}else{
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
		}
	
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_appointment(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `appointment_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Appointment Details has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
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
	default:
		// echo $sysset->index();
		break;
}