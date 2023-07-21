<?php
 $company_id=$_GET['company_id']; 
 echo $company_id;
 $conn=mysqli_connect('localhost','root','','dms');
 $sql=" DELETE from companys WHERE company_id=$company_id";
 if(mysqli_query($conn,$sql)){
    header('location:view_company.php');
 }
 else{
     echo "can not delete";
 }

?>
