<?php
ob_start();
session_start(); 
require '../inc/config.php';
require ROOT . 'inc/model.event.php';

if(isset($_GET['eventid']) && isset($_SESSION['user'])){
	if(!eventCheckIfUserSignedUp($_SESSION['user']['steamid'], $_GET['eventid'])){
		eventAddUser($_SESSION['user']['steamid'], $_GET['eventid']);
	}
}

if(isset($_GET['des'])){
  header("Location: ". $_GET['des']);
}else{
  header("Location: /");
}
?>