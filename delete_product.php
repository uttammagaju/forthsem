<?php 
 $product_id=$_GET['product_id']; 
echo $product_id;
$conn =mysqli_connect('localhost','root','','dms');
$sql="DELETE from products where product_id=$product_id";
if(mysqli_query($conn,$sql)){
    header('location:view_product.php');
 }
 else{
     echo "can not delete";
 }
?>
