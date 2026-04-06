<?php
$ping= exec("ping -n 1 $_SERVER[REMOTE_ADDR]");
$exp=explode (",", $ping);
$pingnew=explode ("=", $exp[2]);
echo $pingnew[1];
?>