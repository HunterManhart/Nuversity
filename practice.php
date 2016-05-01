<?php
/**
 * Created by PhpStorm.
 * User: Hunter
 * Date: 2/24/2016
 * Time: 8:35 PM
 */

$id = "eh";

$salt = "Gka3rbrvIO";

$hash = crypt($id, $salt);

echo $hash."<br>";

$hash = crypt($id, $salt);

echo $hash;