<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 04-May-17
 * Time: 10:43
 */
$con = mysqli_connect("localhost","root","","gshop");
if (mysqli_connect_errno())
{
    echo "Could not connect with the data base: " . mysqli_connect_error();
}
?>