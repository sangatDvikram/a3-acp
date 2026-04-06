<?php
    function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub="";
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes separately and for good reason.
        if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif (preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif (preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif (preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif (preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif (preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // Finally get the correct version number.
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // See how many we have.
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // Check if we have a number.
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
	function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function geoCheckIP($ip)
 
{
 
//check, if the provided ip is valid
 
if(!filter_var($ip, FILTER_VALIDATE_IP))
 
{
 
throw new InvalidArgumentException("IP is not valid");
 
}
 
//contact ip-server
 
$response=@file_get_contents('http://www.netip.de/search?query='.$ip);
 
if (empty($response))
 
{
 
throw new InvalidArgumentException("Error contacting Geo-IP-Server");
 
}
 
//Array containing all regex-patterns necessary to extract ip-geoinfo from page
 
$patterns=array();
 
$patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
 
$patterns["country"] = '#Country: (.*?)&nbsp;#i';
 
$patterns["state"] = '#State/Region: (.*?)<br#i';
 
$patterns["town"] = '#City: (.*?)<br#i';
 
//Array where results will be stored
 
$ipInfo=array();
 

 
//check response from ipserver for above patterns
 
foreach ($patterns as $key => $pattern)
 
{
 
//store the result in array
 
$ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
 
}
/*I've included the substr function for Country to exclude the abbreviation (UK, US, etc..)
To use the country abbreviation, simply modify the substr statement to:
substr($ipInfo["country"], 0, 3)
*/
$ipdata = $ipInfo["town"]. ", ".$ipInfo["state"].", ".substr($ipInfo["country"], 4);
 
return $ipdata;
 
}     
//$json =file_get_contents("http://freegeoip.net/json/".getRealIpAddr());


$statment="SELECT count(distinct(ip)) as Count,type From sessions group by type";

$mysql->query($statment);
$mysql->execute();
$rows=$mysql->resultSet();

$count='';
foreach ($rows as $value) {
    $count.=" $value->type : $value->Count &#124;";
}
$count=rtrim($count,"&#124;");



//$country=file_get_contents('http://geoiplookup.net/geoapi.php?output=json&ipaddress='.getRealIpAddr());
//list ($_country) = explode ("\n", $country);
//$obj = json_decode($json);
 //$_country = $obj->{'city'}.",".$obj->{'region_name'}.",".$obj->{'country_name'}."(".$obj->{'country_code'}.")";

$_country=$count;

?>