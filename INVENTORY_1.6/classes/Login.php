<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);

		$stmt = $this->conn->prepare("SELECT * from users where username = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$username,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			foreach($result->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function login_customer(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from customer_list where email = ? and `password` = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('login_type',2);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = 'Incorrect Email or Password';
		}
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function login_student(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from students where lrn = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$lrn,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}
			}
			$this->settings->set_userdata('login_type',3);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'incorrect';
		}
		return json_encode($resp);
	}
	function login_faculty(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from faculty where teacher_level = ? and password = ? ");
		$password = md5($password);
		$stmt->bind_param('ss',$teacher_level,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$res = $result->fetch_array();
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}
			}
			$this->settings->set_userdata('login_type',4);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'incorrect';
		}
		return json_encode($resp);
	}
	function signup_student(){
		extract($_POST);
		$required_fields = ['full_name', 'lrn', 'grade_level', 'strand', 'department', 'password'];
		foreach($required_fields as $field){
			if(!isset($_POST[$field]) || empty(trim($_POST[$field]))){
				$resp['status'] = 'failed';
				$resp['msg'] = 'All fields are required.';
				return json_encode($resp);
			}
		}
		$password = md5($password);
		$stmt = $this->conn->prepare("INSERT INTO students (full_name, lrn, grade_level, strand, department, password) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssss',$full_name,$lrn,$grade_level,$strand,$department,$password);
		$resp = array();
		if($stmt->execute()){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function signup_faculty(){
		extract($_POST);
		$password = md5($password);
		$stmt = $this->conn->prepare("INSERT INTO faculty (full_name, teacher_level, department, password) VALUES (?, ?, ?, ?)");
		$stmt->bind_param('ssss',$full_name,$teacher_level,$department,$password);
		$resp = array();
		if($stmt->execute()){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	public function logout_customer(){
		if($this->settings->sess_des()){
			redirect('?');
		}
	}
	function logout_student(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function logout_faculty(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'login_customer':
		echo $auth->login_customer();
		break;
	case 'logout_customer':
		echo $auth->logout_customer();
		break;
	case 'login_student':
		echo $auth->login_student();
		break;
	case 'login_faculty':
		echo $auth->login_faculty();
		break;
	case 'signup_student':
		echo $auth->signup_student();
		break;
	case 'signup_faculty':
		echo $auth->signup_faculty();
		break;
	case 'logout_student':
		echo $auth->logout_student();
		break;
	case 'logout_faculty':
		echo $auth->logout_faculty();
		break;
	default:
		echo $auth->index();
		break;
}

