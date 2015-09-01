# createOrUpdateWorkingCopy #

Function to easily create and update a working copy of the repository.
  * @param type $folder Folder in remote repository
  * @param type $outPath Folder for storing files
  * @param boolean $checkFiles Whether it is necessary to check the received files in the sizes. Can be useful in case often files are accepted with an error.

## Usage ##
```
 public function createOrUpdateWorkingCopy($folder = '/', $outPath = '.', $checkFiles = false);
```

## Examples ##
Here follows some code examples using the `createOrUpdateWorkingCopy` function.

### Latest from directory ###
Get Files from `/trunk/` directory from the latest repository version to the '/CHECKOUT' directory and checks the received files in the sizes.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$phpsvnclient->createOrUpdateWorkingCopy('trunk/', '/CHECKOUT', true);
```