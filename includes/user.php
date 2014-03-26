<?php

$LOGGED_IN=false;
//clear it out in case someone sets it in the URL or something
unset($LOGGED_IN);

/*

create table user (
user_id int not null auto_increment primary key,
user_name text,
real_name text,
email text,
password text,
remote_addr text,
confirm_hash text,
is_confirmed int not null default 0
);

*/

function user_isloggedin() {
	global $user_name,$id_hash,$hidden_hash_var,$LOGGED_IN;
	//have we already run the hash checks? 
	//If so, return the pre-set var
	if (isset($LOGGED_IN) && $LOGGED_IN) {
		return $LOGGED_IN;
	}
	if ($_COOKIE[user_name] && $_COOKIE[id_hash]) {
		$hash=md5($_COOKIE[user_name].$hidden_hash_var);
		if ($hash == $_COOKIE[id_hash]) {
			$LOGGED_IN=true;
			return true;
		} else {
			$LOGGED_IN=false;
			return false;
		}
	} else {
		$LOGGED_IN=false;
		return false;
	}
}

function user_login($user_name,$password) {
	global $feedback;
	global $LOGGED_IN;
	if (!$user_name || !$password) {
		$feedback .=  ' ERROR - Missing user name or password ';
		return false;
	} else {
		$user_name=strtolower($user_name);
		
		$sql="SELECT * FROM site_user WHERE username='$user_name'";
		$result=db_query($sql);
		if (!$result || db_numrows($result) < 1){
			$feedback .=  ' ERROR - User not found ';
			return false;
		} else {
			if (db_result($result,0,'password') != md5($password)) {
				$feedback .= ' ERROR - Incorrect password ';
				return false;
			} else { 
			if (db_result($result,0,'is_confirmed') == '1') {
				user_set_tokens($user_name);
				$feedback .=  ' SUCCESS - You Are Now Logged In ';
				$LOGGED_IN = true;
				return true;
			} else {
				$feedback .=  ' ERROR - You haven\'t Confirmed Your Account Yet ';
				return false;
			}
		}
	}}
}

function user_logout() {
	setcookie('user_name','',(time()+2592000),'/','',0);
	setcookie('id_hash','',(time()+2592000),'/','',0);
}

function user_set_tokens($user_name_in) {
	global $hidden_hash_var,$user_name,$id_hash;
	if (!$user_name_in) {
		$feedback .=  ' ERROR - User Name Missing When Setting Tokens ';
		return false;
	}
	$user_name=strtolower($user_name_in);
	$id_hash= md5($user_name.$hidden_hash_var);

	setcookie('user_name',$user_name,(time()+2592000),'/','',0);
	setcookie('id_hash',$id_hash,(time()+2592000),'/','',0);
}

function user_confirm($hash,$email) {
	/*
		Call this function on the user confirmation page,
		which they arrive at when the click the link in the
		account confirmation email
	*/

	global $feedback,$hidden_hash_var;

	//verify that they didn't tamper with the email address
	$new_hash=md5($email.$hidden_hash_var);
	if ($new_hash && ($new_hash==$hash)) {
		//find this record in the db
		$sql="SELECT * FROM site_user WHERE confirm_hash='$hash'";
		$result=db_query($sql);
		if (!$result || db_numrows($result) < 1) {
			$feedback .= ' ERROR - User Not Found ';
			return false;
		} else {
			//confirm the email and set account to active
			user_set_tokens(db_result($result,0,'user_name'));
			$sql="UPDATE site_user SET email='$email',is_confirmed='1' WHERE confirm_hash='$hash'";
			$result=db_query($sql);
			return true;
		}
	} else {
		$feedback .= ' HASH INVALID - UPDATE FAILED ';
		return false;
	}
}

function user_change_password ($new_password1,$new_password2,$change_user_name,$old_password) {
	global $feedback;
	//new passwords present and match?
	if ($new_password1 && ($new_password1==$new_password2)) {
		//is this password long enough?
		if (account_pwvalid($new_password1)) {
			//all vars are present?
			if ($change_user_name && $old_password) {
				//lower case user name
				$change_user_name=strtolower($change_user_name);
				
				$sql="SELECT * FROM site_user WHERE username='$change_user_name' AND password='". md5($old_password) ."'";
				$result=db_query($sql);
				if (!$result || db_numrows($result) < 1) {
					$feedback .= ' User not found or bad password '.db_error();
					return false;
				} else {
					$sql="UPDATE site_user SET password='". md5($new_password1). "' ".
						"WHERE username='$change_user_name' AND password='". md5($old_password). "'";
					$result=db_query($sql);
					if (!$result || db_affected_rows($result) < 1) {
						$feedback .= ' NOTHING Changed '.db_error();
						return false;
					} else {
						$feedback .= ' Password Changed ';
						return true;
					}
				}
			} else {
				$feedback .= ' Must Provide User Name And Old Password ';
				return false;
			}
		} else {
			$feedback .= ' New Password Does Not Meet Criteria ';
			return false;
		}
	} else {
		return false;
		$feedback .= ' New Passwords Must Match ';
	}
}

function user_lost_password ($email) {
	global $feedback,$hidden_hash_var;
	if ($email) {
		$sql="SELECT * FROM site_user WHERE email='$email'";
		$result=db_query($sql);
		if (!$result || db_numrows($result) < 1) {
			//no matching user found
			$feedback .= ' We did not find a user with that email address. Please try again or <a href="/profile/register.php>register as a new user</a>. ';
			return false;
		} else {
			//create a secure, new password
			$new_pass=strtolower(substr(md5(time().$user_name.$hidden_hash_var),1,14));
			$user_name = db_result($result,0,'username');
			//update the database to include the new password
			$sql="UPDATE site_user SET password='". md5($new_pass) ."' WHERE username='$user_name'";
			$result=db_query($sql);
			//send a simple email with the new password
			mail ($email,'Password Reset Notification from ProjectExplorer.org','The password for '. $user_name .' at ProjectExplorer.org '.
				'has been reset to: '. $new_pass . "\n \n Please use this new password the next time you visit http://projectexplorer.org, and be sure to reset your password at your earliest convenience at http://projectexplorer.org/profile/changepass.php.",'From: register@projectexplorer.org');
			$feedback .= ' Your new password has been emailed to you. ';
			return true;
		}
	} else {
		$feedback .= ' A valid email address is required to retrieve your password. ';
		return false;
	}
}

function user_change_email ($password1,$new_email,$user_name) {
	global $feedback,$hidden_hash_var;
	if (validate_email($new_email)) {
		$hash=md5($new_email.$hidden_hash_var);
		//change the confirm hash in the db but not the email - 
		//send out a new confirm email with a new hash
		$user_name=strtolower($user_name);

		$sql="UPDATE site_user SET confirm_hash='$hash' WHERE username='$user_name' AND password='". md5($password1) ."'";
		$result=db_query($sql);
		if (!$result || db_affected_rows($result) < 1) {
			$feedback .= ' ERROR - Incorrect User Name Or Password ';
			return false;
		} else {
			$feedback .= ' Confirmation Sent ';
			user_send_confirm_email($new_email,$hash);
			return true;
		}
	} else {
		$feedback .= ' New Email Address Appears Invalid ';
		return false;
	}
}

function user_send_confirm_email($email,$hash) {
	/*
		Used in the initial registration function
		as well as the change email address function
	*/

	$message = "Thank You For Registering with ProjectExplorer.".
		"\nSimply follow this link to confirm your registration: ".
		"\n\nhttp://www.projectexplorer.org/profile/confirm.php?hash=$hash&email=". urlencode($email).
		"\n\nIf you have not registered, you can ignore this email, and no additional messages will be sent. If you have any questions, you can reply to this email and our staff will assist as soon as they can.";
	mail ($email,'ProjectExplorer Registration Confirmation',$message,'From: register@projectexplorer.org');
}

function refer_save($to_emails,$name,$from_email)
{
	global $feedback;
	
	foreach($to_emails as $to){
		$sql = "INSERT INTO site_refer (refer_to,from_name,from_email) " .
				"VALUES ('$to', '$name', '$from_email')";
		$result=db_query($sql);
				if (!$result) {
					$feedback .= ' ERROR - '.db_error();
					return false;
				}
	}
	
	return true;
}

function sql_safe($s)
{
    if (get_magic_quotes_gpc())
        $s = stripslashes($s);

    return mysql_real_escape_string($s);
}

function photo_contest($name,$school,$grade,$from_email,$phone,$address1,$address2,$city,$state,$zip,$message,$photo1,$photo2,$photo3,$agree)
{
		global $feedback;
	$table="entries2007";


 // cleaning title field
	if ($name && $school && $grade && $from_email && $phone && $message) {
		if (validate_email($from_email)){
			if ($agree) {
				$name = trim(sql_safe($name));
				$grade = trim(sql_safe($grade));
				$address1 = trim(sql_safe($address1));
				$address2 = trim(sql_safe($address2));
				$city = trim(sql_safe($city));
				$zip = trim(sql_safe($zip));
				$message = trim(sql_safe($message));			
	//*** START EDITING HERE TO CHANGE IMAGE MIME BEHAVIOR ***//
				@$imageinfo = getimagesize($_FILES['photo1']['tmp_name']);
					// Get image type.
					// We use @ to omit errors
				$width = $imageinfo[0];
				$imtype = $imageinfo[2];
				$filesize1 = $imageinfo[3];
				$mime1 = $imageinfo{'mime'};
	
				if($width>0) {
					if ($imtype == 3) // cheking image type
						$ext1="png";   // to use it later in HTTP headers
					elseif ($imtype == 2)
						$ext1="jpeg";
					elseif ($imtype == 1)
						$ext1="gif";
					else
						$msg .= 'Error: unknown file format for Photo 1. GIF, JPG, and PNG are accepted.<br>';
					
					$data1 = file_get_contents($_FILES['photo1']['tmp_name']);
					$data1 = mysql_real_escape_string($data1);
					// Preparing data to be used in MySQL query
				} else { $data1 = ""; }
	 
				@$imageinfo = getimagesize($_FILES['photo2']['tmp_name']);
					// Get image type.
					// We use @ to omit errors
				$width = $imageinfo[0];
				$imtype = $imageinfo[2];
				$filesize2 = $imageinfo[3];
				$mime2 = $imageinfo{'mime'};
					
				if($width>0) {
					if ($imtype == 3) // cheking image type
						$ext2="png";   // to use it later in HTTP headers
					elseif ($imtype == 2)
						$ext2="jpeg";
					elseif ($imtype == 1)
						$ext2="gif";
					else
						$msg .= 'Error: unknown file format for Photo 2. GIF, JPG, and PNG are accepted.<br>';
					
						$data2 = file_get_contents($_FILES['photo2']['tmp_name']);
						$data2 = mysql_real_escape_string($data2);
						// Preparing data to be used in MySQL query
				} else { $data2 = ""; }	
	
				@$imageinfo = getimagesize($_FILES['photo3']['tmp_name']);
					// Get image type.
					// We use @ to omit errors
				$width = $imageinfo[0];
				$imtype = $imageinfo[2];
				$filesize3 = $imageinfo[3];
				$mime3 = $imageinfo{'mime'};
					
				if($width>0) {
					if ($imtype == 3) // cheking image type
						$ext3="png";   // to use it later in HTTP headers
					elseif ($imtype == 2)
						$ext3="jpeg";
					elseif ($imtype == 1)
						$ext3="gif";
					else
						$msg .= 'Error: unknown file format for Photo 3. GIF, JPG, and PNG are accepted.<br>';
					
						$data3 = file_get_contents($_FILES['photo3']['tmp_name']);
						$data3 = mysql_real_escape_string($data3);
						// Preparing data to be used in MySQL query
				} else { $data3 = ""; }						
	
				if (empty($msg)) // If there was no error
				{
					$sql = "INSERT INTO {$table}
									SET name='$name', school='$school', grade='$grade', from_email='$from_email', phone='$phone', address1='$address1',
									address2='$address2', city='$city', state='$state', zip='$zip', message='$message',
									photo1='$data1', photoext1='$mime1', photosize1='$filesize1',
									photo2='$data2', photoext2='$mime2', photosize2='$filesize2',
									photo3='$data3', photoext3='$mime3', photosize3='$filesize3',agree=1";
					$result=db_query($sql);
					if (!$result) {
						$feedback .= ' ERROR - '.db_error();
						return false;
					}
					
					$feedback = 'Thank you for your entry, and good luck in our 2007 Student Competition!';
					return true;
				} else {
					$feedback .= $msg;
					return false;
				}
			} else {
				$feedback .= ' We cannot accept your entry unless you agree to the Contest Rules. Please read the Contest Rules and select the box below to continue. ';
				return false;
			}
		} else {
			$feedback .= ' Please be sure your email address is formatted correctly. We need a valid email address to contact entrants. ';
			return false;
		}
	} else {
		$feedback .= ' ERROR - Please complete all required fields, marked with a "*".';   
		return false;
	}

}

function ask_exp($to_exp,$name,$school,$grade,$from_email,$message) {
	global $feedback;
	
	$message = stripslashes($message);
	//all req vars present?
	if($to_exp && $name && $school && $grade && $from_email){
	//from email formatted correctly?
		if(validate_email($from_email)){

			//build message and headers
				$msg_text = "$name (School: $school; Grade: $grade) asked $to_exp the following question:\n" . $message;
				$msg_text .= "
			
---------------------------------------------
This email sent from ProjectExplorer.org
www.projectexplorer.org";

				$from_hdr = "From: $from_email";
				$to_all = "questions@projectexplorer.org";
				//if((strcmp($to_exp, "The PE Team") == 0)||(strcmp($to_exp, "Jenny") == 0)){
				//	$to_all = "jenny@projectexplorer.org";
				//}
				//else
				//{
				//	$to_all = strtolower($to_exp) . "@projectexplorer.org, jenny@projectexplorer.org";
				//}
				//send message
				mail($to_all,"[PE] Explorer Question for $to_exp",$msg_text,$from_hdr);
			
			$feedback = "Your email has been sent to $to_all. Thank you for visiting ProjectExplorer!";
			return true;
		} else {
			$feedback = "Your email address is not formatted correctly. Please check your email address and try again.";
			return false;
		}
	} else {
		$feedback = "Your name and email address are required so that we can reply to you. Please also provide your school and grade so that we know how best to answer your question.";
		return false;
	} 
}

function refer_user($to_email,$name,$from_email,$message) {
	global $feedback;
	
	$message = stripslashes($message);
	//all req vars present?
	if($to_email && $name && $from_email){
	//from email formatted correctly?
		if(validate_email($from_email)){
			$to_str = preg_replace('/\s+/', '', $to_email);
			$to_str = rtrim($to_str,",");
			$to_emails = explode(",", $to_str);
			$error_stack = array();
			//all to emails correct?
			foreach ($to_emails as $test_addy)
			{
				if(!validate_email($test_addy)){
					$error_stack[] = $test_addy;
				}
			}
			if(count($error_stack) == 0){
			//build message and headers
				$msg_text = "$name thought you would be interested in learning more about ProjectExplorer.

ProjectExplorer is an educational organization that provides FREE interactive fieldtrips to the kindergarten through twelfth grade community around the world.  Combining documentary-style digital video, photos, lesson plans, web chats and encyclopedia-style research, ProjectExplorer's unique approach to learning helps expose students to various regions, traditions and cultures, while helping shape the next generation of global citizens. 

To learn more or to become a registered user visit www.projectexplorer.org.

ProjectExplorer is a free educational resource. Registered members will also be able to access discounts to theatre, on travel and other exclusive offers available through our sponsors and partners.";
				if($message) {
					$msg_text .="
					
Here's what $name had to say about ProjectExplorer:

$message";
				}
			
				$msg_text .= "
			
---------------------------------------------
This email sent from ProjectExplorer.org
www.projectexplorer.org";

				$from_hdr = "From: $from_email";
				$to_all = implode(", ",$to_emails);
				//send message
				mail($to_all,"From A Friend: ProjectExplorer",$msg_text,$from_hdr);
				// save info
			refer_save($to_emails,$name,$from_email);
			$feedback = "Your email has been sent. Thank you for sharing ProjectExplorer!";
			return true;
			} else {
				$feedback = "Errors were found with the following address(es). Please verify and try again:<br />";
				foreach($error_stack as $bad_addy){
					$feedback .= $bad_addy . "<br />";
				}
			}
		} else {
			$feedback = "Your email address is not formatted correctly. Please check your email address and try again.";
		}
	} else {
		$feedback = "Your name, email address, and your friend/colleague's email address(es) are required.";
	} 
	
}

function user_register($user_name,$password1,$password2,$first,$last,$job,$level,$classsize,$orgname,$address,$address2,$city,$state,$zip,$country,$email,$se_topics,$future_loc,$comments,$optout) {
	global $feedback,$hidden_hash_var;
	//all vars present?
	if ($user_name && $password1 && $first && $last && $address && $city && $zip && $email && validate_email($email)) {
	  //and passwords match?
	  if($password1==$password2){
		//password and name are valid?
		if (account_namevalid($user_name) && account_pwvalid($password1)) {
			$user_name=strtolower($user_name);

		//	does the email exist in the database?
			$sql="SELECT * FROM site_user WHERE email='$email'";
			$result=db_query($sql);
			if ($result && db_numrows($result) > 0) {
				$feedback .=  ' ERROR - Someone has already registered with that email address. ';
				return false;
			} else {
				//create a new hash to insert into the db and the confirmation email
				if(get_magic_quotes_gpc()==0) {
					$first = mysql_real_escape_string($first);
					$last = mysql_real_escape_string($last);
					$orgname = mysql_real_escape_string($orgname);
					$address = mysql_real_escape_string($address);
					$address2 = mysql_real_escape_string($address2);
					$city = mysql_real_escape_string($city);
					$country = mysql_real_escape_string($country);
					$se_topics = mysql_real_escape_string($se_topics);
					$future_loc = mysql_real_escape_string($future_loc);
					$comments = mysql_real_escape_string($comments);
				}
				
				$hash=md5($email.$hidden_hash_var);
				if(count($job)>0){
					$jobstr=implode(",", $job);
				}else{
					$jobstr="";
				}
				
				if(count($level)>0){
					$levelstr=implode(",", $level);
				}else{
					$levelstr="";
				}
				
				if(!is_numeric($classsize)){
					$classsize="0";
				}
				
				$password=md5($password1);
				
				
				$sql="INSERT INTO site_user (username,password,first,last,job,level,classsize,orgname,address,address2,city,state,zip,country,email,se_topics,future_loc,comments,email_optout,remote_addr,confirm_hash,is_confirmed) ".
					"VALUES ('$user_name','$password','$first','$last','$jobstr','$levelstr',$classsize,'$orgname','$address','$address2','$city','$state','$zip','$country','$email','$se_topics','$future_loc','$comments','$optout','$GLOBALS[REMOTE_ADDR]','$hash','0')";
				$result=db_query($sql);
				if (!$result) {
					$feedback .= ' ERROR - '.db_error();
					return false;
				} else {
					//send the confirm email
					user_send_confirm_email($email,$hash);
					$feedback .= 'You have successfully registered. Check your email for a message from us, and confirm your registration.<br />Be sure and check your Spam Folder, and add us to your address book so you don\'t miss any news!';
					return true;
				}
			} // end else: safe email
		} else {
			$feedback .=  ' Account Name or Password Invalid ';
			return false;
		}
	  } else {
		  $feedback .=  ' ERROR - Please retype your password, making sure both passwords match.';
		  return false;
	  }
	} else {
		$feedback .= ' ERROR - User must complete all required fields, marked with a "*".';   
		return false;
	}
}


function user_getid() {
	global $G_USER_RESULT;
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$G_USER_RESULT) {
		$G_USER_RESULT=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($G_USER_RESULT && db_numrows($G_USER_RESULT) > 0) {
		return db_result($G_USER_RESULT,0,'user_id');
	} else {
		return false;
	}
}

function user_getfirstname() {
	global $G_USER_RESULT;
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$G_USER_RESULT) {
		$G_USER_RESULT=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($G_USER_RESULT && db_numrows($G_USER_RESULT) > 0) {
		return stripslashes(db_result($G_USER_RESULT,0,'first'));
	} else {
		return false;
	}
}

function user_getlastname() {
	global $G_USER_RESULT;
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$G_USER_RESULT) {
		$G_USER_RESULT=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($G_USER_RESULT && db_numrows($G_USER_RESULT) > 0) {
		return stripslashes(db_result($G_USER_RESULT,0,'last'));
	} else {
		return false;
	}
}

function user_getemail() {
	global $G_USER_RESULT;
	//see if we have already fetched this user from the db, if not, fetch it
	if (!$G_USER_RESULT) {
		$G_USER_RESULT=db_query("SELECT * FROM site_user WHERE username='" . user_getname() . "'");
	}
	if ($G_USER_RESULT && db_numrows($G_USER_RESULT) > 0) {
		return db_result($G_USER_RESULT,0,'email');
	} else {
		return false;
	}
}

function user_getname() {
	if (user_isloggedin()) {
		return $_COOKIE['user_name'];
	} else {
		//look up the user some day when we need it
		return ' ERROR - Not Logged In ';
	}
}

function account_pwvalid($pw) {
	global $feedback;
	if (strlen($pw) < 6) {
		$feedback .= " Password must be at least 6 characters. ";
		return false;
	}
	return true;
}

function account_namevalid($name) {
	global $feedback;
	// no spaces
	if (strrpos($name,' ') > 0) {
		$feedback .= " There cannot be any spaces in the login name. ";
		return false;
	}

	// must have at least one character
	if (strspn($name,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == 0) {
		$feedback .= "There must be at least one character.";
		return false;
	}

	// must contain all legal characters
	if (strspn($name,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_")
		!= strlen($name)) {
		$feedback .= " Illegal character in name. ";
		return false;
	}

	// min and max length
	if (strlen($name) < 5) {
		$feedback .= " Name is too short. It must be at least 5 characters. ";
		return false;
	}
	if (strlen($name) > 15) {
		$feedback .= "Name is too long. It must be less than 15 characters.";
		return false;
	}

	// illegal names
	if (eregi("^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)|(halt)|(mail)|(news)"
		. "|(uucp)|(operator)|(games)|(mysql)|(httpd)|(nobody)|(dummy)"
		. "|(www)|(cvs)|(shell)|(ftp)|(irc)|(debian)|(ns)|(download))$",$name)) {
		$feedback .= "Name is reserved.";
		return 0;
	}
	if (eregi("^(anoncvs_)",$name)) {
		$feedback .= "Name is reserved.";
		return false;
	}

	return true;
}

function validate_email ($address) {
	return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $address));
}

?>
