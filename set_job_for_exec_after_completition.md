# set\_job\_for\_exec\_after\_completition #

Function to specify a script that should be executed
after the checkout or update a local repository.
  * @param type $path\_to\_file - Path to file (script) for execution

## Usage ##
```
set_job_for_exec_after_completition($path_to_file);
```

## Examples ##
Here follows some code examples using the `set_job_for_exec_after_completition` function.

### Latest from directory ###
Specify a script that should be executed
after the checkout or update a local repository.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$svn = new phpsvnclient();
$svn->set_job_for_exec_after_completition($path_to_file);
****************************
```