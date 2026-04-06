    <?php
    include '../inc/config.php';
    include '../inc/secondary_functions.php';

if(isset($_SESSION['grade'])&&$_SESSION['grade'] == "BAN")
{
    if(isset($_POST)) 
    {
        foreach($_POST as $key => $value) {
    $data[$key] = antisql($value); // post variables are filtered
}
    	try
    		{

                //GENERATE CURL 
            $url = ($_POST['type']=='Yes') ? "/beta/index.php/api/pk/reportfake/format/json" : "/beta/index.php/api/pk/rejectfake/format/json";
            $fields = array(
                        'id'=>urlencode($_POST['id']),
                        'grade'=>urlencode($_SESSION['grade'])
                        
                    );

          

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
            //execute post
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result;

    	} catch (PDOException $e) {
    			echo json_encode(array('message'=>$e->getMessage(),'error'=>'Failed'));
    		}
    }
}
else
{
    echo json_encode(array('message'=>'Make Sure You are logged in !!','error'=>'Failed'));
}