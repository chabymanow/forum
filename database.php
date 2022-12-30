<?php
include "private.php";
    $url='localhost';
    $conn=mysqli_connect($url,$username,$password,"myForum");
    if(!$conn){
    die('Could not Connect My Sql:');
    }
?>
