<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/20/2016
 * Time: 7:08 PM
 */

session_start();
session_unset();

header("Location: index.php");