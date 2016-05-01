<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/24/2016
 * Time: 1:53 PM
 */

$id = $_GET['id'];

if(!isset($id))
    header("Location: index.php");

require_once "db/conn.php";
require_once "classes/User.php";

$user = new User(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$result = $user->checkReset($id);

//if($result === false)
    //header("Location: index.php");  // This or error code?

session_start();
$_SESSION['user'] = $user;
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Reset Your Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lte IE 8]><script src="js/index/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="css/workspace/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="css/workspace/ie8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="css/workspace/ie9.css" /><![endif]-->

    <link rel="stylesheet" href="css/index/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="css/index/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="css/index/ie8.css" /><![endif]-->
    <link rel="stylesheet" href="css/site.css">
</head>
<body>

<div id="page-wrapper" style="padding: 0;">

    <!-- Header -->
    <header>
        <h1 id="logo"><a href="index.php">Nuversity</a></h1>
    </header>

    <section>
        <div class="container" >
            <?php
                if($result === true){
                    echo "<header>
                        <h2>Reset Your Password</h2>
                    </header>

                    <form id=\"reset-password\" method=\"post\">
                        <div class=\"row\">
                            <div class=\"6u 12u$(mobile)\"><input class=\"password\" id=\"password\" type=\"password\" name=\"password\" placeholder=\"Password\" required/></div>
                            <div class=\"6u 12u$(mobile)\"><input class=\"password\" id=\"confirm\" type=\"password\" name=\"password\" placeholder=\"Confirm Password\" required/></div>
                            <div id=\"error\" class=\"8u 12u$(mobile)\" style=\"display:none;\"></div>
                            <div class=\"12u$\">
                                <input type=\"submit\" value=\"Submit\" />
                            </div>
                        </div>
                    </form>";
                }else{
                    echo "<header><h2>$result</h2></header>";
                }
            ?>

            <div id="reset-success"></div>

        </div>
    </section>


</div>

<!-- Scripts -->
<script src="js/vendor/jquery.js"></script>
<script src="js/jquery.scrolly.min.js"></script>
<script src="js/jquery.dropotron.min.js"></script>
<script src="js/jquery.scrollex.min.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/util.js"></script>
<!--[if lte IE 8]><script src="js/index/ie/respond.min.js"></script><![endif]-->
<script src="js/index/main.js"></script>
<script src="js/signup.js"></script>
</body>
</html>
