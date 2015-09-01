# phpsvnclient #

Once the phpsvnclient class has been installed, it needs to be included within your scripts (`require` or `require_once` is preferred due to the way it produces a fatal error if the path is incorrect or the file is not found.).

```
// Absolute or relative path to phpsvnclient.php
require ('phpsvnclient/phpsvnclient.php);
```

To create an instance of the phpsvnclient class, a new object must be created with parameters and assigned to a variable.

  * @param string  `$url` Base URL of SVN server
  * @param string  `$user` Users SVN log in name (optional)
  * @param string  `$pass` Users SVN password (optional)

```
// Assign the phpsvnclient object to $phpsvnclient
$phpsvnclient = new phpsvnclient($url,$user,$password);
```

## Example ##

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once('phpsvnclient/phpsvnclient.php');
$phpsvnclient = new phpsvnclient($url);

// Lets get an array of the contents within /trunk/
$files_now = $phpsvnclient->getDirectoryFiles('/trunk/');

echo "<pre>\n";
print_r($files_now);
echo "</pre>\n";
```