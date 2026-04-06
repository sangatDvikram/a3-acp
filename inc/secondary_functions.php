<?php
include_once 'config.php';
include 'pdoclass.php';
ini_set( "display_errors", 0);
function antisql($sql) {
    $check = $sql;
    $sql = str_replace("'","",$sql);

    $sql = preg_replace("/[^A-Za-z0-9\s\s+\/\:\.\%\,\@\_\?\-\!\&\;\(\)\#\+\*\=_$]/","",$sql);

//   $sql = trim($sql);
    $sql = strip_tags($sql);
    $sql = stripslashes($sql);
    $sql = addslashes($sql);
    $thisuser='Not loggedin';
    if(isset($_SESSION['username'])){
        $thisuser=$_SESSION['username'];
    }
    if( $check != $sql )
    {
        $pageURL = 'http';
        $pageURL .= "://";
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
        @mkdir("userlogs/".date("Y")."/".date("F")."",0755, true);
        $logf = fopen("userlogs/".date("Y")."/".date("F")."/".date("jS")."-".date("F")."-sqlinjectionlog.txt", "a+");
        fprintf($logf, "Date: %s IP: %s User : %s Code: %s, Fixed: %s, Link: %s\r\n", date("d-m-Y h:i:s A"), $_SERVER['REMOTE_ADDR'],$thisuser, $check, $sql, $pageURL );
        fclose($logf);
    }
    return $sql;
}
function truncate ($string) {

    $length = ceil (strlen($string)/2);

    $replacement = str_repeat("#",$length);


    $position = $length-2;

// The final string
    return substr_replace($string, $replacement, $position, $length);

}

function loggedin()
{
    if($_SESSION['username'] == "")
    {
        return 0;
    } else { return 1; }
}

/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
 ********************************************************/
function page_protect() {
    if (!session_id()) session_start();;

    global $db;

    /* Secure against Session Hijacking by checking user agent */
    if (isset($_SESSION['HTTP_USER_AGENT']))
    {
        if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
        {
            logout();
            exit;
        }
    }

// before we allow sessions, we need to check authentication key - ckey and ctime stored in database

    /* If session not set, check for cookies set by Remember me */
    if (!isset($_SESSION['c_id']) && !isset($_SESSION['username']) )
    {
        if(isset($_COOKIE['c_id']) && isset($_COOKIE['userkey'])){
            /* we double check cookie expiry time against stored in database */

            $cookie_user_id  = antisql($_COOKIE['c_id']);
            $rs_ctime = odbc_exec($con,"SELECT ckey,ctime FROM account WHERE c_id = '$cookie_user_id'");
            $ckey = odbc_result($rs_time,"ckey");
            $ctime = odbc_result($rs_time,"ctime");
            // coookie expiry
            if( (time() - $ctime) > 60*60*24*COOKIE_TIME_OUT) {

                logout();
            }
            /* Security check with untrusted cookies - dont trust value stored in cookie.
            /* We also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/

            if( !empty($ckey) && is_numeric($_COOKIE['c_id']) && isUserID($_COOKIE['username']) && $_COOKIE['userkey'] == sha1($ckey)  ) {
                session_regenerate_id(); //against session fixation attacks.

                $_SESSION['c_id'] = $_COOKIE['c_id'];
                $_SESSION['username'] = $_COOKIE['username'];
                /* query user level from database instead of storing in cookies */
                $uquery = odbc_exec($con,"SELECT acc_status FROM account WHERE c_id = '$_SESSION[username]'");
                $user_level = odbc_result($uquery,"acc_status");

                $_SESSION['grade'] = $user_level;
                $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

            } else {
                logout();
            }

        } else {
            header("Location: login.php");
            exit();
        }
    }
}

function uploadfile($file,$path)
{
    $filename = strtolower($_FILES['img']['name']);
    $split = explode(".",$filename);
    $ext = end($split);
    $fname = basename($filename,".".$ext);
    $filename = $fname."_".trim($_SESSION['username']).".".$ext;
    if(file_exists($path.$filename))
    {
        for($i = 1; $i <= 9999; $i++)
        {
            $filename = $fname."_".trim($_SESSION['username'])."_".$i.".".$ext;
            if(!file_exists($path.$filename)){ break; }
        }
    }
    $target3 = $path . $filename;
    $backlist = array('php', 'php3', 'php4', 'phtml', 'exe', 'bat', 'asp', 'aspx', 'cpp', 'h', 'cs');

    if(in_array(end(explode('.', $filename)), $backlist))
    {
        $error=1;
        die("Error : Invalid file type.");
    }

    $check = move_uploaded_file($_FILES['img']['tmp_name'], $target3);
    return($target3);
}

/* Custom Encoded URL */
function EncodeURL($url)
{
    $new = strtolower(ereg_replace(' ','_',$url));
    return($new);
}

/* Decode Custom Encoded URL */
function DecodeURL($url)
{
    $new = ucwords(ereg_replace('_',' ',$url));
    return($new);
}

function ChopStr($str, $len)
{
    if (strlen($str) < $len)
        return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
        $str = substr($str,0,$spc_pos);

    return $str . "...";
}

/* Check if the E-mail is valid */
function isEmail($email){
    return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

/* Check if UserID is valid */
function isUserID($username)
{
    if (preg_match('/^[a-z\d_]{6,15}$/i', $username)) {
        return true;
    } else {
        return false;
    }
}

/* Check if char is online */
function isonline($chart)
{
    global $con;
    $char=$chart;
    $sql="SELECT * FROM charac0 WHERE c_id = '$char' and c_sheadera='$_SESSION[username]'";
    $rss=odbc_exec($con,$sql);
    $rs=odbc_fetch_array($rss);
    if($rs['pnline'] == 1) {return true;break;}
    else{
        if( odbc_num_rows( $rss ) == 1)
        {return false;break;}
        else
        {return true;break;}
    }
}
function is_online($chart)
{
    global $con;
    $char=$chart;
    $onlineErr=array();
    $sql="SELECT * FROM charac0 WHERE c_sheadera = '$char'";
    $rss=odbc_exec($con,$sql);
    while($rs=odbc_fetch_array($rss)){
        if($rs['pnline'] == 1) {$onlineErr[]='1';}
    }

    if(empty($onlineErr)){
        return false;
    }else {
        return true;
    }
}
/* Check if URL is valid */
function isURL($url)
{
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
        return true;
    } else {
        return false;
    }
}

/* Check Password for length and match */
function checkPwd($x,$y)
{
    if(empty($x) || empty($y) ) { return false; }
    if (strlen($x) < 4 || strlen($y) < 4) { return false; }

    if (strcmp($x,$y) != 0) {
        return false;
    }
    return true;
}

/* Generate a random password */
function GenPwd($length = 7)
{
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwyzBCDFGHJKMNPQRSTVWYZ"; //no vowels

    $i = 0;

    while ($i < $length) {


        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);


        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }

    }

    return $password;

}

/* Generate activation keys */
function GenKey($length = 7)
{
    $length=rand(5,10);
    $password = "";
    $possible = "ABCDEFGHIJKLMNOPQRSTUVWYZ0123456789abcdefghijkmnopqrstuvwyz";

    $i = 0;

    while ($i < $length) {


        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);


        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }

    }

    return $password;

}

/* Generate evercookies */
function aultimat($lengtho = 15)
{
    $passwordo = "";
    $possibleo = "0123456789abcdefghijkmnopqrstuvwxyz";

    $io = 0;

    while ($io < $lengtho) {


        $charo = substr($possibleo, mt_rand(0, strlen($possibleo)-1), 1);


        if (!strstr($passwordo, $charo)) {
            $passwordo .= $charo;
            $io++;
        }

    }

    return $passwordo;

}

//string encryption
function THashAndCrypt($input)
{
    return str_rot13(base64_encode(hash('sha512', $input)));
}

function TdeCrypt($input)
{
    return str_rot13(base64_decode($input));
}


//get current URL
function curPageURL() {
    $pageURL = 'http';
    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
//get current page
function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
//chk wheater p;ayer loged in or not
function logged_in() {
    return isset($_SESSION['username']);
}

function confirm_logged_in() {
    if (!logged_in()) {
        redirect_to("login.php");
    }
}
/* Logout  User */
function logout()
{
    global $db;

    if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
        odbc_exec($con,"update account set `ckey`= '',`online`=`0`, `ctime`= '' where c_id='$_SESSION[user_id]' OR  c_id = '$_COOKIE[user_id]'");

    }

    /************ Delete the sessions****************/
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();

    /* Delete the cookies*******************/
    setcookie("user_id", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");
    setcookie("user_name", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");
    setcookie("user_key", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");

    header("Location: login.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null)
{
    if ($salt === null)     {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else     {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

/* Check if user is admin */
function checkAdmin() {

    if($_SESSION['user_level'] == ADMIN_LEVEL) {
        return 1;
    } else { return 0 ;
    }

}

/* Get Item Type */
function getitype($code)
{
    switch($code)
    {
        case 3114 : return("Head");
            break;
        case 4138 : return("Body");
            break;
        case 6186 : return("Gloves");
            break;
        case 5162 : return("Pants");
            break;
        case 7210 : return("Boots");
            break;
        case 490 : return("Sheild/Extra Hand Weapon");
            break;
        case 1578 : return("Weapon");
            break;
        case 2730 : return("Mage Weapon");
            break;
        case "Skill Scroll" : return("Skill Scroll");
            break;
        case "Necklace" : return("Necklace");
            break;
        case "Ring" : return("Ring");
            break;
        case "RB" : return("RB Item");
            break;
        case "Crafting" : return("Crafting Item");
            break;
        case "Extra" : return("Extra");
            break;
        default : return("Item");
    }
}

function getclass($code)
{
    switch($code)
    {
        case "Warrior" : return(0);
            break;
        case "Holy Knight" : return(1);
            break;
        case "Mage" : return(2);
            break;
        case "Archer" : return(3);
            break;
        default : return(4);
        break;
    }
}

function log_action($user,$char,$log,$con)
{
    $q = "INSERT INTO logs (username,character,time,userlog,notified) VALUES ('$user','$char',GETDATE(),'$log',0)";
    odbc_exec($con,$q);
}

function email_action($user,$subject,$message,$con)
{
    require_once('/class.phpmailer.php');
    $mail = new PHPMailer();
    $result = odbc_exec($con,"SELECT c_id,c_headerb FROM account WHERE c_id = '$user'");
    $num = odbc_num_rows($result);
    $mail             = new PHPMailer();
    $body             = $message;
    $body             = $body;
    $mail->IsSMTP();
    $mail->Host       = "crx.websitewelcome.com";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "crx.websitewelcome.com";
    $mail->Port       = 465;
    $mail->Username   = "support@a3ultimate.com";  // GMAIL username
    $mail->Password   = "Gjmptw@789#";            // GMAIL password
	$mail->SetFrom('support@a3ultimate.com', 'Team Ultimate');
	$mail->AddReplyTo("support@a3ultimate.com","Team Ultimate");

    $mail->Subject    = $subject;

    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->MsgHTML($body);

    $address = odbc_result($result,"c_headerb");
    $mail->AddAddress($address);
    if(!$mail->Send()) {
        $err[] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $err[] = "Message sent!";
    }

}function email_action1($user,$subject,$message,$con)
{
    require_once('phpmailer/class.phpmailer.php');
    $mail             = new PHPMailer();
    $body             = $message;
    $mail->IsSMTP();
    $mail->Host       = "crx.websitewelcome.com";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "crx.websitewelcome.com";
    $mail->Port       = 465;
    $mail->Username   = "support@a3ultimate.com";  // GMAIL username
    $mail->Password   = "Gjmptw@789#";            // GMAIL password
    $mail->SetFrom('notify@a3ultimate.com', 'Team Ultimate');
    $mail->AddReplyTo("support@a3ultimate.com","Team Ultimate");

    $mail->Subject    = $subject;

    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->MsgHTML($body);

    $address = $user;
    $mail->AddAddress($address);
    if(!$mail->Send()) {
        $err[] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $err[] = "Message sent!";
    }

}
function email_action_single($user,$subject,$message,$con)
{
    require_once('phpmailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $result = odbc_exec($con,"SELECT c_id,c_headerb FROM account WHERE c_id = '$user'");
    $num = odbc_num_rows($result);
    $mail             = new PHPMailer();
    $body             =$message;

    $mail->IsSMTP();
    $mail->Host       = "crx.websitewelcome.com";
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host       = "crx.websitewelcome.com";
    $mail->Port       = 465;
    $mail->Username   = "support@a3ultimate.com";  // GMAIL username
    $mail->Password   = "Gjmptw@789#";            // GMAIL password
    $mail->SetFrom('support@a3ultimate.com', 'Team Ultimate');
$mail->AddReplyTo("support@a3ultimate.com","Team Ultimate");
    $mail->Subject    = $subject;

    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->MsgHTML($body);

    $address = $user;
    $mail->AddAddress($address);
    if(!$mail->Send()) {
        $err[] = "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $err[] = "Message sent!";
    }

}

function rewardref($char,$user,$con)
{
    $query1 = odbc_exec($con,"SELECT word FROM AccountInfo WHERE account = '$user'");
    $rchar = odbc_result($query1,"word");
    $query2 = odbc_exec($con,"SELECT c_sheadera FROM charac0 WHERE c_id = '$rchar'");
    $ruser = odbc_result($query2,"c_sheadera");
    $query3 = odbc_exec($con,"SELECT c_id, coins FROM account WHERE c_id = '$ruser'");
    $coins = odbc_result($query3,"coins");
    $ncoins = $coins + 1000;
    $query4 = odbc_exec($con,"UPDATE account SET coins = '$ncoins' WHERE c_id = '$ruser'");
    if($query4){
        $subject = "A3 Ultimate : 1000 coins credited to your account.";
        $message = "Hello,<br>Your account : <b>".$ruser."</b> has been credited with 1000 coins.<br> These coins were gifted to you because the character <b>".$char."</b> which was referred by you has taken its 10th rebirth!<br>You can use these coins to shop at our awesome E-Shop.<br><a href=\"/ACP/Eshop/\">Click Here</a> to go to our E-Shop. <br>- Team Ultimate";
      //  email_action($ruser,$subject,$message,$con);
        log_action($ruser,$rchar,$message,$con);
    }
}

function str_replace_first($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
function strToHex($string) // This is function to change given string into hex
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
function hexToStr($hex) // This is function to change given hex string back to string
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

function plainoptions($options){

    $i1 = fmod($options, 67108864);
    $j1 = $options - $i1;
    $grey = $j1 / 67108864;

    $i2 = fmod($i1, 1048576);
    $j4 = $i1 - $i2;
    $red = $j4 / 1048576;

    $i3 = fmod($i2, 16384);
    $j5 = $i2 - $i3;
    $blue = $j5 / 16384;

    $i4 = fmod($i3, 32);
    $j6 = fmod($i4, 16);
    $i8 = $i4 - $j6;
    $bless = $i8 / 16;


    if ($bless == '0'){$blessing = 'No';}else{if ($bless == '1'){$blessing = 'Yes';};};

    return array('Blessing'=>$blessing,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Level'=>$j6);

}

function storageboxoptions($options){

    $item = fmod($options, 16384);
    $bb = $options - $item;
    $count = $bb / 16384;
    return array('Item'=>$item,'Count'=>$count);

}

function addmounting($options){

    $mount=fmod($options, 65536);
    $bb = $options - $mount;
    $mcount = $bb / 65536;
    $item = fmod($mount, 32768);
    $bb = $mount - $item;
    $adatt = $bb / 32768;
    $mcount=($mcount*10)."%";
    if ($adatt == '0'){$ad1 = "No";}else{if ($adatt == '1'){$ad1 = "Yes";}}

    return array('Mount'=>$mcount,'Additional'=>$ad1,'Item'=>$item);

}

function invtoption($options,$character){
    global $con;
    global $con2;

    $char=$character;
    $slot=$options*4;
    $newop=($options);
    include('m_body_char.php');
    $sr = explode(";",$INVEN[1]);

    $source = array_values($sr);
    $chunk=array_chunk($source,4);
    $k = array_search($newop,$source); //$k = 1;
    $iteminfo = $sr[$slot];
    $itoptin = $sr[$slot+1];
    $ituniq = $sr[$slot+2];
    $itslot = $sr[$slot+3];
    $all=$iteminfo.";".$itoptin.";".$ituniq;
    $mount=fmod($iteminfo, 65536);
    $bb = $iteminfo - $mount;
    $mcount = $bb / 65536;
    $item = fmod($mount, 32768);
    $bb = $mount - $item;
    $adatt = $bb / 32768;
    $mcount=($mcount*10)."%";
    if ($adatt == '0'){$ad1 = "No";}else{if ($adatt == '1'){$ad1 = "Yes";}}

    $options=plainoptions($itoptin);
    $blessing=$options['Blessing'];
    $blue=$options['Blue'];
    $red=$options['Red'];
    $grey=$options['Grey'];
    $level=$options['Level'];
    $count=0;
    $itemnum1='';
    $itemnam='';
    if($item==17){
        $str=storageboxoptions($itoptin);
        $itemnum1=$str['Item'];
        $count=$str['Count'];
        $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$itemnum1'");
        $prot10 = odbc_fetch_array($prot0);$itemnam = $prot10['itmname'];
    }
    $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$item'");
    $prot10 = odbc_fetch_array($prot0);$it0 = $prot10['itmname'];
    $img = $prot10['image'];
    $typ = $prot10['ittype'];

    return array('Blessing'=>$blessing,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Additional'=>$ad1,'Level'=>$level,'Name'=>$it0,'Count'=>$count,'StorageItem'=>$itemnam,'ItemNumber'=>$item,'Char'=>$char,'Slot'=>$slot,'Alloptions'=>$all,'Mount'=>$mcount,'Image'=>$img,'Type'=>$typ,'scnd'=>$itoptin,'uniq'=>$ituniq,'first'=>$iteminfo,'fslot'=>$itslot);

}
function ItemName($value)
{
    global $con2;
    $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$value'");
    $prot10 = odbc_fetch_array($prot0);return trim(clear($prot10['itmname']),"&nbsp");
}
function stroption($options,$character){
    global $con;
    global $con2;
    $char=$character;
    $slot=$options*4;
    $newop=($options);
    $sqlstring="SELECT m_body FROM ItemStorage0 WHERE c_id = '$char'";
    $rsstring = odbc_exec($con,$sqlstring);
    $sup = odbc_fetch_array($rsstring);
//echo "$charstring <br>";
    $temp=$sup['m_body'];
    $sr = explode(";",$temp);

    $source = array_values($sr);
    $chunk=array_chunk($source,4);
    $k = array_search($newop,$source); //$k = 1;
    $iteminfo = $sr[$slot];
    $itoptin = $sr[$slot+1];
    $ituniq = $sr[$slot+2];
    $itslot = $sr[$slot+3];
    $all=$iteminfo.";".$itoptin.";".$ituniq;
    $mount=fmod($iteminfo, 65536);
    $bb = $iteminfo - $mount;
    $mcount = $bb / 65536;
    $item = fmod($mount, 32768);
    $bb = $mount - $item;
    $adatt = $bb / 32768;
    $mcount=($mcount*10)."%";
    if ($adatt == '0'){$ad1 = "No";}else{if ($adatt == '1'){$ad1 = "Yes";}}

    $options=plainoptions($itoptin);
    $blessing=$options['Blessing'];
    $blue=$options['Blue'];
    $red=$options['Red'];
    $grey=$options['Grey'];
    $level=$options['Level'];
    $count=0;
    $itemnum1='';
    $itemnam='';
    if($item==17){
        $str=storageboxoptions($itoptin);
        $itemnum1=$str['Item'];
        $count=$str['Count'];
        $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$itemnum1'");
        $prot10 = odbc_fetch_array($prot0);$itemnam = $prot10['itmname'];
    }
    $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$item'");
    $prot10 = odbc_fetch_array($prot0);$it0 = $prot10['itmname'];
    $img = $prot10['image'];
    $typ = $prot10['ittype'];

    return array('Blessing'=>$blessing,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Additional'=>$ad1,'Level'=>$level,'Name'=>$it0,'Count'=>$count,'StorageItem'=>$itemnam,'ItemNumber'=>$item,'Char'=>$char,'Slot'=>$slot,'Alloptions'=>$all,'Mount'=>$mcount,'Image'=>$img,'Type'=>$typ,'scnd'=>$itoptin,'uniq'=>$ituniq,'first'=>$iteminfo,'fslot'=>$itslot);

}
function clear($input)
{
    $trans = get_html_translation_table(HTML_ENTITIES);
    $str = $input;
    $input= strtr($str, $trans);
    /*
    $search  = array('<', '>','/','$','%','^','[',']');
    $replace = array('&lt;','&gt;','&#47;','&#36;','&#37;','&#94;','&lt;','&gt;');
    $input = str_replace($search, $replace,$input);*/
    return  stripslashes($input);
}
function clear_smile($input)
{
    $trans = get_html_translation_table(HTML_ENTITIES);
    $str = $input;
    $input= strtr($str, $trans);

    $search  = array(
        ':)',':=)',':-)',
        ':D',':-D',':=D',
        ':d',':-d',':=d',
        ':P',':=P',':-P',
        ':p',':=p',':-p',
        ';(',';-(',';=(',
        '8)','8=)','8-)',
        'B)','B=)','B-)',
        ':o',':=o',':-o',
        ':O',':=O',':-O',
        ':*',':=*',':-*',
        ':S',':-S',':=S',
        ':s',':-s',':=s',
        ':x',':-x',':X',
        ':-X',':#',':-#',
        ':=x',':=X',':=#',
        ':(',':=(',':-(');
    $replace = array("
<img title=':)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0100-smile.gif'>",
        "<img title=':=)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0100-smile.gif'>",
        "<img title=':-)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0100-smile.gif'>",

        "<img title=':D' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",
        "<img title=':-D' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",
        "<img title=':=D' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",

        "<img title=':d' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",
        "<img title=':-d' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",
        "<img title=':=d' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0102-bigsmile.gif'>",

        "<img title=':P' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",
        "<img title=':=P' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",
        "<img title=':-P' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",

        "<img title=':p' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",
        "<img title=':=p' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",
        "<img title=':-p' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0110-tongueout.gif'>",

        "<img title=';(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>",
        "<img title=';-(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>",
        "<img title=';=(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>",

        "<img title='8)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",
        "<img title='8=)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",
        "<img title='8-)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",

        "<img title='B)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",
        "<img title='B=)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",
        "<img title='B-)' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0103-cool.gif'>",

        "<img title=':o' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",
        "<img title=':=o' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",
        "<img title=':-o' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",

        "<img title=':O' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",
        "<img title=':=O' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",
        "<img title=':-O' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0105-wink.gif'>",


        "<img title=':*' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0109-kiss.gif'>",
        "<img title=':=*' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0109-kiss.gif'>",
        "<img title=':-*' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0109-kiss.gif'>",

        "<img title=':S' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",
        "<img title=':-S' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",
        "<img title=':=S' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",

        "<img title=':s' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",
        "<img title=':-s' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",
        "<img title=':=s' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0124-worried.gif'>",

        "<img title=':x' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':-x' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':X' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",

        "<img title=':-X' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':#' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':-#' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",

        "<img title=':=x' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':=X' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",
        "<img title=':=#' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0127-lipssealed.gif'>",

        "<img title=':(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>",
        "<img title=':=(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>",
        "<img title=':-(' src='http://factoryjoe.s3.amazonaws.com/emoticons/emoticon-0101-sadsmile.gif'>");
    $input = str_replace($search, $replace, $input);
    return  stripslashes($input);
}
function wearoption($options,$character){
    global $con;
    global $con2;

    $char=$character;
    $slot=($options-1)*3;
    $newop=($options);
    //initializing string
$sqlstring="SELECT m_body FROM charac0 WHERE c_id = '$char'";
$rsstring = odbc_exec($con,$sqlstring);
$charstring = odbc_result($rsstring,'m_body');
//echo "$charstring <br>";

//explode the string
$temp = explode("\_1",$charstring);

//initialize variable for the string
$EXP = explode("=",$temp[0]);
$SKILL = explode("=",$temp[1]);
$PK = explode("=",$temp[2]);
$RTM = explode("=",$temp[3]);
$SINFO = explode("=",$temp[4]);
$WEAR = explode("=",$temp[5]);
$INVEN = explode("=",$temp[6]);
$PETINV = explode("=",$temp[7]);
$CQUEST = explode("=",$temp[8]);
$WAR = explode("=",$temp[9]);
$SQUEST = explode("=",$temp[10]);
$FAVOR = explode("=",$temp[11]);
$PSKILL = explode("=",$temp[12]);
$SKLSLT = explode("=",$temp[13]);
$CHATOPT = explode("=",$temp[14]);
$TYR = explode("=",$temp[15]);
$SKILLEX = explode("=",$temp[16]);
$SKLSLTEX = explode("=",$temp[17]);
$PETACT = explode("=",$temp[18]);
$LORE = explode("=",$temp[19]);
$LQUEST = explode("=",$temp[20]);
$RESRV0 = explode("=",$temp[21]);
$RESRV1 = explode("=",$temp[22]);
    $sr = explode(";",$WEAR[1]);

    $source = array_values($sr);
    $chunk=array_chunk($source,4);
    $k = array_search($newop,$source); //$k = 1;
    $iteminfo = $sr[$slot];
    $itoptin = $sr[$slot+1];
    $ituniq = $sr[$slot+2];
    $itslot = $slot3;
    $all=$iteminfo.";".$itoptin.";".$ituniq;
    $mount=fmod($iteminfo, 65536);
    $bb = $iteminfo - $mount;
    $mcount = $bb / 65536;
    $item = fmod($mount, 32768);
    $bb = $mount - $item;
    $adatt = $bb / 32768;
    $mcount=($mcount*10)."%";
    if ($adatt == '0'){$ad1 = "No";}else{if ($adatt == '1'){$ad1 = "Yes";}}

    $options=plainoptions($itoptin);
    $blessing=$options['Blessing'];
    $blue=$options['Blue'];
    $red=$options['Red'];
    $grey=$options['Grey'];
    $level=$options['Level'];
    $count=0;
    $itemnum1='';
    $itemnam='';
    if($item==17){
        $str=storageboxoptions($itoptin);
        $itemnum1=$str['Item'];
        $count=$str['Count'];
        $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$itemnum1'");
        $prot10 = odbc_fetch_array($prot0);$itemnam = $prot10['itmname'];
    }
    $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$item'");
    $prot10 = odbc_fetch_array($prot0);$it0 = $prot10['itmname'];
    $img = $prot10['image'];
    $typ = $prot10['ittype'];

    return array('Blessing'=>$blessing,'Blue'=>$blue,'Red'=>$red,'Grey'=>$grey,'Additional'=>$ad1,'Level'=>$level,'Name'=>$it0,'Count'=>$count,'StorageItem'=>$itemnam,'ItemNumber'=>$item,'Char'=>$char,'Slot'=>$slot,'Alloptions'=>$all,'Mount'=>$mcount,'Image'=>$img,'Type'=>$typ,'scnd'=>$itoptin,'uniq'=>$ituniq,'first'=>$iteminfo,'fslot'=>$itslot);

}

function shuedatacalc($shue)
{
    
    
}


function CheckInvent($value,$char)
{
    global $con2;
    global $con;
    $rbquerry = odbc_exec($con2,"SELECT * FROM rbinfo WHERE Rb = '$value'");
    $rbInfo = odbc_fetch_array($rbquerry);
//Character info ------------------------------------------------------------------------------------
    $charquery = odbc_exec($con,"SELECT * FROM charac0 WHERE c_id = '$char' ");
    $charInfo = odbc_fetch_array($charquery);
    $i=0;
    if($rbInfo['Item_req']!='none')
    {
        //This is for 1 item---------------------------------------------------------------------------
        if($rbInfo['Item_req_count']==1){
            include('m_body_char.php');
            $invt = explode(";",$INVEN[1]);
            $info=invtoption(0,$char);
            if($invt1['Name']=='')$invt1['Name']="Empty Slot";
            if($rbInfo['Item_req']==$info['first']){ $i=0; }else{$i++; }
        }
        //This is for 2 items---------------------------------------------------------------------------
        elseif($rbInfo['Item_req_count']==2){
            include('m_body_char.php');
            $invt = explode(";",$INVEN[1]);
            $reqItem=explode(",", $rbInfo['Item_req']);
            $invt1=invtoption(0,$char);
            $invt2=invtoption(1,$char);
            if($reqItem[0]==$invt1['first']&&$reqItem[1]==$invt2['first']){$i=0; }else{$i++;}
        }
    }
    if($i==0){return false;}else{return true;}
}

function itemInfo($value)
{
    global $con2;
    $prot0= odbc_exec($con2,"SELECT * FROM itemlist WHERE code = '$value'");
    $prot10 = odbc_fetch_array($prot0);
    $name=clear($prot10['itmname']);
    $search  = array('&nbsp;',"'", '%20');
    $name = str_replace($search,"", $name);
    $name = rtrim($name);
    return array('Name'=>$name,'Image'=>$prot10['image'],'Code'=>rtrim($value),'Type'=>rtrim($prot10['ittype']),'Class'=>rtrim($prot10['itclass']));

}

function get_filled_inventory($inventory= array()){
    $filledInventory = array();
    $source = array_values($inventory);
    $count = count($source);
    for($i = 3; $i < $count; $i +=4) {
        $filledInventory[] = $source[$i]+1;
    }
    return $filledInventory;
}

function get_empty_inventory($inventory= array()){
    $array2 = array( "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29" ,"30");

    $emptyInvt = array_diff($array2,$inventory);

    $emptyInvt = array_values($emptyInvt);

    return $emptyInvt;
}

function playerInfo($char,$townW=null,$townH=null)
{
    global $con;
    $statement="SELECT c.reset,c.pnline,c.c_id,c.c_sheaderc,a.acc_status,c.rb,c.c_sheaderb,b.Nation,c.d_udate,c.online
            FROM
            account as a,
            CharInfo as b,
            charac0 as c,
            AccountInfo as AI 
            WHERE 
            c.c_sheadera=a.c_id AND 
            c.c_sheadera=AI.account AND
            a.c_id=AI.account AND
            c.c_id='$char'

";
    $charquery = odbc_exec($con,"SELECT c.reset,c.pnline,c.c_id,c.c_sheaderc,a.acc_status,c.rb,c.c_sheaderb,b.Nation,c.d_udate,c.online FROM account as a,charac0 as c, CharInfo as b, AccountInfo as AI WHERE c.c_sheadera=a.c_id AND b.CharName='$char' AND c.c_sheadera=AI.account AND a.c_id=AI.account AND c.c_id='$char'");
    $playerinfo = odbc_fetch_array($charquery);

   /* $AccountQ = odbc_exec($con,"SELECT * FROM account WHERE c_id = '$playerinfo[c_sheadera]' ");
    $accountinfo = odbc_fetch_array($AccountQ);
    $lola = odbc_exec($con, "SELECT * FROM AccountInfo WHERE word='$char'");*/

    $numrow = '';
    $reset = $playerinfo[ "reset"];
    $online = $playerinfo[ "pnline"];
    $name = $playerinfo[ "c_id"];
    $level = $playerinfo[ "c_sheaderc"];
    $grade= $playerinfo[ "acc_status"];
    $rb=$playerinfo["rb"];
    $char_type=$playerinfo['c_sheaderb'];
    $nation=$playerinfo['Nation'];
    $date=$playerinfo['d_udate'];
    $minuts = $playerinfo[ "online"];
    $minuts1 = floor($minuts/60)."hr ".($minuts%60)."Min";
// Deside Class :) 
    $class="";
    if ($char_type == '0')
    {
        $class = "Warrior";
    }
    else
    {
        if ($char_type == '1')
        {
            $class = "Holy Knight";
        }
        else
        {
            if ($char_type == '2')
            {
                $class = "Mage";
            }
            else
            {
                if ($char_type == '3')
                {
                    $class = "Archer";
                }
            }
        }
    }

//Deside Rank
    if ($reset == '3')
    {
        $rank = "Emperor";
        $style='';
    }
    else
    {
        if ($level == '175')
        {
            $rank = "Emperor";
            $style='background:url(/images/backround17.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#088A08;text-shadow: 1px 1px 3px #CCCCCC;zoom:1';
        }
        else
                {
            if ($level > '165')
            {
                $rank = "King";
                $style='background:url(/images/backround18.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#3300FF;text-shadow: 1px 1px 3px #CCCCCC;zoom:1';
            }
            else
            {
                if ($reset == '1')
                {
                    $rank = "Viscount";
                    $style='background:url(/images/backround7.gif) 0 -5px repeat;z-index:6;Padding:2px;color:#FE2E2E;text-shadow: 1px 1px 3px #CCCCCC;zoom:1';
                }
                else
                {
                    if ($reset == null || $reset == '0')
                    {
                        $rank = "Ultimate Soldier";
                        $style='';
                    }
                    else
                    {
                        if ($reset == '-1')
                        {
                            $rank = "Test Character";
                            $style='';
                        }
                    }
                }
            }
        }
    }

    if ($grade=="Admin"||$grade=="GM"||$grade=="Admin1")
    {
        $rank = "Game Master";
        $style='background:url(/images/backround21.gif) -25px -17px repeat;z-index:6;Padding:2px;color:#FF8000;text-shadow: 0.1em 0.1em 0.2em #FE9A2E;zoom:1';
    }



    // Online Status

    if($online == 1)
    {	$status='Online';
        $statusImage= "<img src='/images/status.png' title='Online'>";
    }
    else
    {	$status='Offline';
        $statusImage= "<img src='/images/status-offline.png' title='Offline'>";
    }
    //Nation Status
    $town='';
    if ($nation == '0')
    {
        $town = "Temoz";
    }
    else
    {
        if ($nation == '1')
        {
            $town = "Quanato";
        }
        else
        {
            if ($nation == '2')
            {
                $town = "Town not updated";
            }
            else
            {
                if ($nation == '3')
                {
                    $town = "Hatrel";
                }
            }
        }
    }
    //Town Image
    if ($townW>0&&$townH>0) {
        $townImage="<img src='/images/town$town.png' alt='$town' title='$town' width='$townW' height='$townH'>";
    }
    else
    {
        $townImage="<img src='/images/town$town.png' alt='$town' title='$town'>";
    }

    $styledName="<span style='$style' title='$rank'>$name</span>";


    $info= array('Name' =>$name ,'StyledName'=>$styledName,'Type'=>$class,'Rb'=>$rb,'Reset'=>$reset,'Nation'=>$town,'NationImage'=>$townImage,'login'=>$date,'Rank'=>$rank,'OnlineTime'=>$minuts1,'OnlineStatus'=>$status,'StatusImage'=>$statusImage ,'TypeNum'=>$char_type,'Style'=>$style,'Referred'=>$numrow,'Level'=>$level);
    return $info;
}
function checkReportPKStatus($id)
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
            return  '<a href="#reportModal" class="btn btn-inverse report disabled"  id='.$id.' title="Reported"><i class="icon-ok icon-white" title="Reported"></i></a>';
            
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
function CheckvalidUser()
{
    try
            {
                Global $MysqlConnect,$OdbcConnect;

            $statement="SELECT count(*) as Total FROM charac0  as c where c_sheadera=:c_sheadera and reset='1' ";
            $query=$OdbcConnect->prepare($statement);
            $query->execute(array(':c_sheadera'=>$_SESSION['username']));
            $result=$query->fetch(PDO::FETCH_NAMED);
        
         if($result['Total']>0) 
         {
            return  true;
            
         }
         else
         {
            return  false;
         }

         } catch (PDOException $e)
          {
               die( " Something Went Wrong ");
            }

}
?>