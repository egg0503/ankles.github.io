<h2>購物車測試</h2>
<?php

session_id();
include('Linkmysql.php');
?>

<table border="1" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>代號</td>
<td>名稱</td>
<td>價格</td>
</tr>

<?php
$sql = "SELECT * FROM products ORDER BY Id ";
$result=$connect->query($sql);
if ($result->num_rows>0) { // num_rows 會告訴有幾筆資料。
  foreach($result as $v)
  {
	  echo"<tr>
	  <td>$v[Id]</td>
	  <td>$v[Name]</td>
	  <td>$v[Price]</td>
	  <td><a href='add.php?id=$v[Id]'>購買</a></td> 
	  </tr>";
  }
}
?>


</table>
<div>
<a href="gouwuche.php" rel="external nofollow" rel="external nofollow" >檢視購物車</a>
<a href="main.php" rel="external nofollow" rel="external nofollow" >瀏覽商品</a>
<a href="zhanghu.php" rel="external nofollow" rel="external nofollow" >檢視賬戶</a> </div>
</body>



