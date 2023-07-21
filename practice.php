 <?php
            $conn=mysqli_connect('localhost','root','','dms');
            $sql="SELECT company_id,company_name,posting_date,admin_id from companys ORDER BY company_id desc";
            $result=mysqli_query($conn,$sql);
            $data=[];
            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    array_unshift($data,$row);
                }
            }
            foreach($data as $d){

                echo $d['admin_id'];
                $id=$d['admin_id'];
                $sql1="select username from admins where admin_id=$id";
                $res=mysqli_query($conn,$sql1);
                $row=mysqli_fetch_assoc($res);
                echo $row['username'];
            }
       ?>
        