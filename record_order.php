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
    <title> Record Order</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
    <?php include_once('include/navigation.php')?>
        <?php
             
               $conn=mysqli_connect('localhost','root','','dms') or die("Error: could not connect.".mysqli_connect_error());
               $customer_id=$order_id='';
               $errcustomer_id=$errorder_id='';
            
                if(isset($_POST['submit'])){   
                    $order_id=$_POST['order_id'];
                    $datepass= $_POST['datepass'];
                    $order_date=date('y-m-d',strtotime($datepass));
                    // echo $order_date;
                    $customer_id=$_POST['customer_id'];
                    if(empty($customer_id)){
                    $errcustomer_id="please select customer name"."<br>";
                    }
                    else if(empty($order_id)){
                        $errorder_id="please enter order id"."<br>";
                        }else{       
                    $sql5="INSERT into orders(order_id,order_date,customer_id) VALUES(?,?,?)";
                    if($stmt=mysqli_prepare($conn,$sql5)){
                    mysqli_stmt_bind_param($stmt,'isi',$order_id,$order_date,$customer_id);
                   
                    if(mysqli_stmt_execute($stmt)){
                    echo "company added successfully";
                    echo "<script> window.location.href='record_order.php'</script>";
                    }
                    else{
                    echo "something went wrong. Please try again";
                    echo "<script> alert(window.location.href='record_order.php'</script>)";
                 }
                }
                 else{
                    echo " Error: could not prepared query: $sql.".mysqli_error($conn);
                     }
                
                mysqli_stmt_close($stmt);
                 mysqli_close($conn);
                    }
        }
           
            
                
        ?>
        <!-- <?=$error?> -->

        <div id="body">
        <h1>Record Order</h1>
        
        <div>
            <br>
        <form action="" method="post">
                Order id: <input type="text" name="order_id" ><br>
                <div id="message"><?php 
                     echo $errorder_id;
                      ?> </div>
                Customer Name:
                <select name='customer_id'>
                <option value="">select customer</option>;
                <?php
                $query=mysqli_query($conn,"select * from customers");
                       while($row=mysqli_fetch_assoc($query)){
                    echo "<option value=$row[customer_id] >".$row['fullname']."</option>";
                }
                ?>
                </select><br>
                <div id="message"><?php 
                     echo $errcustomer_id;
                      ?> </div>
                Order Date: <input type="date" name="datepass" ><br>
                
                
                    <input type="submit" value="ADD" name="submit" >
        </form>
        <div class="foot">
<?php include_once('include/footer.php')?>
<div>
        </div>
      
        </div>
        

</body>
</html>
<?php
}
?>