<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/13/2016
 * Time: 12:21 PM
 */

require_once "../db/conn.php";
require_once "../classes/User.php";

$user = new User(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$valid = $user->login($_POST['user'], $_POST['pass']);

if($valid) {
    session_start();
    $_SESSION['user'] = $user;
}

echo $valid;