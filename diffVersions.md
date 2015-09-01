# diffVersions #

Function to view the changes between revisions of the specified object.
  * @param type $path The path to the object (file or directory).
  * @param type $revFrom Initial revision.
  * @param type $revTo The final revision.
  * @return array List of files.

## Usage ##
```
diffVersions($path, $revFrom, $revTo);
```

## Examples ##
Here follows some code examples using the `diffVersions` function.

### Latest from directory ###
Prints through echo diff between 42 and 55 revision numbers for the  `/trunk/` directory.

```
require_once("phpsvnclient.php");

$phpsvnclient = new phpsvnclient("http://ihtika.googlecode.com/svn/");
$phpsvnclient->diffVersions("trunk/", "42", "55");
```