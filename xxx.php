<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AAA</title>
</head>
<body>
<table>
<?php
include('Linkmysql.php');
session_start();
$SelectSql="SELECT * FROM products";
$result=$connect->query($SelectSql);
while($rows=$result->fetch_assoc())
{
	
	echo $rows["Name"];
}	
?>
</table>
</body>
</html>
