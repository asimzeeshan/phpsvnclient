<?php

ini_set('max_execution_time', 777);
ignore_user_abort(true);
@set_time_limit(0);

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient("");

$phpsvnclient->diffVersions("http://ihtika.googlecode.com/svn/", 43, 55);
?>