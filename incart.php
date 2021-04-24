<?php
include('Linkmysql.php');
session_start();
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
$p_id=$_GET['id'];
$cr=$_POST['color'];
$sz=$_POST['size'];
$qut=$_POST['quantity'];

$SelectSql2="SELECT id FROM size WHERE name='$sz'";
$result2=$connect->query($SelectSql2);
$rows2=$result2->fetch_assoc();
$sid=@$rows2['id'];

$SelectSql3="SELECT id FROM products_details WHERE colors='$cr'AND p_id='$p_id'AND s_id='$sid'";
$result3=$connect->query($SelectSql3);
$rows3=$result3->fetch_assoc();
$pd_id=@$rows3['id'];

if($cr&&$sid)
{
    $SelectSql="SELECT id,pd_id FROM spotcart WHERE uid='$uid' AND p_id='$p_id'";
    $result=$connect->query($SelectSql);
    $rows=$result->fetch_assoc();
    $sc=@$rows['id'];
    $upid=@$rows['pd_id'];
    if($upid!=$pd_id)
    {
        $InsertSql = "INSERT INTO spotcart(uid,p_id, pd_id,	quantity) VALUES ('$uid','$p_id','$pd_id',$qut)";
        $status= $connect->query($InsertSql);
        echo'
        <script>
        alert("新增成功");
        history.go(-1);
        </script>';
    }
    else
    {
       $UpdateSql="UPDATE spotcart SET quantity = quantity+'$qut' WHERE id='$sc'";
       $result=$connect->query($UpdateSql);
       echo'
       <script>
       alert("成功新增數量");
       history.go(-1);
       </script>';
    }
}
else
{
    echo'
    <script>
    alert("請輸入完整");
    history.go(-1);
    </script>';
}

if(isset($_COOKIE['Email'])==null&&isset($_COOKIE['acc'])==null)
{
    echo'
    <script>
    alert("登入時效已到\n即將登出");
    </script>';
    header('refresh:0;url=http://localhost/Workfile/signin.html');
}
?>