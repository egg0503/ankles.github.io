<?php
$pid=$_GET['id'];
include('Linkmysql.php');
$SelectSql="SELECT Image2 FROM products WHERE id='$pid'";
$result=$connect->query($SelectSql);
$row=$result->fetch_assoc(); 
Header( "Content-type: image/jpeg");
echo $row['Image2']; 
?>