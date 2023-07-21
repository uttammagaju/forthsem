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
    <title>ADD product</title>
    <?php include_once('include/cssandicon.php') ?>
</head>
<body>
    <?php include_once('include/navigation.php')?>
        <?php  
         $errproduct_name=$errsp=$errcp=$errqtystc=$errcompany_id=$errmfg=$errexp= $chK_amt=$errstc='';  
        $product_name=$sp=$cp=$qtystc=$company_id=$mfg=$exp='';
        $conn=mysqli_connect('localhost','root','','dms') or die("Error: could not connect.".mysqli_connect_error());    
                if(isset($_POST['submit'])){
                  $product_name=$_POST['product_name'];
                    $sp=$_POST['selling_price'];
                    $cp=$_POST['cost_price'];
                    $qtystc=$_POST['quantity_stock'];
                    $mfgdatepick=$_POST['mfgdatepick'];
                    $mfg=date('y-m-d',strtotime($mfgdatepick));
                    $manfg=strtotime("$mfg");
                    $expdatepick=$_POST['expdatepick'];
                    $exp=date('y-m-d',strtotime($expdatepick));
                    $expfg=strtotime("$exp");
                    $today=strtotime("today");
                    $company_id=$_POST['company_id'];
                    if(empty($product_name)){
                      $errproduct_name="Please enter product name"."<br>";
                    }
                    else if($sp<$cp || $sp<0){
                      $chK_amt= "please selling price must be postive and greater than cost price";
                    }
                    else if($qtystc<0){
                      $errstc= "quantity cannot be negative";
                    }
                    else if($manfg>$today){
                      $errmfg="error in selecting mfg data";
                    }
                    else if($manfg>$expfg){
                      $errexp="error in selecting data";
                    }
                    else if(empty($sp)){
                      $errsp="Please empty selling price"."<br>";
                    }
                    else if(empty($cp)){
                      $errcp= "please enter cost price"."<br>";
                    }
                    
                    else if(empty($qtystc)){
                      $errqtystc="please enter cost Quantity stock"."<br>";
                    }
                   else if(empty($company_id)){
                      $errcompany_id= "please enter company id"."<br>";
                    }
                    else{

                            $sql="INSERT INTO products(product_name,selling_price,cost_price,quantity_stock,expired_date,mfg_date,company_id)
                            VALUES (?,?,?,?,?,?,?)";
                            if($stmt=mysqli_prepare($conn,$sql)){
                            mysqli_stmt_bind_param($stmt,'siisssi',$product_name,$sp,$cp,$qtystc,$exp,$mfg,$company_id);
                            
                            if(mysqli_stmt_execute($stmt)){
                            echo "company added successfully";
                            echo "<script> window.location.href='view_product.php'</script>";
                            }
                            else{
                            echo "something went wrong. Please try again";
                            echo "<script> alert(window.location.href='add_product.php'</script>)";
                          }
                          }
                          else{
                              echo " Error: could not prepared query: $sql.".mysqli_error($link);
                              }
                          
                          mysqli_stmt_close($stmt);
                          mysqli_close($conn);
                      }
          }
                
            ?>
            
            <div id="body">
             <h1>Add Product</h1>
            
              <div>
                      <br>
                  
                          
                  <form name="validation"   action="" method="post">
                        Product Name: <input type="text" name="product_name"><br>
                        <div id="message"><?php 
                     echo $errproduct_name;
                      ?> </div>
                        Selling Price: <input type="text" name="selling_price" ><br>
                        <div id="message"><?php 
                     echo $errsp;
                     echo $chK_amt;
                      ?> </div>
                        Cost Price: <input type="text" name="cost_price" ><br>
                        <div id="message"><?php 
                     echo $errcp;
                      ?> </div>
                        Quantity Stock: <input type="text" name="quantity_stock" ><br>
                        <div id="message"><?php 
                     echo $errqtystc;
                     echo $errstc;
                      ?> </div>
                        Manufacture Date: <input type="date" name="mfgdatepick"> <br>
                        <div id="message"><?php 
                     echo $errmfg;
                      ?> </div>
                        Expire Date: <input type="date" name="expdatepick" ><br>
                        <div id="message"><?php if($exp!='0000-00-00'){
                     echo $errexp;
                     
                        }
                      ?> </div>
                        Company id: 
                        <select name="company_id">
                        <option value="">Select company id</option>
                        <?php
                                $sql1="select * from companys";
                                $result=mysqli_query($conn,$sql1);
                                While($row=mysqli_fetch_assoc($result)){
                              echo "<option value=$row[company_id]>". $row['company_name'] ."</option>";    
                        }
                        ?>   
                      </select>
                      <div id="message"><?php 
                     echo $errcompany_id;
                      ?> </div>

                    <input type="submit" value="ADD" name="submit" onclick="add_product()">
                    <!-- <script type="text/javascript" src="js/productadd.js"></script> -->
                  </form>
                  <p id="result"></p>
            
              </div>
              <div class="foot center">
                         <?php include_once('include/footer.php')?>
                     </div>
         </div>
         

</body>
</html>
<?php
}
?>