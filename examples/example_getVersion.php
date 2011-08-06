<?php

ini_set('max_execution_time', 777);
ignore_user_abort(true);
@set_time_limit(0);

$url = 'http://myprivatesite.googlecode.com/svn/';

require_once("../phpsvnclient.php");

$svn = new phpsvnclient();
$svn->setRepository($url);
$ver = $svn->getVersion();
?>