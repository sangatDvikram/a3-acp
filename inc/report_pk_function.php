<?php
function scheckReportPKStatus($id)
{

	 try
            {
            	Global $MysqlConnect;

    $statement="SELECT Count(*) as Total FROM report_pk WHERE report_sr=:report_sr and (reporter_id=:reporter_id or ip=:ip) ";
    $query=$MysqlConnect->prepare($statement);
        $query->execute(array(":report_sr"=>$id,':reporter_id'=>$_SESSION['username'],':ip'=>$_SERVER['REMOTE_ADDR']));
        $result=$query->fetch(PDO::FETCH_NAMED);
        
         if($result['Total']>0) 
         {
         	return  '<a href="#reportModal" class="btn btn-invert report disabled"  id='.$id.' title="Reported"><i class="icon-ok icon-white" title="Reported"></i></a>';
         	
         }
         else
         {
         	return  '<a href="#reportModal" class="btn btn-warning report" data-toggle="modal" id='.$id.' title="Report"><i class="icon-warning-sign" title="Report"></i></a>';
         }

         } catch (PDOException $e)
          {
                die( " Something Went Wrong ");
            }
}
function generateReportedPk_Count()
{
	
	 try
            {
            	Global $MysqlConnect;

    $statement="SELECT Count(*) as Total FROM report_pk WHERE accepted=0 ";
    $query=$MysqlConnect->prepare($statement);
        $query->execute();
        $result=$query->fetch(PDO::FETCH_NAMED);
        

         if($result['Total']>0) 

         	return  "<span class='' title='$result[Total] new reported PK !!'>$result[Total]</span> ";
         

         } catch (PDOException $e)
          {
                die( " Something Went Wrong ");
            }
}

?>