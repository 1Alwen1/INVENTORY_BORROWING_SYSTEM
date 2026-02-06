<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
$link .= "://"; 
$link .= $_SERVER['HTTP_HOST']; 
$link .= $_SERVER['REQUEST_URI'];
if(!isset($_SESSION['userdata']) && !strpos($link, 'login.php') && !strpos($link, 'signup.php')){
	redirect('../admin/login.php');
}
if(isset($_SESSION['userdata']) && (strpos($link, 'login.php') || strpos($link, 'signup.php'))){
	redirect('home.php');
}
if(isset($_SESSION['userdata']) && strpos($link, 'faculty/') && $_SESSION['userdata']['login_type'] !=  4){
	echo "<script>alert('Access Denied!');location.replace('".base_url."admin/login.php');</script>";
    exit;
}
