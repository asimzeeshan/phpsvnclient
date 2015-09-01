# getVersion #

Returns the repository version.
  * @return integer Repository version
  * @access public

## Usage ##
```
getVersion();
```

## Examples ##
Here follows some code examples using the `getVersion` function.

### Latest from directory ###
Returns repository's revision number.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$svn = new phpsvnclient();
$svn->setRepository($url);
$ver = $svn->getVersion();
```