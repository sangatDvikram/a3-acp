    <?php
    include '../inc/config.php';
    include '../inc/secondary_functions.php';
    //include '/report_pk_function.php';
    
    if(1){
    try
            {

    $statement="SELECT Count(*) as Total,`report_sr` FROM `report_pk` where accepted=0 group by `report_sr` order by 1 desc";
    $query=$MysqlConnect->prepare($statement);
        $query->execute();
        $result=$query->fetchAll(PDO::FETCH_NAMED);
        $data=array();
        $i=1;
        foreach ($result as $value) {
        
            $statement="SELECT * FROM pvplog WHERE sr_no=:sr_no AND fake<5 ";
            $query=$OdbcConnect->prepare($statement);
            $query->execute(array(":sr_no"=>$value['report_sr']));
            $result=$query->fetch(PDO::FETCH_NAMED);
            $details="Killer: <a href='/player/$result[killer]'>$result[killer]</a> (RS$result[killer_reset],RB$result[killer_rb],LVL$result[killer_lv])<br> Victim: <a href='/player/$result[victim]'>$result[victim]</a> (RS$result[victim_reset],RB$result[victim_rb],LVL$result[victim_lv]) ";
            $killtime=$result['killtime'];

            $operations = '<a href="#take_action" class="btn btn-danger take_action yes" data-toggle="modal" id='.$value['report_sr'].' title="Yes"><i class="icon-ok icon-white" title="Yes"></i></a> | <a href="#take_action" class="btn btn-success take_action no" data-toggle="modal" id='.$value['report_sr'].' title="No"><i class=" icon-remove icon-white" title="No"></i></a>';
 
            $array=array($i,$value['report_sr'],$details,$killtime,$value['Total'],$operations);
            $data[$i-1]=array_values($array);
        
            $i++;
        }
        echo json_encode(array('data'=>array_values($data)));
    } catch (PDOException $e) {
                die($e->getMessage());
            }
        }