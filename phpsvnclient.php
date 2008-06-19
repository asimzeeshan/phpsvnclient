<?php
/*
***************************************************************************
*   Copyright (C) 2007-2008 by Sixdegrees                                 *
*   cesar@sixdegrees.com.br                                               *
*   "Working with freedom"                                                *
*   http://www.sixdegrees.com.br                                          *
*                                                                         *
*   Modified by Ethan Smith (ethan@3thirty.net), April 2008               *
*      - Added support for non-standard port numbers (rewrote cleanURL)   *
*      - getFileLogs will now include an array of files, if multiple      *
*        have been modified files are                                     *
*      - added setRepository method, to fix mis-spelling of old           *
*        setRespository method                                            *
*      - various bugfixes (out by one error on getFileLogs)               *
*                                                                         *
*   Permission is hereby granted, free of charge, to any person obtaining *
*   a copy of this software and associated documentation files (the       *
*   "Software"), to deal in the Software without restriction, including   *
*   without limitation the rights to use, copy, modify, merge, publish,   *
*   distribute, sublicense, and/or sell copies of the Software, and to    *
*   permit persons to whom the Software is furnished to do so, subject to *
*   the following conditions:                                             *
*                                                                         *
*   The above copyright notice and this permission notice shall be        *
*   included in all copies or substantial portions of the Software.       *
*                                                                         *
*   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,       *
*   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF    *
*   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.*
*   IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR     *
*   OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, *
*   ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR *
*   OTHER DEALINGS IN THE SOFTWARE.                                       *
***************************************************************************
*/
define("PHPSVN_DIR",dirname(__FILE__) );

require(PHPSVN_DIR."/http.php");
require(PHPSVN_DIR."/xml_parser.php"); // to be dropped?
require(PHPSVN_DIR."/definitions.php");
require(PHPSVN_DIR."/xml2Array.php");


/**
 *  PHP SVN CLIENT
 *
 *  This class is a SVN client. It can perform read operations
 *  to a SVN server (over Web-DAV). 
 *  It can get directory files, file contents, logs. All the operaration
 *  could be done for a specific version or for the last version.
 *
 *  @author Cesar D. Rodas <cesar@sixdegrees.com.br>
 *  @license BSD License
 */
class phpsvnclient {
	/**
	 *  SVN Repository URL
	 *
	 *  @var string
	 *  @access private
	 */
	private $_url;
	/**
	 *  Cache, for don't request the same thing in a
	 *  short period of time.
	 *
	 *  @var string
	 *  @access private
	 */
	private $_cache;
	/**
	 *  HTTP Client object
	 *
	 *  @var object
	 *  @access private
	 */
	private $_http;
	/**
	 *  Respository Version.
	 *
	 *  @access private
	 *  @var interger
	 */
	private $_repVersion;
	/**
	 *  Password
	 *
	 *  @access private
	 *  @var string
	 */
	private $pass;
	/**
	 *  Password
	 *
	 *  @access private
	 *  @var string
	 */
	private $user;
	/**
	 *  Last error number
	 *
	 *  Possible values are NOT_ERROR, NOT_FOUND, AUTH_REQUIRED, UNKOWN_ERROR
	 *
	 *  @access public
	 *  @var integer
	 */
	public $errNro;

	private $storeDirectoryFiles = array();
	private $lastDirectoryFiles;

	public function phpsvnclient($url = 'http://phpsvnclient.googlecode.com/svn/', $user = false, $pass = false) {
		$this->__construct($url, $user, $pass);
		register_shutdown_function(array(&$this, '__destruct'));
	}

	public function __construct($url = 'http://phpsvnclient.googlecode.com/svn/', $user = false, $pass = false) {
		$http = & $this->_http;
		$http = new http_class;
		$http->user_agent = "phpsvnclient (http://phpsvnclient.googlecode.com/)";

		$this->_url = $url;
		$this->user = $user;
		$this->pass = $pass;
	}
    
/**
 *  Public Functions
 */

	/**
	 *  rawDirectoryDump
	 *
	 *  This method dumps SVN data for $folder
	 *  in the version $version of the repository.
	 *
	 *  @param string  $folder Folder to get data
	 *  @param integer $version Repository version, -1 means actual
	 *  @return array SVN data dump.
	 */
	public function rawDirectoryDump($folder='/',$version=-1) {
		$actVersion = $this->getVersion();
		if ( $version == -1 ||  $version > $actVersion) {
			$version = $actVersion;
		}
		$url = $this->cleanURL($this->_url."/!svn/bc/".$version."/".$folder."/");
		$this->initQuery($args,"PROPFIND",$url);
		$args['Body'] = PHPSVN_NORMAL_REQUEST;
		$args['Headers']['Content-Length'] = strlen(PHPSVN_NORMAL_REQUEST);

		if ( ! $this->Request($args, $headers, $body) ) {
			return false;
		}
		$xml2Array = new xml2Array();
		return $xml2Array->xmlParse($body);
	}

	/**
	 *  getDirectoryFiles
	 *
	 *  This method returns all the files in $folder
	 *  in the version $version of the repository.
	 *
	 *  @param string  $folder Folder to get files
	 *  @param integer $version Repository version, -1 means actual
	 *  @return array List of files.	 */
	public function getDirectoryFiles($folder='/',$version=-1) {
		if ($arrOutput = $this->rawDirectoryDump($folder,$version)) {
			//echo '<pre>';
			//print_r($arrOutput);
			//echo '</pre>';
			$files = array();
			foreach($arrOutput['children'] as $key=>$value) {
				//echo $key . ' => ' . $value . '</br>';
				array_walk_recursive($value, array($this, 'storeDirectoryFiles'));
				array_push($files,$this->storeDirectoryFiles);
				unset($this->storeDirectoryFiles);
			}
			return $files;
		}
		return false;
	}

	/**
	 *  getDirectoryTree
	 *
	 *  This method returns the complete tree of files and directories
	 *  in $folder from the version $version of the repository.
	 *
	 *  @param string  $folder Folder to get tree
	 *  @param integer $version Repository version, -1 means actual
	 *  @return array List of files and directories.
	 */
	public function getDirectoryTree($folder='/',$version=-1) {
		if ($arrOutput = $this->getDirectoryFiles($folder,$version)) {
			while(count($arrOutput)) {
				$array = array_shift($arrOutput);
				array_push($this->storeDirectoryTree, $array);
				if ($array['type'] == 'directory') {
					$walk = $this->getDirectoryFiles($array['path'],$version);
					array_shift($walk);
					$walk = array_reverse($walk);

					foreach($walk as $step) {
						array_unshift($arrOutput, $step);
					}
				}
			}
		}
		return $this->storeDirectoryTree;
	}

	/**
	 *  Returns file contents
	 *
	 *  @param string  $file File pathname
	 *  @param integer $version File Version
	 *  @return Array File content and information
	 */
	public function getFile($file,$version=-1) {
		$actVersion = $this->getVersion();
		if ( $version == -1 ||  $version > $actVersion) {
			$version = $actVersion;
		}
		$url = $this->cleanURL($this->_url."/!svn/bc/".$version."/".$file."/");
		$this->initQuery($args,"GET",$url);
		if ( ! $this->Request($args, $headers, $body) )
			return false;
		return $body;
	}
    
	/**
	 *  Get changes logs of a file.
	 *
	 *  Get repository change logs between version
	 *  $vini and $vend.
	 *
	 *  @param integer $vini Initial Version
	 *  @param integer $vend End Version
	 *  @return Array Respository Logs
	 */
	public function getRepositoryLogs($vini=0,$vend=-1) {
		return $this->getFileLogs("/",$vini,$vend);
	}

	/**
	 *  Get changes logs of a file.
	 *
	 *  Get repository change of a file between version
	 *  $vini and $vend.
	 *
	 *  @param
	 *  @param integer $vini Initial Version
	 *  @param integer $vend End Version
	 *  @return Array Respository Logs
	 */
	public function getFileLogs($file, $vini=0,$vend=-1) {
		$actVersion = $this->getVersion();
		if ( $vend == -1 || $vend > $actVersion)
			$vend = $actVersion;

		if ( $vini < 0) $vini=0;
		if ( $vini > $vend) $vini = $vend;

		$url = $this->cleanURL($this->_url."/!svn/bc/".$actVersion."/".$file."/");
		$this->initQuery($args,"REPORT",$url);
		$args['Body'] = sprintf(PHPSVN_LOGS_REQUEST,$vini,$vend);
		$args['Headers']['Content-Length'] = strlen($args['Body']);
		$args['Headers']['Depth']=1;

		if ( ! $this->Request($args, $headers, $body) )
			return false;

		$parser=new xml_parser_class;
		$parser->Parse( $body,true);

		$fileinfo =  array(
			SVN_LOGS_VERSION=>"version",
			SVN_LOGS_AUTHOR => "author",
			SVN_LOGS_DATE => "date",
			SVN_LOGS_MODIFIED_FILES => "files",
			SVN_LOGS_ADDED_FILES => "files",
			SVN_LOGS_RENAMED_FILES => "files",
			SVN_LOGS_DELETED_FILES => "files",
			SVN_LOGS_COMMENT => "comment"
			);

		$start = false;
		$last = "";
		$tmp = array();
		foreach($parser->structure as $key=>$value) {
			if ( is_array($value) and $value["Tag"] == SVN_LOGS_BEGINGS) {
				if (count($tmp) > 0) {
					$logs[] = $tmp;
				}
				$start=true;
				$last = "";
				$tmp = array();
				continue;
			}
			if (!$start) continue;
			if ( $last != "") {
				// store details of all files into an array. If there is only one file, store as a string
				if ($tmp[$fileinfo[$last]] && !is_array($tmp[$fileinfo[$last]])){
					$tmp[$fileinfo[$last]] = array($tmp[$fileinfo[$last]]);
				}

				if (is_array($tmp[$fileinfo[$last]]))
					$tmp[$fileinfo[$last]][] = $value;
				else
					$tmp[$fileinfo[$last]] = $value;
				$last = "";
				continue;
			}
			if ( is_array($value) && isset($value["Tag"]) && isset( $fileinfo[$value["Tag"]] ) ) {
				$last = $value["Tag"];
			}
		}
		// add the last element to the array
		$logs[] = $tmp;
		return $logs;
	}

	/**
	 *  Get the repository version
	 *
	 *  @return integer Repository version
	 *  @access public
	 */
	public function getVersion() {
		if ( $this->_repVersion > 0) return $this->_repVersion;

		$this->_repVersion = -1;		$this->initQuery($args,"PROPFIND",$this->cleanURL($this->_url."/!svn/vcc/default") );
		$args['Body'] = PHPSVN_VERSION_REQUEST;
		$args['Headers']['Content-Length'] = strlen(PHPSVN_NORMAL_REQUEST);
		$args['Headers']['Depth']=0;

		if ( !$this->Request($args, $tmp, $body) )  {
			return $this->_repVersion;
		}

		$parser=new xml_parser_class;
		$parser->Parse( $body,true);
		$enable=false;
		foreach($parser->structure as $value) {
			if ( $enable ) {
				$t = explode("/",$value);

				// start from the end and move backwards until we find a non-blank entry
				$index = count($t) - 1;
				while ($t[$index] == ""){
					$index--;
				}

				// check the last non-empty element to see if it's numeric. If so, it's the revision number
				if (is_numeric($t[$index])) {
					$this->_repVersion = $t[$index];
					break;
				}
			}
			if ( is_array($value) && $value['Tag'] == 'D:href') $enable = true;
		}
		return $this->_repVersion;
	}

/**
 *  Deprecated functions for backward comatability
 */

	/**
	 *  Set URL
	 *
	 *  Set the project repository URL.
	 *
	 *  @param string $url URL of the project.
	 *  @access public
	 */
	public function setRepository($url) {
		$this->_url = $url;
	}
	/**
	 *  Old method; there's a typo in the name. This is now a wrapper for setRepository
	 */
	public function setRespository($url) {
		return $this->setRepository($url);
	}
	/**
	 *  Add Authentication  settings
	 *
	 *  @param string $user Username
	 *  @param string $pass Password
	 */
	public function setAuth($user,$pass) {
		$this->user = $user;
		$this->pass = $pass;
	}

/**
 *  Private Functions
 */
	/**
	 *  Callback for array_walk_recursive in public function getDirectoryFiles
	 *
	 *  @access private
	 */
	private function storeDirectoryFiles($item, $key) {
		if ($key == 'name') {
			if (	($item == 'D:HREF') || 
				($item == 'LP1:GETLASTMODIFIED') ||
				($item == 'LP3:BASELINE-RELATIVE-PATH') ||
				($item == 'D:STATUS') ) {
				$this->lastDirectoryFiles = $item;
			}
		} elseif (($key == 'tagData') && ($this->lastDirectoryFiles != '')) {
	
			// Unsure if the 1st of two D:HREF's always returns the result we want, but for now...
			if (($this->lastDirectoryFiles == 'D:HREF') && (isset($this->storeDirectoryFiles['type']))) return;

			// Dump into the array
			if ($this->lastDirectoryFiles == 'D:HREF') { $var = 'type'; }
			elseif ($this->lastDirectoryFiles == 'LP1:GETLASTMODIFIED') { $var = 'last-mod'; }
			elseif ($this->lastDirectoryFiles == 'LP3:BASELINE-RELATIVE-PATH') { $var = 'path'; }
			elseif ($this->lastDirectoryFiles == 'D:STATUS') { $var = 'status'; }

			$this->storeDirectoryFiles[$var] = $item;
			$this->lastDirectoryFiles = '';

			// Detect 'type' as either a 'directory' or 'file'
			if (	(isset($this->storeDirectoryFiles['type'])) &&
				(isset($this->storeDirectoryFiles['last-mod'])) &&
				(isset($this->storeDirectoryFiles['path'])) &&
				(isset($this->storeDirectoryFiles['status'])) ) {

				$len = strlen($this->storeDirectoryFiles['path']);
				if ( substr($this->storeDirectoryFiles['type'],strlen($this->storeDirectoryFiles['type'])-$len) == $this->storeDirectoryFiles['path'] ) {
					$this->storeDirectoryFiles['type'] = 'file';
				} else {
					$this->storeDirectoryFiles['type'] = 'directory';
				}
			}

		} else {
			$this->lastDirectoryFiles = '';
		}
	}

	/**
	 *  Prepare HTTP CLIENT object
	 *
	 *  @param array &$arguments Byreferences variable.
	 *  @param string $method Method for the request (GET,POST,PROPFIND, REPORT,ETC).
	 *  @param string $url URL for the action.
	 *  @access private
	 */
	private function initQuery(&$arguments,$method, $url) {
		$http = & $this->_http;
		$http->GetRequestArguments($url,$arguments);
		if ( isset($this->user) && isset($this->pass)) {
			$arguments["Headers"]["Authorization"] = " Basic ".base64_encode($this->user.":".$this->pass);
		}
		$arguments["RequestMethod"]=$method;
		$arguments["Headers"]["Content-Type"] = "text/xml";
		$arguments["Headers"]["Depth"] = 1;
	}

	/**
	 *  Open a connection, send request, read header
	 *  and body.
	 *
	 *  @param Array $args Connetion's argument
	 *  @param Array &$headers Array with the header response.
	 *  @param string &$body Body response.
	 *  @return boolean True is query success
	 *  @access private
	 */
	private function Request($args, &$headers, &$body) {
		$http = & $this->_http;
		$http->Open($args);
		$http->SendRequest($args);
		$http->ReadReplyHeaders($headers);
		if ($http->response_status[0] != 2) {
			switch( $http->response_status ) {
				case 404:
					$this->errNro=NOT_FOUND;
					break;
				case 401:
					$this->errNro=AUTH_REQUIRED;
					break;
				default:
					$this->errNro=UNKNOWN_ERROR;
			}
			$http->close();
			return false;
		}
		$this->errNro = NO_ERROR;
		$body='';
		$tbody='';
		for(;;) {
			$error=$http->ReadReplyBody($tbody,1000);
			if($error!="" || strlen($tbody)==0) break;
			$body.=($tbody);
		}
		$http->close();
		return true;
	}

	/**
	 *  Clean URL
	 *
	 *  Delete "//" on URL requests.
	 *
	 *  @param string $url URL
	 *  @return string New cleaned URL.
	 *  @access private
	 */
	private function cleanURL($url) {
		return preg_replace("/((^:)\/\/)/", "//", $url);
	}
}
?>
