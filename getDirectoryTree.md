# getDirectoryTree #

This method returns the complete tree of files and directories in `$folder` from the version `$version` of the repository.
  * @param string  $folder Folder to get tree
  * @param integer $version Repository version, -1 means current
  * @param boolean $recursive Whether to get the tree recursively, or just the specified directory/file.
  * @return array List of files and directories.

**Note:** The first result returned in the array is intentionally the directory you are accessing.

## Usage ##
```
getDirectoryTree($folder, $version, $recursive);
```

## Example ##
```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$directory_tree = $phpsvnclient->getDirectoryTree('/trunk/');

echo "<pre>\n";
print_r($directory_tree);
echo "</pre>\n";
```