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
$SelectSql="SELECT quantity,p_id,pd_id FROM spotcart WHERE uid='$uid'";//用帳戶id查詢產品id跟細項id
$result=$connect->query($SelectSql);
$rows=$result->fetch_assoc();
$p_id=$rows['p_id'];
$pd_id=$rows['pd_id'];
$qu=$rows['quantity'];

$SelectSql2="SELECT Price FROM products_details WHERE id='$pd_id'";//用細項id查詢產品顏色跟金額跟尺寸id
$result2=$connect->query($SelectSql2);
$rows2=$result2->fetch_assoc();
$pr=$rows2['Price'];


$SelectSql4="SELECT Name,Image FROM products WHERE id='$p_id'";//用產品id查詢產品名稱
$result4=$connect->query($SelectSql4);
$rows4= $result4->fetch_assoc();
$pd=$rows4['Name'];

$SelectSql5="SELECT category_id FROM category_product WHERE product_id='$p_id'";//用產品id查詢產品大類別id
$result5=$connect->query($SelectSql5);
$rows5= $result5->fetch_assoc();
$cid=$rows5['category_id'];

$SelectSql6="SELECT Name FROM category WHERE id='$cid'";//用產品大類別id查詢產品大類別名稱
$result6=$connect->query($SelectSql6);
$rows6= $result6->fetch_assoc();
$cname=$rows6['Name'];

if(isset($_COOKIE['Email'])==null&&isset($_COOKIE['acc'])==null)
{
    echo'
    <script>
    alert("登入時效已到\n即將登出");
    </script>';
    header('refresh:0;url=http://127.0.0.1/Workfile/signin.html');
}
?>