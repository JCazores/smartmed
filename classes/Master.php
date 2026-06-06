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
	function save_doctor(){
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
			$sql = "INSERT INTO `doctor_list` set {$data} ";
		}else{
			$sql = "UPDATE `doctor_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `doctor_list` where `fullname` ='{$fullname}' and delete_flag = 0 ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Doctor already exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Doctor Details has successfully added.";
				else
					$resp['msg'] = "Doctor Details has been updated successfully.";
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
	function delete_doctor(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `doctor_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Doctor Details has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_room_type(){
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
			$sql = "INSERT INTO `room_type_list` set {$data} ";
		}else{
			$sql = "UPDATE `room_type_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `room_type_list` where `room` ='{$room}' and delete_flag = 0 ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Room Type already exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Room Type Details has successfully added.";
				else
					$resp['msg'] = "Room Type Details has been updated successfully.";
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
	function delete_room_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `room_type_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Room Type Details has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_room(){
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
			$sql = "INSERT INTO `room_list` set {$data} ";
		}else{
			$sql = "UPDATE `room_list` set {$data} where id = '{$id}' ";
		}
		$check = $this->conn->query("SELECT * FROM `room_list` where `name` ='{$name}' and delete_flag = 0 ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Room already exists.";
		}else{
			$save = $this->conn->query($sql);
			if($save){
				$rid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "Room Details has successfully added.";
				else
					$resp['msg'] = "Room Details has been updated successfully.";
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
	function delete_room(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `room_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Room Details has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_patient(){
    if(empty($_POST['id'])){
        $prefix = "PA-".(date('Ym'));
        $code = sprintf("%'.04d",1);
        while(true){
            $check = $this->conn->query("SELECT * FROM `patient_list` WHERE code = '{$prefix}{$code}'")->num_rows;
            if($check > 0){
                $code = sprintf("%'.04d",ceil($code)+1);
            }else{
                break;
            }
        }
        $_POST['code'] = $prefix.$code;
    }

    // Format fullname
    $_POST['fullname'] = strtoupper($_POST['lastname'].(!empty($_POST['suffix']) ? ' '.$_POST['suffix'] : '').' '.$_POST['firstname'].(!empty($_POST['middlename']) ? ' '.$_POST['middlename'] : ''));

    // Add age, weight, username, email, and type fields to the data
    $age = isset($_POST['age']) ? $_POST['age'] : null;
    $weight = isset($_POST['weight']) ? $_POST['weight'] : null;
    $email = isset($_POST['email']) ? $this->conn->real_escape_string($_POST['email']) : null;

    // Prepare data string
    extract($_POST);
    $data = "";
    foreach($_POST as $k => $v){
        if(in_array($k, array('fullname','code','status','delete_flag','age','weight','email'))){
            if(!is_numeric($v))
                $v = $this->conn->real_escape_string($v);
            if(!empty($data)) $data .= ",";
            $data .= " `{$k}`='{$v}' ";
        }
    }

    // Include password field only for new records or if password is updated
    if(!empty($password)){
        $data .= ", `password`='{$password}' ";
    }

    // Insert or update query
    if(empty($id)){
        $sql = "INSERT INTO `patient_list` SET {$data}";
    }else{
        $sql = "UPDATE `patient_list` SET {$data} WHERE id = '{$id}'";
    }

    $save = $this->conn->query($sql);
    if($save){
        $pid = !empty($id) ? $id : $this->conn->insert_id;
        $resp['pid'] = $pid;
        $resp['status'] = 'success';
        $resp['msg'] = empty($id) ? "Patient details have been successfully added." : "Patient details have been updated successfully.";

        // Handle `patient_details` for additional info
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k, array('id','fullname','code','status','delete_flag','age','weight','email'))){
                if(!is_numeric($v))
                    $v = $this->conn->real_escape_string($v);
                if(!empty($data)) $data .= ",";
                $data .= " ('{$pid}', '{$k}', '{$v}') ";
            }
        }

        if(!empty($data)){
            $this->conn->query("DELETE FROM `patient_details` WHERE patient_id = '{$pid}'");
            $sql2 = "INSERT INTO `patient_details` (`patient_id`, `meta_field`, `meta_value`) VALUES {$data}";
            $save2 = $this->conn->query($sql2);
            if(!$save2){
                $resp['status'] = 'failed';
                $resp['msg'] = "An error occurred. Error: ".$this->conn->error;
                $resp['err'] = $this->conn->error."[{$sql2}]";
            }
        }
    }else{
        $resp['status'] = 'failed';
        $resp['msg'] = "An error occurred.";
        $resp['err'] = $this->conn->error."[{$sql}]";
    }

    if($resp['status'] == 'success')
        $this->settings->set_flashdata('success', $resp['msg']);
    return json_encode($resp);
}

	function delete_patient(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `patient_list` set delete_flag = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Patient Details has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_patient_history(){
		extract($_POST);
		$data = "";
		$xray_image = null;
	
		// Handle the uploaded X-ray image
		if (isset($_FILES['xray_image']) && $_FILES['xray_image']['error'] === UPLOAD_ERR_OK) {
			// Upload logic for the X-ray image
			$upload_dir = '../../uploads/xray_images/';
			if (!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);  // Create directory if not exists
			}
	
			$file_name = time() . '_' . basename($_FILES['xray_image']['name']);
			$file_path = $upload_dir . $file_name;
	
			if (move_uploaded_file($_FILES['xray_image']['tmp_name'], $file_path)) {
				$xray_image = $file_name; // Save the filename to the database
			} else {
				return json_encode(['status' => 'failed', 'msg' => 'Failed to upload X-ray image.']);
			}
		} elseif (isset($_POST['xray_image']) && !empty($_POST['xray_image'])) {
			// Use the existing image if no new one was uploaded
			$xray_image = $_POST['xray_image'];
		}
	
		// Loop through POST data to build SQL query
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				$v = !is_numeric($v) ? $this->conn->real_escape_string($v) : $v;
				$data .= (!empty($data) ? "," : "") . " `{$k}`='{$v}' ";
			}
		}
	
		// Include the X-ray image if available
		if ($xray_image) {
			$data .= (!empty($data) ? ", " : "") . "`xray_image` = '{$xray_image}'";
		}
	
		// Determine whether it's an insert or update
		$sql = (empty($id)) ? "INSERT INTO `patient_history` SET {$data}" : "UPDATE `patient_history` SET {$data} WHERE id = '{$id}'";
	
		// Execute the query
		if ($this->conn->query($sql)) {
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			return json_encode([
				'status' => 'success',
				'msg' => empty($id) ? "Patient record has been successfully added." : "Patient record has been updated successfully.",
				'id' => $rid
			]);
		} else {
			return json_encode([
				'status' => 'failed',
				'msg' => "An error occurred while saving the patient history.",
				'error' => $this->conn->error
			]);
		}
	}
	
	
	function delete_patient_history(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `patient_history` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Patient Record Details has been deleted successfully.");

		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_patient_admission(){
		if(empty($_POST['date_discharged'])){
			$_POST['date_discharged'] = NULL;
			$_POST['status'] = 0;
		}else{
			$_POST['status'] = 1;
		}
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
			$sql = "INSERT INTO `admission_history` set {$data} ";
		}else{
			$sql = "UPDATE `admission_history` set {$data} where id = '{$id}' ";
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Patient Admission Record has successfully added.";
			else
				$resp['msg'] = "Patient Admission Record has been updated successfully.";
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occured.";
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] =='success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}
	function delete_patient_admission(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `admission_history` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Patient Admission Record has been deleted successfully.");

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
	case 'save_room_type':
		echo $Master->save_room_type();
	break;
	case 'delete_room_type':
		echo $Master->delete_room_type();
	break;
	case 'save_room':
		echo $Master->save_room();
	break;
	case 'delete_room':
		echo $Master->delete_room();
	break;
	case 'save_message':
		echo $Master->save_message();
	break;
	case 'delete_message':
		echo $Master->delete_message();
	break;
	case 'save_doctor':
		echo $Master->save_doctor();
	break;
	case 'delete_doctor':
		echo $Master->delete_doctor();
	break;
	case 'save_patient':
		echo $Master->save_patient();
	break;
	case 'delete_patient':
		echo $Master->delete_patient();
	break;
	case 'save_patient_history':
		echo $Master->save_patient_history();
	break;
	case 'delete_patient_history':
		echo $Master->delete_patient_history();
	break;
	case 'save_patient_admission':
		echo $Master->save_patient_admission();
	break;
	case 'delete_patient_admission':
		echo $Master->delete_patient_admission();
	break;
	default:
		// echo $sysset->index();
		break;
}