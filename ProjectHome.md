# Introduction #

This PHP class can be used to retrieve files from an SVN repository in pure PHP,
thus without using separate programs or the need to have SVN support within PHP.


---

## Documentation ##

| **Language** | **Version** | **Online HTML** | **Download PDF** |
|:-------------|:------------|:----------------|:-----------------|
| English      | NA          | [read](http://code.google.com/p/phpsvnclient/w/list?q=label:Language-EN) | NA               |
| На русском   | NA          | [read](http://code.google.com/p/phpsvnclient/w/list?q=label:Language-RU) | NA               |


## Details ##

It accesses a given remove SVN repository using the WebDAV protocol and perform
several types of operations:

  * List all files in a given SVN repository directory
  * Retrieve a given revision of a file
  * Retrieve the log of changes made in a repository or in a given file between two revisions
  * Get the repository latest revision


---


## Installation ##

Stable versions will be available as a zip or tarball within the downloads
section and from SVN within the tags directory.

Testing versions will be available from SVN within the trunk directory.


---


## Documentation ##

Documentation can be viewed online or from SVN within the wiki directory.

### Getting Started ###
  * [phpsvnclient](phpsvnclient.md)

### Function Reference ###
| _English_ | _[Function Reference](http://code.google.com/p/phpsvnclient/w/list?can=2&q=label%3ALanguage-EN+label%3AFunction-Reference)._ |
|:----------|:-----------------------------------------------------------------------------------------------------------------------------|

  * [checkOut](checkOut.md)
  * [getDirectoryFiles](getDirectoryFiles.md)
  * [getFile](getFile.md)
  * [getFileLogs](getFileLogs.md)
  * [getRepositoryLogs](getRepositoryLogs.md)
  * [getVersion](getVersion.md)
  * [rawDirectoryDump](rawDirectoryDump.md)
  * [getDirectoryTree](getDirectoryTree.md)
  * [createOrUpdateWorkingCopy](createOrUpdateWorkingCopy.md)
  * [diffVersions](diffVersions.md)
  * [getFileSize](getFileSize.md)
  * [set\_job\_for\_exec\_after\_completition](set_job_for_exec_after_completition.md)

#### Depreciated Functions ####
  * [setAuth](setAuth.md)
  * [setRepository](setRepository.md)

---

<table>
<tr>
<td>
<wiki:gadget url="http://www.ohloh.net/p/14967/widgets/project_languages.xml" height="220" width="320" border="1" /><br>
</td>
<td>
<wiki:gadget url="http://www.ohloh.net/p/14967/widgets/project_basic_stats.xml" height="220" border="1"/><br>
</td>
</tr>
</table>