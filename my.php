<?php $data_back = json_decode(file_get_contents('php://input'));
 
// set json string to php variables
$userName = $data_back->{"phone"};
$password = $data_back->{"password"};

if ( $userName == "1" && $password == "2") {
  $data = array(
  "statuscode" => 200,
  "message" => "Login access granted",
  "payload" => 
    array(
      "udid" => "dab3749897e1d07b",
      "phone" => "8368099354",
      "appversion" => "4",
      "isactive" => true,
      "channel" => "c1",
      "supported_versions" => "3,4,100",
      "appUpdateUrl" => "www.google.com",
      
  "channels" => array(
    array(
      "name" => "c1",
      "value" => " T20",
      "_id" => "590f66f62eb012b215831016"
    ),
    array(
      "name" => "c2",
      "value" => "South Africa vs Bangladesh ",
      "_id" => "590f67002eb012b215831017"
    ),
    array(
      "name" => "C3",
      "value" => "EMPTY",
      "_id" => "591096306758170a19f812ef"
    ),
    array(
      "name" => "C4",
      "value" => "EMPTY",
      "_id" => "5910964d6758170a19f812f0"
    
  )))
);
    
    // will encode to JSON array: ["a","b","c"]
    // accessed as example in JavaScript like: result[1] (returns "b")
} else {if ( $userName == "1" && $password == "3") {
  $data = array(
  "statuscode" => 200,
  "message" => "Login access granted",
  "payload" => 
    array(
      "udid" => "dab3749897e1d07b",
      "phone" => "8368099354",
      "appversion" => "4",
      "isactive" => true,
      "channel" => "c1",
      "supported_versions" => "3,4,100",
      "appUpdateUrl" => "www.google.com",
      
  "channels" => array(
    array(
      "name" => "c1",
      "value" => " T20",
      "_id" => "590f66f62eb012b215831016"
    ),
    array(
      "name" => "c2",
      "value" => "South Africa vs Bangladesh ",
      "_id" => "590f67002eb012b215831017"
    ),
    array(
      "name" => "C3",
      "value" => "EMPTY",
      "_id" => "591096306758170a19f812ef"
    ),
    array(
      "name" => "C4",
      "value" => "EMPTY",
      "_id" => "5910964d6758170a19f812f0"
    
  )))
);
    
    // will encode to JSON array: ["a","b","c"]
    // accessed as example in JavaScript like: result[1] (returns "b")
}} else {
    $data = array(
  "statuscode" => 300,
  "message" => "Login Failed"
);
    
  
    //{"statuscode":200,"message":"Login access granted","payload":{"udid":"dab3749897e1d07b","phone":"8368099354","appversion":"4","isactive":true,"channel":"c1","supported_versions":"3,4,100","appUpdateUrl":"www.google.com","channels":[{"name":"c1","value":" T20","_id":"590f66f62eb012b215831016"},{"name":"c2","value":"South Africa vs Bangladesh ","_id":"590f67002eb012b215831017"},{"name":"C3","value":"EMPTY","_id":"591096306758170a19f812ef"},{"name":"C4","value":"EMPTY","_id":"5910964d6758170a19f812f0"}]}}
}

header('Content-type: application/json');
echo json_encode( $data );
?>