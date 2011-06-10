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

//$url = 'http://myprivatesite.googlecode.com/svn/';
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

//delete('../dev');
//$phpsvnclient->checkOut('branches/TestVersion', '../dev');
if (!file_exists("../dev")) {
    $phpsvnclient->checkOut('branches/khartn', '../dev');
} else {
    $a = $phpsvnclient->getRepositoryLogs('branches/khartn');
    echo "\r\n";
	print_r($a);
}
?>