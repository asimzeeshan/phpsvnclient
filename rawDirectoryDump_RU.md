# rawDirectoryDump #

Этот метод возвращает дамп всех XML данных, представленных в виде массива, принятых от SVN репозитория для папки $folder в репозитории с версией $version.
  * @param string  $folder Папка в репозитории
  * @param integer $version Версия репозитория, -1 означает HEAD версию, т.е. текущую версию репозитория
  * @return array

## Испорльзование ##
```
rawDirectoryDump($folder, $version);
```

## Пример ##
Ниже продемонстрирован пример использования функции `rawDirectoryDump`.

### Дамп данных для текущей версии репозитория ###
Возвращает XML дамп данных, полученных от SVN репозитория для папки `/trunk/` текущей версии репозитория.

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$raw_dump = $phpsvnclient->rawDirectoryDump('/trunk/');

echo "<pre>\n";
print_r($raw_dump);
echo "</pre>\n";
```