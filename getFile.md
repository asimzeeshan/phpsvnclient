# getFile #

This method returns the contents of `$file` from the version `$version` of the repository.
  * @param string  $file File pathname
  * @param integer $version File Version
  * @return string File content

## Usage ##
```
getFile($file, $version);
```

## Example ##
Get the contents of a file from `/trunk/` directory using the latest repository version.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$file_content = $phpsvnclient->getFile('trunk/phpsvnclient.php');
```