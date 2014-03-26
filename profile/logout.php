<?php

include('includes/database.php');
include('includes/pre.php');
include('includes/user.php');


	user_logout();
	$user_name='';

	echo '<script type="text/javascript">window.location.href = "/about/profile";</script>';

?>
