<?php
include('Linkmysql.php');
$img=$_POST['file'];
$cid=$_POST['category_id'];
$cn=$_POST['C_Name'];
$pn=$_POST['name'];
$p=$_POST['price'];
$qut=$_POST['quantity'];
$c=$_POST['color'];
$s=$_POST['size'];
$a=$_POST['about'];
session_start();
$SelectSql="SELECT id FROM size WHERE name='$s'";
$result=$connect->query($SelectSql);
$rows = $result->fetch_assoc();
$si=@$rows['id'];
if($pn&&$p&&$qut&&$c&&$s&&$a&&$cn&&$cid)
{
    $SelectSql = "SELECT Name FROM products WHERE Name='$pn'";
    $result=$connect->query($SelectSql);
    $rows = $result->fetch_assoc();
    $pdn=@$rows['Name'];
    if($pn==$pdn)
    {
        $SelectSql = "SELECT id FROM products WHERE Name='$pn'";
        $result=$connect->query($SelectSql);
        $rows = $result->fetch_assoc();
        $pid=@$rows['id'];

        $SelectSql2="SELECT s_id,colors FROM products_details WHERE p_id='$pid'";
        $result2=$connect->query($SelectSql2);
        $rows2= $result2->fetch_assoc();
        $sid=@$rows2['s_id'];
        $cl=@$rows2['colors'];
        if($c==$cl)
        {
            if($si!=$sid)
            {
                $InsertSql = "INSERT INTO products_details(colors, Price, quantity, about,p_id, s_id) VALUES ('$c','$p','$qut','$a','$pid','$si')";		
                $result = $connect->query($InsertSql);
                if($cid!="true"&&$cn!="true")
                {
                    $SelectSql="SELECT product_id FROM category_product  WHERE product_id='$pid'";
                    $result=$connect->query($SelectSql);
                    $rows = $result->fetch_assoc();
                    if($pid!=@$rows['product_id'])
                    {
                        $InsertSql = "INSERT INTO category_product(C_Name, product_id, category_id) VALUES ('$cn','$pid','$cid')";	
                        $status = $connect->query($InsertSql);
                        echo'
                        <script>
                        alert("新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html'); 
                    }
                    else
                    {
                        echo'
                        <script>
                        alert("已有此類別,新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html');
                    }
                }
                else
                {
                    echo'
                    <script>
                    alert("未選擇類別");
                    </script>';
                    header('refresh:0;url=http://localhost/Workfile/upload.html');
                }
            }
            else
            {
                echo'
                <script>
                alert("已有此尺寸");
                </script>';
                header('refresh:0;url=http://localhost/Workfile/upload.html');
            }   
        }
        else
        {
            if($si!=$sid)
            {
                $InsertSql = "INSERT INTO products_details(colors, Price, quantity, about,p_id, s_id) VALUES ('$c','$p','$qut','$a','$pid','$si')";		
                $result = $connect->query($InsertSql);
                if($cid!="true"&&$cn!="true")
                {
                    $SelectSql="SELECT product_id FROM category_product  WHERE product_id='$pid'";
                    $result=$connect->query($SelectSql);
                    $rows = $result->fetch_assoc();
                    if($pid!=@$rows['product_id'])
                    {
                        $InsertSql = "INSERT INTO category_product(C_Name, product_id, category_id) VALUES ('$cn','$pid','$cid')";	
                        $status = $connect->query($InsertSql);
                        echo'
                        <script>
                        alert("新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html'); 
                    }
                    else
                    {
                        echo'
                        <script>
                        alert("已有此類別,新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html');
                    }
                }
                else
                {
                    echo'
                    <script>
                    alert("未選擇類別");
                    </script>';
                    header('refresh:0;url=http://localhost/Workfile/upload.html');
                }

            }
            else
            {
                $InsertSql = "INSERT INTO products_details(colors, Price, quantity, about,p_id, s_id) VALUES ('$c','$p','$qut','$a','$pid','$si')";		
                $result = $connect->query($InsertSql);
                if($cid!="true"&&$cn!="true")
                {
                    $SelectSql="SELECT product_id FROM category_product  WHERE product_id='$pid'";
                    $result=$connect->query($SelectSql);
                    $rows = $result->fetch_assoc();
                    if($pid!=@$rows['product_id'])
                    {
                        $InsertSql = "INSERT INTO category_product(C_Name, product_id, category_id) VALUES ('$cn','$pid','$cid')";	
                        $status = $connect->query($InsertSql);
                        echo'
                        <script>
                        alert("新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html'); 
                    }
                    else
                    {
                        echo'
                        <script>
                        alert("已有此類別,新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html');
                    }
                }
                else
                {
                    echo'
                    <script>
                    alert("未選擇類別");
                    </script>';
                    header('refresh:0;url=http://localhost/Workfile/upload.html');
                }
            }   
        }
    }
    else
    {
        $InsertSql = "INSERT INTO products(Name, Price,Image) VALUES ('$pn','$p','$img')";	
        $status= $connect->query($InsertSql);

        $SelectSql = "SELECT id FROM products WHERE Name='$pn'";
        $result=$connect->query($SelectSql);
        $rows = $result->fetch_assoc();
        $pid=@$rows['id'];

        $SelectSql2="SELECT s_id FROM products_details WHERE p_id='$pid'";
        $result2=$connect->query($SelectSql2);
        $rows = $result2->fetch_assoc();
        $sid=@$rows['s_id'];
        if($si!=$sid)
        {
                $InsertSql = "INSERT INTO products_details(colors, Price, quantity, about,p_id, s_id) VALUES ('$c','$p','$qut','$a','$pid','$si')";	
                $result = $connect->query($InsertSql);
                if($cid!="true"&&$cn!="true")
                {
                    $SelectSql="SELECT product_id FROM category_product";
                    $result=$connect->query($SelectSql);
                    $rows = $result->fetch_assoc();
                    if($pid==@$rows['id'])
                    {
                        echo'
                        <script>
                        alert("新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html'); 
                    }
                    else
                    {
                        $InsertSql = "INSERT INTO category_product(C_Name, product_id, category_id) VALUES ('$cn','$pid','$cid')";	
                        $status = $connect->query($InsertSql);
                        echo'
                        <script>
                        alert("新增成功");
                        </script>';
                        header('refresh:0;url=http://localhost/Workfile/upload.html'); 
                    }
                }
                else
                {
                    $DeleteSql= "DELETE FROM products WHERE Id=$pid";
                    $del = $connect->query($DeleteSql);
                    $DeleteSql2= "DELETE FROM products_details WHERE p_id=$pid";
                    $del2 = $connect->query($DeleteSql2);
                    echo'
                    <script>
                    alert("未選擇類別");
                    </script>';
                    header('refresh:0;url=http://localhost/Workfile/upload.html');
                }
        }
        else
        {
            echo'
            <script>
            alert("已有此尺寸");
            </script>';
            header('refresh:0;url=http://localhost/Workfile/upload.html');
        }  
    }
 
}
else
{
    echo'
    <script>
    alert("請輸入完整");
    </script>';
    header('refresh:0;url=http://localhost/Workfile/upload.html');
}
?>