<?php
//

// requires pe_config.php in the same directory
include('includes/pe_config.php');


class user_db {
	function user_db()
	{
		//global $sys_dbhost,$sys_dbname,$sys_dbuser,$sys_dbpasswd;
		//die("info:" . $sys_dbhost . "!");

		$this->host = $GLOBALS['pelogin_dbhost'];
		$this->db	= $GLOBALS['pelogin_dbname'];
		$this->user = $GLOBALS['pelogin_dbuser'];
		$this->pass = $GLOBALS['pelogin_dbpasswd'];

		$this->link = @mysql_connect($this->host, $this->user, $this->pass, true);
		//true above forces a new connection
		if (!$this->link) die("no link");

		$this->version = mysql_get_server_info();

		if (!$this->link) {
			$GLOBALS['user_connected'] = false;
		} else $GLOBALS['user_connected'] = true;
		@mysql_select_db($this->db) or die("db_down()" . $this->db . "!");
	}
}
$GLOBALS['pelogin_database'] = new user_db;

// function db_connect() {
// 	//global $sys_dbhost,$sys_dbuser,$sys_dbpasswd;
// 	echo "connecting";
// 	$conn = mysql_connect($sys_dbhost,$sys_dbuser,$sys_dbpasswd);
// 	if (!$conn) {
// 		echo mysql_error();
// 	}
// 	return $conn;
// }

function db_query($qstring,$print=0) {
	$db = $GLOBALS['pelogin_database'];
	$result = mysql_query($qstring, $db->link);
	if ($result === false) {
		//trigger_error(mysql_error(), E_USER_ERROR);
		echo "mysql error: " . mysql_error();
	}

	if(!$result) return false;
	return $result;

	//return @mysql($dbname,$qstring);
}

function db_numrows($qhandle) {
	// return only if qhandle exists, otherwise 0
	if ($qhandle) {
		return mysql_numrows($qhandle);
	} else {
		return 0;
	}
}

function db_result($qhandle,$row,$field) {
	return @mysql_result($qhandle,$row,$field);
}

function db_numfields($lhandle) {
	return @mysql_numfields($lhandle);
}

function db_fieldname($lhandle,$fnumber) {
    return @mysql_fieldname($lhandle,$fnumber);
}

function db_affected_rows($qhandle) {
	return @mysql_affected_rows();
}
	
function db_fetch_array($qhandle) {
	return @mysql_fetch_array($qhandle);
}
	
function db_insertid($qhandle) {
	return @mysql_insert_id($qhandle);
}

function db_error() {
	return "\n\n<P><B>".@mysql_error()."</B><P>\n\n";
}

function db_close() {
	$db = $GLOBALS['pelogin_database'];
	mysql_close($db->link);
}

//connect to the db
//I usually call from pre.php
//db_connect();

?>
