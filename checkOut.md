# checkOut #

This method uses [getDirectoryTree](getDirectoryTree.md) to retrieve the specified $folder from the latest version, and save its hierarchy to $outPath.  The $folder prefix is not carried over to the local filesystem; its contents will appear directly in $outPath.

  * @param string $folder Defaults to disk root
  * @param string $outPath Defaults to current folder (.)
  * @param boolean $checkFiles Whether it is necessary to check the received files in the sizes. Can be useful in case often files are accepted with an error.
  * @return void This function doesn't return anything.

# Usage #

```
checkOut($svnDir, $localDir, $checkFiles);
```

# Example #
Copy the contents of the `trunk` directory to `/tmp` (Linux directory where files eventually get cleaned out) with file checking.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$phpsvnclient->checkOut('trunk', '/tmp', true);
```