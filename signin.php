<?php
include('Linkmysql.php');
$u_acc=$_POST['Email'];
$u_pw=$_POST['password'];
session_start();
   if ($u_acc&&$u_pw) 
   { 
       $SelectSql="SELECT * FROM users  Where Email='$u_acc'";
       $result=$connect->query($SelectSql);
       $rows = $result->fetch_assoc();
       $acc=@$rows['Email'];
       if($u_acc == $acc)//判斷帳號是否正確
       {
        $SelectSql="SELECT password FROM users  Where Email='$u_acc'";
        $result=$connect->query($SelectSql);
        $rows = $result->fetch_assoc();
        $pw=@base64_decode($rows['password']);//在這裡解碼!!!
        if ($u_pw==$pw)//判斷密碼是否正確
        {
           # 使用者名稱和密碼都正確,將使用者資訊存到Session中 
           $_SESSION['Email'] = $u_acc;
           // 若勾選1天內自動登入
           if ($_POST['remember'] == "yes")
           {
              setcookie('Email', $u_acc, time()+1*24*60*60);
              setcookie('code', hash("sha256",$u_acc. hash("sha256", $u_pw)), time()+1*24*60*60);
           }            
           else 
           {
              $_SESSION['acc'] = $_SESSION['Email'];
              setcookie('acc', $_SESSION['acc'], time()+30*60);
              setcookie('code', hash("sha256",$_SESSION['acc']. hash("sha256", $u_pw)), time()+35*60);
               // 沒有勾選則刪除Cookie
              setcookie('Email', '', time()-1*24*60*60);
              setcookie('code', '', time()-1*24*60*60); 
           }
           $SelectSql="SELECT r_id FROM users  Where Email='$u_acc'";
           $result=$connect->query($SelectSql);
           $rows = $result->fetch_assoc();
           $id=$rows['r_id'];
           if($id==1)
           {
            header('Location:http://localhost/Workfile/admin.php');
            $InsertSql="UPDATE users SET Logintime = NOW() WHERE Email='$u_acc'";
            $status = $connect->query($InsertSql);
           }
           else
           {
           // 處理完附加項後跳轉到登入成功的首頁
           header('Location:http://localhost/Workfile/index-in.php');
           $InsertSql="UPDATE users SET Logintime = NOW() WHERE Email='$u_acc'";
           $status = $connect->query($InsertSql);
           }
        }
        else
        {
           $dd="密碼錯誤!";
           header('refresh:1;url=http://localhost/Workfile/signin.html');
        }    
       }
       else
       {
        $dd="Email錯誤!";
        header('refresh:1;url=http://localhost/Workfile/signin.html');
       }
   } 
   else 
   {
      $dd="Email或密碼不能為空!";
      header('refresh:1;url=http://localhost/Workfile/signin.html');
   } 
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="images/favicon.png" rel="shortcut icon">
    <title>古拙平台</title>

    <!--====== Google Font ======-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">

    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="css/vendor.css">

    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="css/utility.css">

    <!--====== App ======-->
    <link rel="stylesheet" href="css/app.css">
</head>
<body class="config">
    <div class="preloader is-active">
        <div class="preloader__wrap">

            <img class="preloader__img" src="images/preloader.png" alt=""></div>
    </div>

    <!--====== Main App ======-->
    <div id="app">

        <!--====== Main Header ======-->
        <header class="header--style-1 header--box-shadow">

            <!--====== Nav 1 ======-->
            <nav class="primary-nav primary-nav-wrapper--border">
                <div class="container">

                    <!--====== Primary Nav ======-->
                    <div class="primary-nav">

                        <!--====== Main Logo ======-->

                        <a class="main-logo" href="index.php">

                            <img src="images/logo/logo-1.jpg" alt=""></a>
                        <!--====== End - Main Logo ======-->


                        <!--====== Search Form ======-->
                        <form class="main-form">

                            <label for="main-search"></label>

                            <input class="input-text input-text--border-radius input-text--style-1" type="text" id="main-search" placeholder="Search">

                            <button class="btn btn--icon fas fa-search main-search-button" type="submit"></button></form>
                        <!--====== End - Search Form ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation">

                            <button class="btn btn--icon toggle-button fas fa-cogs" type="button"></button>

                           <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li class="has-dropdown" data-tooltip="tooltip" data-placement="left" title="Account">

                                        <a><i class="far fa-user-circle"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:120px">
                                            <li>

                                                <a href="signup.html"><i class="fas fa-user-plus u-s-m-r-6"></i>

                                                    <span>註冊</span></a></li>
                                            <li>

                                                <a href="signin.html"><i class="fas fa-lock u-s-m-r-6"></i>

                                                    <span>登入</span></a></li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <!--li class="has-dropdown" data-tooltip="tooltip" data-placement="left" title="Settings">

                                        <a><i class="fas fa-user-cog"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <!--ul style="width:120px">
                                            <li class="has-dropdown has-dropdown--ul-right-100">

                                                <a>語言<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <!--span class="js-menu-toggle"></span>
                                                <ul style="width:120px">
                                                    <li>

                                                        <a class="u-c-brand">ENGLISH</a></li>
                                                    <li>

                                                        <a>中文</a></li>
                                                    <li>

                                                        <a>FRANCAIS</a></li>
                                                    <li>

                                                        <a>ESPANOL</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <!--li class="has-dropdown has-dropdown--ul-right-100">

                                                <a>幣值<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <!--span class="js-menu-toggle"></span>
                                                <ul style="width:225px">
                                                    <li>

                                                        <a class="u-c-brand">$ - 美金</a></li>
                                                    <li>

                                                        <a>£ - 英鎊</a></li>
                                                    <li>

                                                        <a>＄ＮＴ　－　台幣</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                        <!--/ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <li data-tooltip="tooltip" data-placement="left" title="Contact">

                                        <a href="tel:+0900901904"><i class="fas fa-phone-volume"></i></a></li>
                                    <li data-tooltip="tooltip" data-placement="left" title="Mail">

                                        <a href="mailto:contact@domain.com"><i class="far fa-envelope"></i></a></li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->
                    </div>
                    <!--====== End - Primary Nav ======-->
                </div>
            </nav>
            <!--====== End - Nav 1 ======-->


            <!--====== Nav 2 ======-->
            <nav class="secondary-nav-wrapper">
                <div class="container">

                    <!--====== Secondary Nav ======-->
                    <div class="secondary-nav">

                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation1">

                            <button class="btn btn--icon toggle-mega-text toggle-button" type="button">M</button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list">
                                    <li class="has-dropdown">

                                        <span class="mega-text">M</span>

                                        <!--====== Mega Menu ======-->

                                        <span class="js-menu-toggle"></span>
                                        <div class="mega-menu">
                                            <div class="mega-menu-wrap">
                                                <div class="mega-menu-list">
                                                    <ul>
                                                        <li class="js-active">

                                                            <a href="shop-side-version-2.php"><i class="fas fa-tv u-s-m-r-6"></i>

                                                                <span>精選商品</span></a>

                                                            <span class="js-menu-toggle js-toggle-mark"></span></li>
                                                        <li>

                                                            <a href="shop-side-version-2.php?id=1"><i class="fas fa-female u-s-m-r-6"></i>

                                                                <span>女裝</span></a>

                                                            <span class="js-menu-toggle"></span></li>
                                                        <li>

                                                            <a href="shop-side-version-2.php?id=2"><i class="fas fa-male u-s-m-r-6"></i>

                                                                <span>男裝</span></a>

                                                            <span class="js-menu-toggle"></span></li>
                                                        <li>

                                                            <a href="shop-side-version-2.php?id=3"><i class="fas fa-utensils u-s-m-r-6"></i>

                                                                <span>飾品</span></a>

                                                            <span class="js-menu-toggle"></span></li>
                                                        <!--li>

                                                            <a href="index.html"><i class="fas fa-couch u-s-m-r-6"></i>

                                                                <span>家具飾品</span></a>

                                                            <span class="js-menu-toggle"></span></li-->
                                                        <!--li>

                                                            <a href="index.html"><i class="fas fa-football-ball u-s-m-r-6"></i>

                                                                <span>運動遊戲</span></a>

                                                            <span class="js-menu-toggle"></span></li>
                                                        <li>

                                                            <a href="index.html"><i class="fas fa-heartbeat u-s-m-r-6"></i>

                                                                <span>美妝產品</span></a>

                                                            <span class="js-menu-toggle"></span></li-->
                                                    </ul>
                                                </div>

                                                <!--====== Electronics ======-->
                                                <div class="mega-menu-content js-active">

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">3D打印機和耗材
</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">3D印表機</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">3d Printing Pen</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">3d Printing Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">3d Printer Module Board</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">HOME AUDIO & VIDEO</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">TV Boxes</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">TC Receiver & Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Display Dongle</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Home Theater System</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">MEDIA PLAYERS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Earphones</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Mp3 Players</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Speakers & Radios</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Microphones</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">VIDEO GAME ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Nintendo Video Games Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Sony Video Games Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Xbox Video Games Accessories</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">安全防護</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">監控攝像頭</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Alarm System</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Security Gadgets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">CCTV Security & Accessories</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">PHOTOGRAPHY & CAMERA</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Digital Cameras</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Sport Camera & Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Camera Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Lenses & Accessories</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">ARDUINO COMPATIBLE</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Raspberry Pi & Orange Pi</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Module Board</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Smart Robot</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Board Kits</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">DSLR Camera</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Nikon Cameras</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Canon Camera</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Sony Camera</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">DSLR Lenses</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">NECESSARY ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Flash Cards</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Memory Cards</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Flash Pins</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Compact Discs</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-9 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-0.jpg" alt=""></a></div>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                </div>
                                                <!--====== End - Electronics ======-->


                                                <!--====== Women ======-->
                                                <div class="mega-menu-content">

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-6 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-1.jpg" alt=""></a></div>
                                                        </div>
                                                        <div class="col-lg-6 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-2.jpg" alt=""></a></div>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">HOT CATEGORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Dresses</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Blouses & Shirts</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">T-shirts</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Rompers</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">INTIMATES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Bras</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Brief Sets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Bustiers & Corsets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Panties</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">WEDDING & EVENTS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Wedding Dresses</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Evening Dresses</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Prom Dresses</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Flower Dresses</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">BOTTOMS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Skirts</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Shorts</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Leggings</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Jeans</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">OUTWEAR</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Blazers</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Basics Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Trench</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Leather & Suede</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">JACKETS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Denim Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Trucker Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Windbreaker Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Leather Jackets</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Tech Accessories</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Headwear</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Baseball Caps</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Belts</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">OTHER ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Bags</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Wallets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Watches</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Sunglasses</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-9 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-3.jpg" alt=""></a></div>
                                                        </div>
                                                        <div class="col-lg-3 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-4.jpg" alt=""></a></div>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                </div>
                                                <!--====== End - Women ======-->


                                                <!--====== Men ======-->
                                                <div class="mega-menu-content">

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-4 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-5.jpg" alt=""></a></div>
                                                        </div>
                                                        <div class="col-lg-4 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-6.jpg" alt=""></a></div>
                                                        </div>
                                                        <div class="col-lg-4 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-7.jpg" alt=""></a></div>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">HOT SALE</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">T-Shirts</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Tank Tops</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Polo</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Shirts</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">OUTWEAR</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Hoodies</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Trench</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Parkas</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Sweaters</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">BOTTOMS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Casual Pants</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Cargo Pants</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Jeans</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Shorts</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">UNDERWEAR</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Boxers</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Briefs</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Robes</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Socks</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">JACKETS</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Denim Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Trucker Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Windbreaker Jackets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Leather Jackets</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">SUNGLASSES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Pilot</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Wayfarer</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Square</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Round</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Eyewear Frames</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Scarves</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Hats</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Belts</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <ul>
                                                                <li class="mega-list-title">

                                                                    <a href="shop-side-version-2.html">OTHER ACCESSORIES</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Bags</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Wallets</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Watches</a></li>
                                                                <li>

                                                                    <a href="shop-side-version-2.html">Tech Accessories</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                    <br>

                                                    <!--====== Mega Menu Row ======-->
                                                    <!--div class="row">
                                                        <div class="col-lg-6 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-8.jpg" alt=""></a></div>
                                                        </div>
                                                        <div class="col-lg-6 mega-image">
                                                            <div class="mega-banner">

                                                                <a class="u-d-block" href="shop-side-version-2.html">

                                                                    <img class="u-img-fluid u-d-block" src="images/banners/banner-mega-9.jpg" alt=""></a></div>
                                                        </div>
                                                    </div>
                                                    <!--====== End - Mega Menu Row ======-->
                                                </div>
                                                <!--====== End - Men ======-->
                                    </li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation2">

                            <button class="btn btn--icon toggle-button fas fa-cog" type="button"></button>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design2 ah-list--link-color-secondary">
                                    <li>

                                        <a href="shop-side-version-2.php">新品上市</a></li>
                                    <li class="has-dropdown">

                                        <a>頁面搜索<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:170px">
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>主頁<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:118px">
                                                    <li>

                                                        <a href="index.php">主頁</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>帳戶<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="signin.html">登錄/已經註冊</a></li>
                                                    <li>

                                                        <a href="signup.html">註冊/註冊</a></li>
                                                    <li>

                                                        <a href="lost-password.html">忘記密碼</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a href="dashboard.html">帳戶資訊<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li class="has-dropdown has-dropdown--ul-left-100">

                                                        <a href="dashboard.html">管理我的帳戶<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                        <!--====== Dropdown ======-->

                                                        <span class="js-menu-toggle"></span>
                                                        <ul style="width:180px">
                                                            <li>

                                                                <a href="dash-edit-profile.html">編輯個人資料</a></li>
                                                            <li>

                                                                <a href="dash-address-book.html">編輯通訊錄</a></li>
                                                            <li>

                                                                <a href="dash-manage-order.html">管理訂單</a></li>
                                                        </ul>
                                                        <!--====== End - Dropdown ======-->
                                                    </li>
                                                    <li>

                                                        <a href="dash-my-profile.html">個人資訊</a></li>
                                                    <li class="has-dropdown has-dropdown--ul-left-100">

                                                        <a href="dash-address-book.html">地址<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                        <!--====== Dropdown ======-->

                                                        <span class="js-menu-toggle"></span>
                                                        <ul style="width:180px">
                                                            <li>

                                                                <a href="dash-address-make-default.html">默認地址</a></li>
                                                            <li>

                                                                <a href="dash-address-add.html">新增地址</a></li>
                                                            <li>

                                                                <a href="dash-address-edit.html">刪除地址</a></li>
                                                        </ul>
                                                        <!--====== End - Dropdown ======-->
                                                    </li>
                                                    <li>

                                                        <a href="dash-track-order.html">追踪訂單</a></li>
                                                    <li>

                                                        <a href="dash-my-order.html">我的訂單</a></li>
                                                    <li>

                                                        <a href="dash-payment-option.html">付款方式</a></li>
                                                    <li>

                                                        <a href="dash-cancellation.html">退貨和取消訂單</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <!--li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Empty<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <!--span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="empty-search.html">Empty Search</a></li>
                                                    <li>

                                                        <a href="empty-cart.html">Empty Cart</a></li>
                                                    <li>

                                                        <a href="empty-wishlist.html">Empty Wishlist</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>產品詳情<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="product-detail.html">產品詳情</a></li>
                                                    <li>

                                                        <a href="product-detail-variable.html">產品的詳情與變量</a></li>
                                                    <li>

                                                        <a href="product-detail-affiliate.html">會員產品詳情</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <!--li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Shop Grid Layout<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <!--span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="shop-grid-left.html">Shop Grid Left Sidebar</a></li>
                                                    <li>

                                                        <a href="shop-grid-right.html">Shop Grid Right Sidebar</a></li>
                                                    <li>

                                                        <a href="shop-grid-full.html">Shop Grid Full Width</a></li>
                                                    <li>

                                                        <a href="shop-side-version-2.html">Shop Side Version 2</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <!--li class="has-dropdown has-dropdown--ul-left-100">

                                                <a>Shop List Layout<i class="fas fa-angle-down i-state-right u-s-m-l-6"></i></a>

                                                <!--====== Dropdown ======-->

                                                <!--span class="js-menu-toggle"></span>
                                                <ul style="width:200px">
                                                    <li>

                                                        <a href="shop-list-left.html">Shop List Left Sidebar</a></li>
                                                    <li>

                                                        <a href="shop-list-right.html">Shop List Right Sidebar</a></li>
                                                    <li>

                                                        <a href="shop-list-full.html">Shop List Full Width</a></li>
                                                </ul>
                                                <!--====== End - Dropdown ======-->
                                            </li>
                                            <li>

                                                <a href="cart.html">購物車</a></li>
                                            <li>

                                                <a href="wishlist.html">願望清單</a></li>
                                            <li>

                                                <a href="checkout.html">訂單確認</a></li>
                                            <li>

                                                <a href="faq.html">FAQ</a></li>
                                            <li>

                                                <a href="about.html">關於我們</a></li>
                                            <li>

                                                <a href="contact.html">連結</a></li>
                                            <li>

                                                <a href="404.html">404</a></li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <li class="has-dropdown">

                                        <a>社群<i class="fas fa-angle-down u-s-m-l-6"></i></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <ul style="width:200px">
                                            <!--li>

                                                <a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                            <li>

                                                <a href="blog-right-sidebar.html">Blog Right Sidebar</a></li-->
                                            <li>

                                                <a href="blog-sidebar-none.html">部落格</a></li>
                                            <li>

                                                <a href="blog-masonry.html">社群紀錄</a></li>
                                            <li>

                                                <a href="blog-detail.html">文章連結</a></li>
                                        </ul>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                    <li>

                                        <a href="shop-side-version-2.php">市場均價</a></li>
                                    <li>

                                        <a href="shop-side-version-2.php">折扣卡</a></li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->


                        <!--====== Dropdown Main plugin ======-->
                        <div class="menu-init" id="navigation3">

                            <button class="btn btn--icon toggle-button fas fa-shopping-bag toggle-button-shop" type="button"></button>

                            <span class="total-item-round">2</span>

                            <!--====== Menu ======-->
                            <div class="ah-lg-mode">

                                <span class="ah-close">✕ Close</span>

                                <!--====== List ======-->
                                <ul class="ah-list ah-list--design1 ah-list--link-color-secondary">
                                    <li>

                                        <a href="index.php"><i class="fas fa-home"></i></a></li>
                                    <li>

                                        <a href="wishlist.html"><i class="far fa-heart"></i></a></li>
                                    <li class="has-dropdown">

                                        <a class="mini-cart-shop-link"><i class="fas fa-shopping-bag"></i>

                                            <span class="total-item-round">2</span></a>

                                        <!--====== Dropdown ======-->

                                        <span class="js-menu-toggle"></span>
                                        <div class="mini-cart">

                                            <!--====== Mini Product Container ======-->
                                            <div class="mini-product-container gl-scroll u-s-m-b-15">

                                                <!--====== Card for mini cart ======-->
                                                <div class="card-mini-product">
                                                    <div class="mini-product">
                                                        <div class="mini-product__image-wrapper">

                                                            <a class="mini-product__link" href="product-detail.html">

                                                                <img class="u-img-fluid" src="images/product/electronic/product3.jpg" alt=""></a></div>
                                                        <div class="mini-product__info-wrapper">

                                                            <span class="mini-product__category">

                                                                <a href="shop-side-version-2.php">Electronics</a></span>

                                                            <span class="mini-product__name">

                                                                <a href="product-detail.html">Yellow Wireless Headphone</a></span>

                                                            <span class="mini-product__quantity">1 x</span>

                                                            <span class="mini-product__price">$8</span></div>
                                                    </div>

                                                    <a class="mini-product__delete-link far fa-trash-alt"></a>
                                                </div>
                                                <!--====== End - Card for mini cart ======-->


                                                <!--====== Card for mini cart ======-->
                                                <div class="card-mini-product">
                                                    <div class="mini-product">
                                                        <div class="mini-product__image-wrapper">

                                                            <a class="mini-product__link" href="product-detail.html">

                                                                <img class="u-img-fluid" src="images/product/electronic/product18.jpg" alt=""></a></div>
                                                        <div class="mini-product__info-wrapper">

                                                            <span class="mini-product__category">

                                                                <a href="shop-side-version-2.php">Electronics</a></span>

                                                            <span class="mini-product__name">

                                                                <a href="product-detail.html">Nikon DSLR Camera 4k</a></span>

                                                            <span class="mini-product__quantity">1 x</span>

                                                            <span class="mini-product__price">$8</span></div>
                                                    </div>

                                                    <a class="mini-product__delete-link far fa-trash-alt"></a>
                                                </div>
                                                <!--====== End - Card for mini cart ======-->


                                                <!--====== Card for mini cart ======-->
                                                <div class="card-mini-product">
                                                    <div class="mini-product">
                                                        <div class="mini-product__image-wrapper">

                                                            <a class="mini-product__link" href="product-detail.html">

                                                                <img class="u-img-fluid" src="images/product/women/product8.jpg" alt=""></a></div>
                                                        <div class="mini-product__info-wrapper">

                                                            <span class="mini-product__category">

                                                                <a href="shop-side-version-2.php">Women Clothing</a></span>

                                                            <span class="mini-product__name">

                                                                <a href="product-detail.html">New Dress D Nice Elegant</a></span>

                                                            <span class="mini-product__quantity">1 x</span>

                                                            <span class="mini-product__price">$8</span></div>
                                                    </div>

                                                    <a class="mini-product__delete-link far fa-trash-alt"></a>
                                                </div>
                                                <!--====== End - Card for mini cart ======-->


                                                <!--====== Card for mini cart ======-->
                                                <div class="card-mini-product">
                                                    <div class="mini-product">
                                                        <div class="mini-product__image-wrapper">

                                                            <a class="mini-product__link" href="product-detail.html">

                                                                <img class="u-img-fluid" src="images/product/men/product8.jpg" alt=""></a></div>
                                                        <div class="mini-product__info-wrapper">

                                                            <span class="mini-product__category">

                                                                <a href="shop-side-version-2.php">Men Clothing</a></span>

                                                            <span class="mini-product__name">

                                                                <a href="product-detail.html">New Fashion D Nice Elegant</a></span>

                                                            <span class="mini-product__quantity">1 x</span>

                                                            <span class="mini-product__price">$8</span></div>
                                                    </div>

                                                    <a class="mini-product__delete-link far fa-trash-alt"></a>
                                                </div>
                                                <!--====== End - Card for mini cart ======-->
                                            </div>
                                            <!--====== End - Mini Product Container ======-->


                                            <!--====== Mini Product Statistics ======-->
                                            <div class="mini-product-stat">
                                                <div class="mini-total">

                                                    <span class="subtotal-text">小計</span>

                                                    <span class="subtotal-value">$16</span></div>
                                                <div class="mini-action">

                                                    <a class="mini-link btn--e-brand-b-2" href="checkout.html">結帳</a>

                                                    <a class="mini-link btn--e-transparent-secondary-b-2" href="cart.html">查看購物車</a></div>
                                            </div>
                                            <!--====== End - Mini Product Statistics ======-->
                                        </div>
                                        <!--====== End - Dropdown ======-->
                                    </li>
                                </ul>
                                <!--====== End - List ======-->
                            </div>
                            <!--====== End - Menu ======-->
                        </div>
                        <!--====== End - Dropdown Main plugin ======-->
                    </div>
                    <!--====== End - Secondary Nav ======-->
                </div>
            </nav>
            <!--====== End - Nav 2 ======-->
        </header>
        <!--====== End - Main Header ======-->


        <!--====== App Content ======-->
        <div class="app-content">

            <!--====== Section 1 ======-->
            <div class="u-s-p-y-60">

                <!--====== Section Content ======-->
                <div class="section__content">
                    <div class="container">
                        <div class="breadcrumb">
                            <div class="breadcrumb__wrap">
                                <ul class="breadcrumb__list">
                                    <li class="has-separator">

                                        <a href="index.php">首頁</a></li>
                                    <li class="is-marked">

                                        <a href="signin.html">登入</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--====== End - Section 1 ======-->


            <!--====== Section 2 ======-->
            <div class="u-s-p-b-60">

                <!--====== Section Intro ======-->
                <div class="section__intro u-s-m-b-60">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section__text-wrap">
                                    <h1 class="section__heading u-c-secondary"><?php echo"$dd";?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--====== End - Section Intro ======-->


                <!--====== Section Content ======-->
                <!--====== End - Section Content ======-->
            </div>
            <!--====== End - Section 2 ======-->
        </div>
        <!--====== End - App Content ======-->


        <!--====== Main Footer ======-->
        <footer>
            <div class="outer-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="outer-footer__content u-s-m-b-40">

 <span class="outer-footer__content-title">聯繫我們</span>
                                <div class="outer-footer__text-wrap"><i class="fas fa-home"></i>

                                    <span>台北市內湖區xx路87號</span></div>
                                <div class="outer-footer__text-wrap"><i class="fas fa-phone-volume"></i>

                                    <span>02-2459-6853</span></div>
                                <div class="outer-footer__text-wrap"><i class="far fa-envelope"></i>

                                    <span>ANKLESCLOTHES@gmail.com</span></div>
                                <div class="outer-footer__social">
                                    <ul>
                                        <li>

                                            <a class="s-fb--color-hover" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li>

                                            <a class="s-tw--color-hover" href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li>

                                            <a class="s-youtube--color-hover" href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li>

                                            <a class="s-insta--color-hover" href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li>

                                            <a class="s-gplus--color-hover" href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="outer-footer__content u-s-m-b-40">

                                        <span class="outer-footer__content-title">資訊</span>
                                        <div class="outer-footer__list-wrap">
                                            <ul>
                                                <li>

                                                    <a href="cart.html">購物車</a></li>
                                                <li>

                                                    <a href="dashboard.html">帳戶</a></li>
                                                <li>

                                                    <a href="shop-side-version-2.php">合作夥伴</a></li>
                                                <li>

                                                    <a href="dash-payment-option.html">付款資訊</a></li>
                                                <li>

                                                    <a href="shop-side-version-2.php">我的商城</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="outer-footer__content u-s-m-b-40">
                                        <div class="outer-footer__list-wrap">

                                            <span class="outer-footer__content-title">關於我們</span>
                                            <ul>
                                                <li>

                                                    <a href="about.html">關於我們</a></li>
                                                <li>

                                                    <a href="contact.html">聯繫我們</a></li>
                                                <li>

                                                    <a href="index.php">網站地圖</a></li>
                                                <li>

                                                    <a href="dash-my-order.html">商品進度</a></li>
                                                <li>

                                                    <a href="shop-side-version-2.php">商城</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="outer-footer__content">

                                <span class="outer-footer__content-title">加入我們的即時通訊</span>
                                <form class="newsletter">
                                    <div class="u-s-m-b-15">
                                        <div class="radio-box newsletter__radio">

                                            <input type="radio" id="male" name="gender">
                                            <div class="radio-box__state radio-box__state--primary">

                                                <label class="radio-box__label" for="male">男生</label></div>
                                        </div>
                                        <div class="radio-box newsletter__radio">

                                            <input type="radio" id="female" name="gender">
                                            <div class="radio-box__state radio-box__state--primary">

                                                <label class="radio-box__label" for="female">女生</label></div>
                                        </div>
                                    </div>
                                    <div class="newsletter__group">

                                        <label for="newsletter"></label>

                                        <input class="input-text input-text--only-white" type="text" id="newsletter" placeholder="輸入電子郵件">

                                        <button class="btn btn--e-brand newsletter__btn" type="submit">訂閱</button></div>

                                    <span class="newsletter__text">訂閱我們以得到最新資訊</span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lower-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="lower-footer__content">
                                <div class="lower-footer__copyright">

                                    <span>Copyright © 2018</span>

                                    <a href="index.php">Reshop</a>

                                    <span>All Right Reserved</span></div>
                                    <ul>
                                        <li><i class="fab fa-cc-stripe"></i></li>
                                        <li><i class="fab fa-cc-paypal"></i></li>
                                        <li><i class="fab fa-cc-mastercard"></i></li>
                                        <li><i class="fab fa-cc-visa"></i></li>
                                        <li><i class="fab fa-cc-discover"></i></li>
                                        <li><i class="fab fa-cc-amex"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--====== End - Main App ======-->


    <!--====== Google Analytics: change UA-XXXXX-Y to be your site's ID ======-->
    <script>
        window.ga = function() {
            ga.q.push(arguments)
        };
        ga.q = [];
        ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>

    <!--====== Vendor Js ======-->
    <script src="js/vendor.js"></script>

    <!--====== jQuery Shopnav plugin ======-->
    <script src="js/jquery.shopnav.js"></script>

    <!--====== App ======-->
    <script src="js/app.js"></script>

    <!--====== Noscript ======-->
    <noscript>
        <div class="app-setting">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="app-setting__wrap">
                            <h1 class="app-setting__h1">JavaScript is disabled in your browser.</h1>

                            <span class="app-setting__text">Please enable JavaScript in your browser or upgrade to a JavaScript-capable browser.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </noscript>
</body>
</html>