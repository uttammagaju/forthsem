<?php
session_start();
$conn=mysqli_connect('localhost','root','','dms');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Product</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
<?php include_once('include/navigation.php') 

?>
<div id="body">
    <div id="search">
        <hr>
    <h1>Search product</h1>
    <hr>
    <form  method="post">
        Product Name:<br>
        <input type="text" name="productname">
        <input type="submit" value="Search" name="submit">
    </form>
    <?php 
    $pname='';
    if(isset($_POST['submit'])){
        $productname=$_POST['productname'];
        $pname=strtolower($productname);
        if(empty($pname)){
            echo "Please enter product name";
        }else{
        $conn=mysqli_connect('localhost','root','','dms');
        $sql="SELECT * FROM `products` WHERE product_name LIKE '%$pname%'";
        $result=mysqli_query($conn,$sql);
        $cnt=1;
        $data=[];
        if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_array($result))
        {
            array_unshift($data,$row);
        }
    }
        foreach($data as $d){
     ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Product Name</th>
                    <th>Manufacture Date</th>
                    <th>Expired Date</th>
                    <th>Pricing</th>
                    
                </tr>   
            </thead>
            <tbody>
                
         <form action="search_product.php?action=add&pid=<?php echo $d["product_id"]; ?>" method="post">
             <tr>
             <td><?php echo $cnt;?></td>
             <td><?php $id=$d['company_id'];
                $sql1="select company_name from companys where company_id=$id";
                $res=mysqli_query($conn,$sql1);
                $row=mysqli_fetch_assoc($res);
                echo $row['company_name'];?></td>
             <td><?php echo $d['product_name'];?></td>
             <td><?php echo $d['mfg_date'];?></td>
             <td><?php echo $d['expired_date'];?></td>
             <td><?php echo $d['selling_price'];?></td>
         </tr>
     </form>     
     <?php
     $cnt++;
                }    
            }
     ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
    
</div>
<div class="foot">
<?php include_once('include/footer.php')?>
<div>
</body>
</html>
<?php
}
?>