<?php
function generateReportedPk()
{
	
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

            return  "<span class='badge badge-info' title='$result[Total] new reported PK !!'>$result[Total]</span> ";
         

         } catch (PDOException $e)
          {
                die($e->getMessage());
            }
}