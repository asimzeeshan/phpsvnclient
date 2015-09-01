# getRepositoryLogs #

Get repository change logs between version $vini and $vend.
  * @param integer $vini Initial Version
  * @param integer $vend End Version
  * @return Array Respository Logs

## Usage ##
```
getFileLogs($path, $vini, $vend);
```

## Examples ##
Here follows some code examples using the `getFileLogs` function.

### Latest from directory ###
Prints trunk/src/com/google/code/ihtika/IhtikaClient/MainThread.java file's logs between revision number 0 and 100.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$svn = new phpsvnclient();
$svn->setRepository($url);
echo "<pre>\n";
print_r($svn->getFileLogs("trunk/src/com/google/code/ihtika/IhtikaClient/MainThread.java",0,100));
echo "</pre>\n";
```