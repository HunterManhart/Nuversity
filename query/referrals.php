<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/22/2016
 * Time: 2:53 AM
 */

session_start();

$survey = $_SESSION['survey'];
$surveyName = $_SESSION['surveyName'];
$user = $_SESSION['user_id'];
$first = $_SESSION['first'];
$last = $_SESSION['last'];
$referrals = $_POST['r'];
echo $referrals;

mail("nuversityreferrals@gmail.com", "Referrals", "$first $last: \nSurvey $survey: $surveyName \n$referrals", "");


