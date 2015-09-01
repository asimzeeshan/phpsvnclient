# rawDirectoryDump #

This method returns a dump of all the XML data received from SVN for `$folder` from the version `$version` of the repository as an array.
  * @param string  $folder Folder to get data
  * @param integer $version Repository version, -1 means actual
  * @return array SVN data dump.

## Usage ##
```
rawDirectoryDump($folder, $version);
```

## Examples ##
Here follows some code examples using the `rawDirectoryDump` function.

### Latest from directory ###
Get a dump of SVN data received from `/trunk/` directory in the latest repository version.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$raw_dump = $phpsvnclient->rawDirectoryDump('/trunk/');

echo "<pre>\n";
print_r($raw_dump);
echo "</pre>\n";
```