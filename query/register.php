<?php
/**
 * Register:  Takes in AJAX user registration info, updates the database, and emails them for confirmation
 * Creator: Hunter
 * Date: 2/13/2016
 */

require_once "../db/conn.php";
require_once "../classes/User.php";

$username = $_POST['username'];
$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$user = new User(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$prev = $user->checkUsername($username);

if(isset($prev)){
    echo "Username is taken and this town ain't big enough for the both of you";
}else {
    $valid = $user->register($username, $password, $email, $phone, $first, $last);

    if($valid){
        session_start();
        $_SESSION['user'] = $user;

        echo "success";
    }else{
        echo "error";
    }

}

