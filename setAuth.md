# setAuth #

This method is for user authentication settings
> for SVN access using a user name and password.

  * @param string $user Username
  * @param string $pass Password

**Note:** This function is depreciated, use the method described in [phpsvnclient](phpsvnclient.md) instead.

## Usage ##
```
setAuth($user,$pass);
```

## Example ##
```
$user = 'myUserName';
$pass = 'myPassword';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient();

$phpsvnclient->setAuth($user,$pass);
```