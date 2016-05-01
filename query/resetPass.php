<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 3/4/2016
 * Time: 12:36 PM
 */

require_once "../classes/User.php";

session_start();
$password = $_POST['pass'];
$user = $_SESSION['user'];

if(isset($password) && isset($user)){
    $valid = $user->resetPassword($password);
    echo $valid;
}else{
    echo false;
}