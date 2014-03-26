<?php 
	$sectionLocation="teachers"; 
	$pageLocation="teachers"; 
	include('includes/include-head.php'); 

	include('includes/db.php');
	include('includes/pre.php');
	include('includes/users.php');

	if (user_isloggedin()) {
		user_logout();
		$user_name='';
	}

	if ($_POST[submit]) {
		user_register($_POST[user_name],$_POST[password1],$_POST[password2],$_POST[first],$_POST[last],$_POST[job],$_POST[level],$_POST[classsize],$_POST[orgname],$_POST[address],$_POST[address2],$_POST[city],$_POST[state],$_POST[zip],$_POST[country],$_POST[email],$_POST[se_topics],$_POST[future_loc],$_POST[comments],$_POST[optout]);
	}
			
	if ($feedback) {
		echo '<div class="error">'.$feedback.'</div>';
	}
	if (!$country) {
		$country="USA";
	 }

	echo '
	<p>ProjectExplorer.org is a <strong>free</strong> educational resource. If you would like more information on ProjectExplorer.org, or if you have a suggestion, we would love to hear from you. Our future expeditions and projects are developed based on educator and audience input.</p>
	<p>We look forward to welcoming you on our travels.</p>
	';

	echo '<FORM ACTION="'. $PHP_SELF .'" METHOD="POST" id="register" name="register">
			<fieldset>
			<label for="user_name" class="required">User Name</label>
			<input type="text" name="user_name" id="user_name" value="'. $_POST[user_name] .'" maxlength="15">

			<label for="password1" class="required">Password</label>
			<input type="password" name="password1" id="password1" value="'. $_POST[password1] .'" maxlength="15">

			<label for="password1" class="required">Password (again)</label>
			<input type="password" name="password2" id="password2" value="'. $_POST[password2] .'" maxlength="15">
		
			<label for="first" class="required">First Name</label>
			<input type="text" name="first" id="first" value="'. stripslashes($_POST[first]) .'" maxlength="35">

			<label for="last" class="required">Last Name</label>
			<input type="text" name="last" id="last" value="'. stripslashes($_POST[last]) .'" maxlength="35">
			
			<div class="buttongroup"><label for="job">I am a(n)</label><div class="checkboxgroup" id="jobgroup">
			';
	
	$jobstring=MakeCheckBoxes("job", array("Administrator", "Educator", "Parent", "Student", "Student Teacher", "Other"), $_POST[job]);
	echo $jobstring;

	echo '	</div></div>
			<div class="buttongroup"><label for="level">Grade Level(s)</label><div class="checkboxgroup" id="gradegroup">';

	$levelstring=MakeCheckBoxes("level", array("Pre K-Grade 2", "Grades 3-4", "Grades 5-8", "Grades 9-12", "Other / NA"), $level);
	echo $levelstring;

	echo '	</div></div>
			<label for="classsize">Class Size</label>
			<input type="number" id="classsize" name="classsize" value="'. $_POST[classsize] .'" maxlength="3">

			<label for="orgname">School / District / Company</label>
			<input type="text" id="orgname" name="orgname" value="'. stripslashes($_POST[orgname]) .'" maxlength="50">

			<label for="address" class="required">Address</label>
			<input type="text" id="address" name="address" value="'. stripslashes($_POST[address]) .'" maxlength="50">
			
			<label for="address2">Address 2</label>
			<input type="text" id="address2" name="address2" value="'. stripslashes($_POST[address2]) .'" maxlength="50">
			
			<label for="city" class="required">City</label>
			<input type="text" id="city" name="city" value="'. stripslashes($_POST[city]) .'" maxlength="15">
			
			<label for="state">State</label>
			<input type="text" id="state" name="state" value="'. $_POST[state] .'" maxlength="3">
			
			<label for="zip" class="required">Postal Code</label>
			<input type="text" id="zip" name="zip" value="'. $_POST[zip] .'" maxlength="15">
		
        	<label for="country" class="required">Country</label>
			<input type="text" id="country" name="country" value="'. stripslashes($_POST[country]) .'" maxlength="15">

			<label for="email" class="required">Email</label>
			<input type="email" id="email" name="email" value="'. $_POST[email] .'" maxlength="35">
	
			<label for="se_topics" class="textarealabel">How did you hear about ProjectExplorer.org?</label>
			<textarea id="se_topics" name="se_topics">'. stripslashes($_POST[se_topics]) .'</textarea>
			
			<label for="future_loc" class="textarealabel">What future locations would you like team ProjectExplorer.org to visit?</label>
			<textarea id="future_loc" name="future_loc">'. stripslashes($_POST[future_loc]) .'</textarea>
	
			<label for="comments" class="textarealabel">Any other comments? (Please do not leave questions in this area.)</label>
			<textarea name="comments">'. stripslashes($_POST[comments]) .'</textarea>

			<input type="button" name="submit" id="submit" value="Register">
			</fieldset>
			</form>

			<p class="footnote">ProjectExplorer.org will not willfully disclose your personal information to any third party without first receiving your permission. See ProjectExplorer.org\'s <a href="/about/privacy">Privacy Policy</a> for more information.</p>

';

?>

