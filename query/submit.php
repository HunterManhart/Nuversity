<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/21/2016
 * Time: 11:48 PM
 */

require_once "../db/conn.php";

session_start();

$survey = $_SESSION['survey'];
$user = $_SESSION['user_id'];

$query_survey = "select id, qType from questions where survey = ?";

//$query_check = "select id from surveys_taken where user = ? limit 1";
//$stmt_check = $conn->prepare($query_taken);
//$stmt_check->bind_param("i", $user);
//$stmt_check->execute();
//$stmt_check->bind_result($taken);
//$stmt_check->close();

$query_taken  = "insert into surveys_taken value(null, ?, ?, now(), now())";
$stmt_taken = $conn->prepare($query_taken);
$stmt_taken->bind_param("ii", $user, $survey);
$stmt_taken->execute();
$taken = $stmt_taken->insert_id;
$stmt_taken->close();

// Get Survey Information
$stmt = $conn->prepare($query_survey);
$stmt->bind_param("i", $survey);
$stmt->execute();
$stmt->bind_result($id, $num);


$list = [];
while($stmt->fetch()){
    $list[$id] = $num;
}
$stmt->close();

$query_results = "insert into survey_results value(null, ?, ?, ?, ?, ?, now(), now())";
$stmt_results = $conn->prepare($query_results);
foreach($list as $i => $type){
    $answer = $_POST[$i];

    if($type == 1){
        $int = $answer;
        $text = null;
    }else{
        $int = null;
        $text = $answer;
    }
    $stmt_results->bind_param("iiisi", $taken, $i, $type, $text, $int);
    $stmt_results->execute();
}

if($survey == 1 || $survey == 2){
    $update = "update users set demographic = 1 where id = ?";
    $stmt_up = $conn->prepare($update);
    $stmt_up->bind_param("i", $user);
    $stmt_up->execute();

    $_SESSION['demo'] = 1;

    echo "agreement.html";
}else{
    echo "workspace.php";
}

