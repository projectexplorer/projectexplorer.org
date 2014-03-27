<?php

include('includes/db.php');
include('includes/pre.php');
include('includes/users.php');

if ($_GET[hash] && $_GET[email]) {
	$worked=user_confirm($_GET[hash],$_GET[email]);
} else {
	$GLOBALS['feedback'] .= 'ERROR - Missing Params';
}


  if ($GLOBALS['feedback']) {
    echo '<p class="error">'.$GLOBALS['feedback'].'</p>';
    unset($GLOBALS['feedback']);
  }

if ($worked) {
	$querystring = "SELECT * FROM site_user WHERE email='$_GET[email]'";
	$DB_USER_RESULT=db_query($querystring);
	if ($DB_USER_RESULT && db_numrows($DB_USER_RESULT) > 0) {
		$username = db_result($DB_USER_RESULT,0,'username');
		$first = db_result($DB_USER_RESULT,0,'first');
		$last = db_result($DB_USER_RESULT,0,'last');
		$address = db_result($DB_USER_RESULT,0,'address');
		$address2 = db_result($DB_USER_RESULT,0,'address2');
		$job = db_result($DB_USER_RESULT,0,'job');
		$level = db_result($DB_USER_RESULT,0,'level');
		$classsize = db_result($DB_USER_RESULT,0,'classsize');
		$orgname = db_result($DB_USER_RESULT,0,'orgname');
		$city = db_result($DB_USER_RESULT,0,'city');
		$state = db_result($DB_USER_RESULT,0,'state');
		$zip = db_result($DB_USER_RESULT,0,'zip');
		$country = db_result($DB_USER_RESULT,0,'country');
		$se_topics = db_result($DB_USER_RESULT,0,'se_topics');
		$future_loc = db_result($DB_USER_RESULT,0,'future_loc');
		$comments = db_result($DB_USER_RESULT,0,'comments');
		$optout = db_result($DB_USER_RESULT,0,'email_optout');
	} else { echo "<p>DB lookup failed - ". mysql_error() ." </p>"; }
	echo '		
		<p>
		Thank you for confirming your registration with ProjectExplorer.org. We have saved your profile as shown below.
		</p>
		<p>As a registered user, you have the option of receiving updates and news about our ongoing expeditions, and
		also have access to discounts and offers provided by our sponsors and partners.</p>
		
		<h3>Be sure and register for our newsletters!</h3>
		<p>To help protect your privacy, we use a newsletter system that lets
		you manage how much email you want from ProjectExplorer.org. To get started, go to <a href="/about/profile">Manage your Profile</a> now.</p>
		<p><strong>NOTE:</strong> If you have changed your email address, you will need to <strong>resubscribe</strong> using your profile page.</p>
		
		<p>We look forward to welcoming you on our travels, and thank you for your interest.</p>';
	
	echo '
		<h3>ProjectExplorer.org Profile</h3>
		<p><strong>User Name:</strong> '. $username .'</p>
		<p><strong>First Name:</strong> '. $first .'</p>
		<p><strong>Last Name:</strong> '. $last .'</p>
		<p><strong>I am a(n):</strong> ';
		
	$jobstring=implode(", ", explode(",",$job));
	echo $jobstring;
		
	echo '			</p>
		<p><strong>Grade Level(s):</strong> ';
				
	$levelstring=implode(", ", explode(",",$level));
	if(!$levelstring) {$levelstring="None";}
	echo $levelstring;
		
	echo '			</p>
		<p><strong>Class Size:</strong> ' .$classsize .'</p>
		<p><strong>School, District or Company:</strong> '. $orgname .'</p>
		<p><strong>Address:</strong> '. $address .'</p>
		<p><strong>Address 2:</strong> '. $address2 .'</p>
		<p><strong>City:</strong> '. $city .'</p>
		<p><strong>State:</strong>'. $state .'</p>
		<p><strong>Postal Code:</strong> '. $zip .'</p>
		<p><strong>Country:</strong> '. $country .'</p>
		<p><strong>Email:</strong> '. $email .'</p>
		<p></p>
		<p><strong>How did you hear about ProjectExplorer.org?</strong><br />'. $se_topics .'</p>
		<p><strong>What future locations would you like the ProjectExplorer.org team to visit?</strong><br />'. $future_loc .'</p>
		<p><strong>Any other comments?</strong><br />'. $comments .'</p>
		<p></p>
		<p>ProjectExplorer.org will not willfully disclose your personal information to any third party without first receiving your permission. See ProjectExplorer.org\'s <a href="/about/privacy">Privacy Policy</a> for more information.</p>
		';
} //end if worked


?>
