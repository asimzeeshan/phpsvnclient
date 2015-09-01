# getDirectoryFiles #

This method returns all the files in `$folder` from the version `$version` of the repository.
  * @param string  `$folder` Folder to get files
  * @param integer `$version` Repository version, -1 means actual
  * @return array List of files.

**Note:** The first result returned in the array is intentionally the directory you are accessing.

## Usage ##
```
getDirectoryFiles($folder, $version);
```

## Examples ##
Here follows some code examples using the `getDirectoryFiles` function.

### Latest from directory ###
Get Files from `/trunk/` directory from the latest repository version.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$files_now = $phpsvnclient->getDirectoryFiles('/trunk/');

echo "<pre>\n";
print_r($files_now);
echo "</pre>\n";
```

#### Expected results ####

```
    [0] => Array
        (
            [type] => directory
            [last-mod] => Sat, 14 Jun 2008 03:58:49 GMT
            [path] => trunk
            [status] => HTTP/1.1 200 OK
        )

    [1] => Array
        (
            [type] => file
            [last-mod] => Sat, 14 Jun 2008 03:00:23 GMT
            [path] => trunk/test.html
            [status] => HTTP/1.1 200 OK
        )

    [2] => Array
        (
            [type] => directory
            [last-mod] => Sat, 14 Jun 2008 02:56:27 GMT
            [path] => trunk/includes
            [status] => HTTP/1.1 200 OK
        )

    [3] => Array
        (
            [type] => file
            [last-mod] => Sat, 14 Jun 2008 03:04:51 GMT
            [path] => trunk/startup.php
            [status] => HTTP/1.1 200 OK
        )
```