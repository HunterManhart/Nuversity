<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/21/2016
 * Time: 5:28 PM
 */

require_once "../db/conn.php";
require_once "../classes/User.php";

session_start();

// Initial Variables for the script
$survey = $_GET['survey'];
$_SESSION['survey'] = $survey;
//$survey = 1;
//$id = $_SESSION['user_id'];

$user = $_SESSION['user'];

echo $user->getSurvey($survey);
