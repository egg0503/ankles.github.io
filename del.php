<?php

include('Linkmysql.php');
session_id();
if(isset($_COOKIE['Email']))
{
    $u_acc=$_COOKIE['Email']; 
    $SelectSql="SELECT Id FROM users  Where Email='$u_acc'";
    $result=$connect->query($SelectSql);
    $rows = $result->fetch_assoc();
    $uid=$rows['Id'];
}
else if(isset($_COOKIE['acc']))
{
    $u_acc=$_COOKIE['acc'];
    $SelectSql="SELECT Id FROM users  Where Email='$u_acc'";
    $result=$connect->query($SelectSql);
    $rows = $result->fetch_assoc();
    $uid=$rows['Id'];
}
else
{
    header('Location:http://localhost/Workfile/index.php');
}
$pp=$_GET['apid'];
$SelectSql="DELETE FROM spotcart WHERE uid='$uid'&& p_id='$pp'";//
$result=$connect->query($SelectSql);
header('Location:http://localhost/Workfile/index-in.php');



if(isset($_COOKIE['Email'])==null&&isset($_COOKIE['acc'])==null)
{
    echo'
    <script>
    alert("登入時效已到\n即將登出");
    </script>';
    header('refresh:0;url=http://localhost/Workfile/signin.html');
}
?>