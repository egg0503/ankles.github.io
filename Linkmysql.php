<?php
$host = '127.0.0.1';
 //改成你登入phpmyadmin帳號
 $user = 'root';
 //改成你登入phpmyadmin密碼
 $passwd = '';
 //資料庫名稱
 $database = 'test';
 //實例化mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
 $connect = new mysqli($host, $user, $passwd, $database);
 $connect->query("SET NAMES 'UTF8'");
 ?>