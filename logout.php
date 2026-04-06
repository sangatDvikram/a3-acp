<?php
require_once "inc/config.php";
require_once "inc/secondary_functions.php";


//odbc_exec($con,"update account set `ckey`= '', `ctime`= '' where c_id='$_SESSION[user_id]' OR  c_id = '$_COOKIE[user_id]'");
odbc_exec($con,"UPDATE account SET online = 0 WHERE c_id='{$_SESSION['username']}'");

/************ Delete the sessions****************/
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['grade']);
unset($_SESSION['HTTP_USER_AGENT']);
unset($_SESSION['Player']);
session_unset();
session_destroy(); 

/* Delete the cookies*******************/
setcookie("user_id", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");
setcookie("user_name", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");
setcookie("user_key", '', time()-60*60*24*'COOKIE_TIME_OUT', "/");
// Four steps to closing a session
		// (i.e. logging out)

	
		// 2. Unset all the session variables
		$_SESSION = array();
		
		// 3. Destroy the session cookie
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		
		// 4. Destroy the session
		session_destroy();

header("Location: http://$_SERVER[SERVER_NAME]/Logout/".md5(GenKey())."/");
?> 