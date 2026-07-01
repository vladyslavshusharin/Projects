<?php
session_start();

if(isset($_SESSION['user_id'])){

$NeededController = $_GET['controller'] ?? 'User';
$NeededAction = $_GET['action'] ?? 'ShowDashboard';

}

if(!isset($_SESSION['user_id'])){


if(isset($_GET['action']) && $_GET['action'] === "Signup"){
    $NeededController = 'User';
    $NeededAction = 'Signup';
}else{
    $NeededController = 'User';
    $NeededAction = 'Signin';
} 

}

$_GET['controller'] = $NeededController;
$_GET['action'] = $NeededAction;

$ConClass = $NeededController . 'Controller';
$ConFile = "Controller/$ConClass.php";

require $ConFile;

$ConObj = new $ConClass;

$ConObj->$NeededAction();


?>