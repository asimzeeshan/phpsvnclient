# setRepository #

This method is used to set the base URL of the SVN repository.

  * @param string $url base URL of the project.

**Note:** This function is depreciated, use the method described in [phpsvnclient](phpsvnclient.md) instead.

## Usage ##
```
setRepository($url);
```

## Example ##
```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient();

$phpsvnclient->setRepository($url);
```