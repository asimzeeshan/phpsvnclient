# getFile #

Этот метод возвращает содержимое `$file` из версии `$version` из репозитория.
  * @param string  $file Путь к файлу
  * @param integer $version Версия файла в репозитории
  * @return string Содержимое файла

## Использование ##
```
getFile($file, $version);
```

## Пример ##
Получить содержимое файла из `/trunk/` директории из самой свежей версии репозитория.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$file_content = $phpsvnclient->getFile('trunk/phpsvnclient.php');
```