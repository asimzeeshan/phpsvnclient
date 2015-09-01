# checkOut #

Этот метоид использует [getDirectoryTree](getDirectoryTree.md) для получения данных о директории в самой свежей версии и сохраняет её иерархию в $outPath.
Переменная $folder предназначена для указания пути к папке в репозитории, а переменная $outPath указывает, где разместить рабочую копию репозитория.

  * @param string $folder Путь к папке в репозитории.
  * @param integer $outPath Local Где разместить рабочую копию репозитория.
  * @return void Ничего не возвращает.

# Использование #

```
checkOut($svnDir, $localDir);
```

# Пример #
Скопировать содержимое папки `trunk` в папку `/tmp` (папка `/tmp` будет предварительно удалена и заново создана для очистки).

```
$url = 'http://phpsvnclient.googlecode.com/svn/';

require_once("phpsvnclient.php");
$phpsvnclient = new phpsvnclient($url);

$phpsvnclient->checkOut('trunk', '/tmp');
```