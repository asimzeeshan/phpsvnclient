<?php

ini_set('max_execution_time', 300);

function delete($arg) {
    $d = opendir($arg);
    while ($f = readdir($d)) {
	if ($f != "." && $f != "..") {
	    if (is_dir($arg . "/" . $f))
		delete($arg . "/" . $f);
	    else
		unlink($arg . "/" . $f);
	}
    }
    closedir($d);
    rmdir($arg);
}

$url = 'http://myprivatesite.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

delete('../dev');

print_r($phpsvnclient->getRepositoryLogs());
//$phpsvnclient->checkOut('branches/TestVersion', '../dev');
?>