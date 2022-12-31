<?php
$url='localhost';
$username='chabyman_chaby';
$password='Chabyka123$';
try{
    if(!$conn=mysqli_connect($url,$username,$password,"chabyman_forum")){
        throw new Exception('Unable to connect');
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>
