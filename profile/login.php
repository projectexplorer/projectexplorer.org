<?php

include('includes/db.php');
include('includes/pre.php');
include('includes/users.php');
include('includes/pe_config.php');

if (!$_POST[url]) {
  $return_url = isset($_SERVER{'HTTP_REFERER'}) ? $_SERVER{'HTTP_REFERER'} : "/about/profile";
  if(strpos($return_url, "login") > 0) $return_url = "/about/profile";
}
else
{
  $return_url = $_POST[url];
}

echo "return url = ". $return_url;

if ($_POST[submit]) {
  $didlogin = user_login($_POST[user_name],$_POST[password],$sys_dbname);
  if ($didlogin) {
    echo '<script type="text/javascript">window.location.href="'. $return_url . '";</script>';
  }
}

// if (user_isloggedin()) {
// 	//modify to redirect to the page you came from: JS? Params?
// 	echo '<script type="text/javascript">window.location.href="'. $return_url . '";</script>';
// 	return true;
// }

if ($feedback) {
	echo '<p><span class="error">'.$feedback.'</span></p>';
}

if (!$_POST[url]) {
	$return_url = isset($_SERVER{'HTTP_REFERER'}) ? $_SERVER{'HTTP_REFERER'} : "/about/profile";
}
else
{
	$return_url = $_POST[url];
}

echo '
	<P>
	Enter your user name and password to log in.
	<P>

  <form action="/about/login" method="POST">
  <fieldset>
	<label for="user_name" class="required">User Name</label>
	<input type="text" id="user_name" name="user_name">
	
	<label for="password" class="required">Password</label>
	<input type="password" id="password" name="password">
	<br><a href="lostpass">Forgot your login/password?</a>
	<P>
	<input type="hidden" id="url" name="url" value="' . $return_url . '">
  <input type="submit" name="submit" id="submit" value="Login to ProjectExplorer.org">
  </fieldset>
  </form>';


?>
