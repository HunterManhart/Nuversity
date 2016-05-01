<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 3/4/2016
 * Time: 10:30 AM
 */

$username = $_POST['username'];

if(isset($username)){
    require_once "../db/conn.php";
    require_once "../classes/User.php";
    $user = new User(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $id = $user->checkUsername($username);

    if(isset($id)){
        $mailed = $user->createReset($id);
        echo $mailed;
    }

}else{
    echo false;
}