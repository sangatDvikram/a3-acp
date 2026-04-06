    <?php
    include '../inc/config.php';
    include '../inc/secondary_functions.php';

    if(isset($_POST)) 
    {
        foreach($_POST as $key => $value) {
    $data[$key] = antisql($value); // post variables are filtered
}
    	try
    		{

                /*
                Error Checking.

                */

        $ip=$_SERVER['REMOTE_ADDR'];
        $reporter_id=$_SESSION['username'];
        //This is kalprit 
        $id = antisql($_POST['id']);
        $statement="Select fake from pvplog where sr_no='$id'";
        $query=$OdbcConnect->prepare($statement);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_NAMED);

        if($result['fake']!=0)
        {
            echo json_encode(array('message'=>$message .'This PK Report Has alredy been resolved !! <br> ;)','error'=>'Failed'));
            exit();
        }
        $statement="SELECT count(ip) as reportCount FROM report_pk WHERE (ip=:ip OR reporter_id=:reporter_id) AND report_sr=:report_sr";
        $query=$MysqlConnect->prepare($statement);
        $query->execute(array(
            ":reporter_id"=>$reporter_id,
            ":ip"=>$ip,
            ":report_sr"=>$id

            ));
        $result=$query->fetch(PDO::FETCH_NAMED);

        if($result['reportCount']>0)
        {
            $message=($result['reportCount']>3)?"You can only report Max 3 Pk every day !!":"You have alredy reported this PK !!";
            echo json_encode(array('message'=>$message .'Beter Luck Next Time !! ;)','error'=>'Failed'));
            exit();
        }
         if(!$_SESSION['username'])
        {
            echo json_encode(array('message'=>'Make Sure Your are Logged in !! Beter Luck Next Time !! ;)','error'=>'Failed'));
            exit();
        }
        $statement="INSERT INTO report_pk (reporter_id,report_sr,ip,accepted) values (:reporter_id,:report_sr,:ip,:accepted)";
    	$query=$MysqlConnect->prepare($statement);
    	$query->execute(array(
    		":reporter_id"=>$reporter_id,
    		":report_sr"=>$id,
    		":ip"=>$ip,
    		":accepted"=>0
    		)); 

    	echo json_encode(array('message'=>'Report Sent For Verification.','error'=>'Success'));

    	} catch (PDOException $e) {
    			echo json_encode(array('message'=>$e->getMessage(),'error'=>'Failed'));
    		}
    }
