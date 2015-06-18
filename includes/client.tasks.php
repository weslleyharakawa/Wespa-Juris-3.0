<?php 
/*
	=================================================================
	# Wespa Juris 3.0 - Acompanhamento Processual Baseado na Web            
	# Copyright © 2012 Wespa Digital Ltda.
	# Developed by Weslley A. Harakawa (weslley@wcre8tive.com)
	#
	# O código deste software não pode ser vendido ou alterado
	# sem a autoização expressa de Wespa Digital Ltda. 
	# Mantenha os créditos do autor e os códigos de banners.
	#
	# Gratuíto para uso pessoal, não pode ser redistribuído.
	=================================================================
*/ 
if ($_POST['task']) { 
	$task = $_POST['task'];
}
else if ($_GET['task']) {
	$task = $_GET['task'];
}

// SWITCH FOR TASK
switch ($task) {
	
	// SEND CONTACT FORM
	case contactform:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path, $home_dir;
			
			include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
			include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );
	
				$now = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
				
				$logo = $web_path . $_SESSION['site_logo'];
				$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
				
				if ($_POST['contact_subject'] == '') {
					$contact_subject = "No Subject";
					$strip_subject = $contact_subject;
				}
				else {
					$contact_subject = $_POST['contact_subject'];
					$strip_subject = stripslashes($_POST['contact_subject']);
				}
				
				$contact_message = stripslashes($_POST['contact_message']);
				$to_email = $_POST['recipient'];
				$project_title = stripslashes($_POST['project']);
				
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '9' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_SESSION['client_id'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = $the_client[ "company" ];
						
						$subject = str_replace('[subject]', $strip_subject, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$strip_name = stripslashes($_POST['realname']);
						
						$message = str_replace('[company]', $_SESSION['admin_company'], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $_SESSION['client_name'], $message);
						$message = str_replace('[project title]', $project_title, $message);
						$message = str_replace('[sent]', $now, $message);
						$message = str_replace('[message]', $contact_message, $message);
						$message = str_replace('[subject]', $contact_subject, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";
						$headers .= "From: \"" . $strip_name . "\" <" . $_POST['email'] . ">\r\n";
						
						$to_admin = $_SESSION['admin_company'];
						$to_email = $_SESSION['admin_email'];
					
						mail("\"$to_admin\" <$to_email>",$subject,$message,$headers);
	
				echo ("<div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $COMMON_SENT . "</div><br />");
				
				$showform = 0;
		}
		break;
	
	// ADD MESSAGE REPLY
	case addquickreply:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path, $home_dir;
			
			include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
			include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );
	
				$now = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
				
				$comment = addslashes($_POST['comment']);

				$SQL = " INSERT INTO ttcm_comments (message_id, comment, posted, post_by) VALUES ('$_POST[mid]','$comment','$now','$_POST[post_by]') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$SQL4 = " SELECT project_id FROM ttcm_messages WHERE message_id = '" . $_POST['mid'] . "' ";
				$retid4 = $db_q($db, $SQL4, $cid);
				$row4 = $db_f($retid4);
				
				$updated = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
				
				if ($row4[ "project_id" ] != '0') {
					$SQL4 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $row4[ "project_id" ] . "' ";
					$result4 = $db_q($db,"$SQL4",$cid);
				}
				
				$SQL3 = " UPDATE ttcm_messages SET updated = '" . $updated . "' WHERE message_id = '" . $_POST['mid'] . "' ";
				$result3 = $db_q($db,"$SQL3",$cid);
			
				$SQL2 = " SELECT name, email FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
				$retid = $db_q($db, $SQL2, $cid);
			
				$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE type = '1' ";
				$retid7 = $db_q($db, $SQL7, $cid);
			
				while ( $row7 = $db_f($retid7) ) {
					$admins_name = $row7[ "name" ];
					$admins_name = stripslashes($admins_name);
					$admins_email = $row7[ "email" ];
					$admin_perms = $row7[ "permissions" ];
					$email_perms = split(',', $admin_perms);
					
					$strip_comment = stripslashes($_POST['comment']);

					if ( ($admins_email != '') && (in_array("98", $email_perms)) ) {
						
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";

						$SQL1 = "SELECT message_title, verify_id FROM ttcm_messages WHERE message_id = '" . $_POST['mid'] . "'";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$message_title = stripslashes($row1[ 'message_title' ]);
						$verify_id = $row1[ "verify_id" ];
						
						$message_link = $web_path . "message.php";
						$reply = $message_link . "?mid=" . $_POST['mid'] . "&id=" . $_SESSION['valid_id'] . "&vid=" . $verify_id;
						$reply_link = "<a href=\"" . $reply . "\">Reply to \"" . $message_title . "\"</a>";

						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '5' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['project_id'] . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = $the_proj[ "title" ];
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = $the_client[ "company" ];
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[message title]', $message_title, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION['admin_company'], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $users_name, $message);
						$message = str_replace('[message title]', $message_title, $message);
						$message = str_replace('[message reply]', $strip_comment, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[web path]', $web_link, $message);
						$message = str_replace('[reply link]', $reply_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$admins_name\" <$admins_email>",$subject,$message,$headers);
					}
				}
				
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD MESSAGE REPLY OUTSIDE CLIENT AXIS
	case addextquickreply:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path;
			
			include( "lang/" . $lang . "/c_common.php" );
			include( "lang/" . $lang . "/c_messages.php" );
	
				$now = date("Y/m/d G:i:s", time() + $serverdiff * 60 * 60);
				
				$comment = addslashes($_POST['comment']);
				$strip_comment = stripslashes($_POST['comment']);

				$SQL = " INSERT INTO ttcm_comments (message_id, comment, posted, post_by) VALUES ('$_POST[mid]','$comment','$now','$_POST[post_by]') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$SQL4 = " SELECT message_title, project_id FROM ttcm_messages WHERE message_id = '" . $_POST['mid'] . "' ";
				$retid4 = $db_q($db, $SQL4, $cid);
				$row4 = $db_f($retid4);
				
				$updated = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
				
				if ($row4[ "project_id" ] != '0') {
					$SQL4 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $row4[ "project_id" ] . "' ";
					$result4 = $db_q($db,"$SQL4",$cid);
				}
				
				$SQL3 = " UPDATE ttcm_messages SET updated = '" . $updated . "' WHERE message_id = '" . $_POST['mid'] . "' ";
				$result3 = $db_q($db,"$SQL3",$cid);
			
				$SQL2 = " SELECT name, email FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
				$retid = $db_q($db, $SQL2, $cid);
				
				// PULL ADMIN DATA FROM DATABASE
				$query0 = " SELECT * FROM ttcm_admin WHERE company_id = '1' ";
				$retid0 = $db_q($db, $query0, $cid);
				$row0 = $db_f($retid0);
				$company = $row0[ "company" ];
				$admin_company = stripslashes($company);
				$address1 = $row0[ "address1" ];
				$admin_address1 = stripslashes($address1);
				$address2 = $row0[ "address2" ];
				$admin_address2 = stripslashes($address2);
				$city = $row0[ "city" ];
				$admin_city = stripslashes($city);
				$state = $row0[ "state" ];
				$admin_state = stripslashes($state);
				$admin_zip = $row0[ "zip" ];
				$country = $row0[ "country" ];
				$admin_country = stripslashes($country);
				$admin_phone = $row0[ "phone" ];
				$admin_phone_alt = $row0[ "phone_alt" ];
				$admin_fax = $row0[ "fax" ];
				$admin_email = $row0[ "email" ];
				$site_logo = $row0[ "logo" ];
				
				$address = $admin_address1;
				if ($admin_address2 != '') {
					$address .= "<br />" . $admin_address2;
				}
				
				$logos = $web_path . $site_logo;
			
				$SQL7 = " SELECT id, name, email, permissions FROM ttcm_user WHERE type = '1' ";
				$retid7 = $db_q($db, $SQL7, $cid);
			
				while ( $row7 = $db_f($retid7) ) {
					$admins_name = $row7[ "name" ];
					$admins_id = $row7[ "id" ];
					$admins_name = stripslashes($admins_name);
					$admins_email = $row7[ "email" ];
					$admin_perms = $row7[ "permissions" ];
					$email_perms = split(',', $admin_perms);

					if ( ($admins_email != '') && (in_array("98", $email_perms)) ) {
						
						$SQL1 = "SELECT message_title, verify_id FROM ttcm_messages WHERE message_id = '" . $_POST['mid'] . "'";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$message_title = stripslashes($row1[ 'message_title' ]);
						$verify_id = $row1[ "verify_id" ];
						
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logos . "\" border=\"0\" alt=\"" . $admin_company . "\" /></a>";
						$message_link = $web_path . "message.php";
						$reply = $message_link . "?mid=" . $_POST['mid'] . "&id=" . $admins_id . "&vid=" . $verify_id;
						$reply_link = "<a href=\"" . $reply . "\">Reply to \"" . $message_title . "\"</a>";

						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '5' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = $the_client[ "company" ];
						
						$subject = str_replace('[company]', $admin_company, $subject);
						$subject = str_replace('[message title]', $message_title, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$message = str_replace('[company]', $admin_company, $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $admins_name, $message);
						$message = str_replace('[message title]', $message_title, $message);
						$message = str_replace('[message reply]', $strip_comment, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $admin_city, $message);
						$message = str_replace('[state]', $admin_state, $message);
						$message = str_replace('[zip]', $admin_zip, $message);
						$message = str_replace('[phone]', $admin_phone, $message);
						$message = str_replace('[alternate phone]', $admin_phone_alt, $message);
						$message = str_replace('[website]', $admin_website, $message);
						$message = str_replace('[web path]', $web_link, $message);
						$message = str_replace('[reply link]', $reply_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $admin_company . "\" <" . $admin_email . ">\r\n";
					
						mail("\"$admins_name\" <$admins_email>",$subject,$message,$headers);
					}
				}
				
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// CHANGE PASSWORD
	case changepw:
	
		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
    
		include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
		
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			$encpassword = md5($_POST['newpassword']);
			$vid = $_SESSION['valid_id'];
			
			$SQL = " UPDATE ttcm_user SET password = '" . $encpassword . "' WHERE id = '" . $vid . "' ";
			$result = $db_q($db,"$SQL",$cid);
				
			// SEND EMAIL TO USER

			if ($_SESSION['client_email'] != '') {
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '8' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $_SESSION[client_name], $message);
						$message = str_replace('[password]', $_POST['newpassword'], $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[web path]', $web_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$_SESSION[client_name]\" <$_SESSION[client_email]>",$subject,$message,$headers);
		
				echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $RESULT_PWCHANGED . ". " . $RESULT_EMAILCONF . " " . $_SESSION['client_email'] . ".</div>");
			$showform = 0;
			}
	 		else {
				echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $RESULT_PWCHANGED . ".</div>");
				$showform = 0;
			}
		}
	break;
	
	// CHANGE USER INFO
	case usermod:
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		
		global $cid, $db_q, $db_c, $db_f, $db, $web_path;
    
		include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
		include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
			
			$_SESSION['client_name'] = $_POST['new_name'];
			$_SESSION['user_address1'] = $_POST['new_user_address1'];
			$_SESSION['user_address2'] = $_POST['new_user_address2'];
			$_SESSION['user_city'] = $_POST['new_user_city'];
			$_SESSION['user_state'] = $_POST['new_user_state'];
			$_SESSION['user_zip'] = $_POST['new_user_zip'];
			$_SESSION['user_country'] = $_POST['new_user_country'];
			$_SESSION['user_phone'] = $_POST['new_user_phone'];
			$_SESSION['user_phone_alt'] = $_POST['new_user_phone_alt'];
			$_SESSION['user_fax'] = $_POST['new_user_fax'];
			$_SESSION['client_email'] = $_POST[ 'new_email' ];
			$_SESSION['aim_im'] = $_POST[ 'new_aim' ];
			$_SESSION['msn_im'] = $_POST[ 'new_msn' ];
			$_SESSION['yahoo_im'] = $_POST[ 'new_yahoo' ];
			$_SESSION['icq_im'] = $_POST[ 'new_icq' ];
			$_SESSION['skype_im'] = $_POST[ 'new_skype' ];
			
			$name = addslashes($_POST['new_name']);
			$address1 = addslashes($_POST['new_user_address1']);
			$address2 = addslashes($_POST['new_user_address2']);
			$city = addslashes($_POST['new_user_city']);
			$state = addslashes($_POST['new_user_state']);
			$country = addslashes($_POST['new_user_country']);

			$SQL = " UPDATE ttcm_user SET name = '" . $name . "', aim = '" . $_POST['new_aim'] . "', icq = '" . $_POST['new_icq'] . "', 
			msn = '" . $_POST['new_msn'] . "', yahoo = '" . $_POST['new_yahoo'] . "', skype = '" . $_POST['new_skype'] . "', email = '" . $_POST['new_email'] . "', 
			address1 = '" . $address1 . "', address2 = '" . $address2 . "', city = '" . $city . "', state = '" . $state . "', zip = '" . $_POST['new_user_zip'] . "', 
			country = '" . $country . "', phone = '" . $_POST['new_user_phone'] . "', phone_alt = '" . $_POST['new_user_phone_alt'] . "', fax = '" . $_POST['new_user_fax'] . "' 
			WHERE id = '" . $_POST['vid'] . "' ";
			$result = $db_q($db,"$SQL",$cid);
				
				// SEND EMAIL TO USER
				if ($_POST['old_email'] != '') { 
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '10' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $_SESSION[client_name], $message);
						$message = str_replace('[aim]', $_POST['new_aim'], $message);
						$message = str_replace('[msn]', $_POST['new_msn'], $message);
						$message = str_replace('[yahoo]', $_POST['new_yahoo'], $message);
						$message = str_replace('[icq]', $_POST['new_icq'], $message);
						$message = str_replace('[skype]', $_POST['new_skype'], $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[web path]', $web_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$_POST[new_name]\" <$_POST[old_email]>",$subject,$message,$headers);
				}
	
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '10' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $_SESSION[client_name], $message);
						$message = str_replace('[aim]', $_POST['new_aim'], $message);
						$message = str_replace('[msn]', $_POST['new_msn'], $message);
						$message = str_replace('[yahoo]', $_POST['new_yahoo'], $message);
						$message = str_replace('[icq]', $_POST['new_icq'], $message);
						$message = str_replace('[skype]', $_POST['new_skype'], $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[web path]', $web_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$_POST[new_name]\" <$_POST[new_email]>",$subject,$message,$headers);

			echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $RESULT_USERSAVED . ".</div>");
			$showform = "0";
	}
	break;
	
	case uploadc:
	// UPLOAD CLIENT FILE
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		
		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
    
		include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
		include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );

		$get_perm_vars = $_SESSION['perm_vars'];
		$user_perms = split(',', $get_perm_vars);
		$date_format = $_SESSION['date_format'];
		
		if ($_POST['file']['size'] != '0') {
		
			$client_id = $_SESSION['client_id'];
			$pid = $_POST['pid'];
			$file_name = $_FILES['file']['name'];
		
			if ( ini_get('safe_mode') ) {
			
				$file_name = $_FILES['file']['name'];
				$path = $home_dir . "clientdir/ul";
				$ulfile = $path . "/" . $client_id . "_" . basename($_FILES['file']['name']);
			
				// check file format
				$extension_array = explode (".", $file_name);
				$extension_count = (count($extension_array) - 1);
				$extension_raw = $extension_array[$extension_count];
				$extension = strtolower($extension_raw);
		
				$get_ext_vars = $_SESSION['allowed_ext'];
				$ext_perms = split(',', $get_ext_vars);
					
				if (!in_array($extension, $ext_perms)) {
					echo ("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $extension . " documento náo permitido</div><br />");
					$showform = "0";
				}
				else {
			
					if(move_uploaded_file($_FILES['file']['tmp_name'], $ulfile)) {
		
						$added = date("Y-m-d");
						$newfile_name = $client_id . "_" . basename($_FILES['file']['name']);
						$link = "clientdir/ul/" . $newfile_name;
		
						if (!isset($_POST['file_title'])) {
							$file_title = $COMMON_UNTITLED . ": " . $file_name;
							$strip_title = $file_title;
						}
						else {
							$file_title = $_POST['file_title'];
							$strip_title = stripslashes($_POST['file_title']);
						}
			
						$SQL = " INSERT INTO ttcm_cfiles (client_id, project_id, file, name, link, added) VALUES ('$client_id','$pid','$file_name','$file_title','$link','$added') ";
						$result = $db_q($db,"$SQL",$cid);

						$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE type = '1' ";
						$retid7 = $db_q($db, $SQL7, $cid);
		
						while ( $row7 = $db_f($retid7) ) {
							$admins_name = $row7[ "name" ];
							$admins_name = stripslashes($admins_name);
							$admins_email = $row7[ "email" ];
							$admin_perms = $row7[ "permissions" ];
							$email_perms = split(',', $admin_perms);

							if ( ($admins_email != '') && (in_array("99", $email_perms)) ) {
				
								$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
								$logo = $web_path . $_SESSION['site_logo'];
								$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
					
								// GET CSS TEMPLATE
								$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
								$retid1 = $db_q($db, $SQL1, $cid);
								$row1 = $db_f($retid1);
								$todo_css = $row1[ "htmltext" ];
						
								// OBTER MODELOS DE E-MAIL
								$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '11' ";
								$retid4 = $db_q($db, $SQL4, $cid);
								$row4 = $db_f($retid4);
								$subject = $row4[ "subject" ];
								$todo_message = $row4[ "htmltext" ];
						
								// GET PROJECT TITLE
								$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $pid . "'";
								$retid = $db_q($db, $SQL, $cid);
								$the_proj = $db_f( $retid );
								$project = stripslashes($the_proj[ 'title' ]);
						
								// GET COMPANY NAME
								$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $client_id . "'";
								$retid2 = $db_q($db, $SQL2, $cid);
								$the_client = $db_f( $retid2 );
								$client_name = stripslashes($the_client[ 'company' ]);
						
								$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
								$subject = str_replace('[file title]', $strip_title, $subject);
								$subject = str_replace('[client name]', $client_name, $subject);
						
								$message = $todo_css;
								$message .= $todo_message;
						
								$address = $_SESSION['admin_address1'];
								if ($_SESSION['admin_address2'] != '') {
									$address .= "<br />" . $_SESSION['admin_address2'];
								}
						
								$message = str_replace('[company]', $_SESSION[admin_company], $message);
								$message = str_replace('[logo]', "$logo_link", $message);
								$message = str_replace('[user name]', $users_name, $message);
								$message = str_replace('[file title]', $file_title, $message);
								$message = str_replace('[address]', $address, $message);
								$message = str_replace('[city]', $_SESSION['admin_city'], $message);
								$message = str_replace('[state]', $_SESSION['admin_state'], $message);
								$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
								$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
								$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
								$message = str_replace('[website]', $_SESSION['admin_website'], $message);
								$message = str_replace('[project title]', $project, $message);
								$message = str_replace('[client name]', $client_name, $message);
								$message = str_replace('[web path]', $web_link, $message);
						
								$headers  = "MIME-Version: 1.0\n";
								$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

								$headers .= "From: \"" . $_SESSION['client_name'] . "\" <" . $_SESSION['client_email'] . ">\r\n";
					
								mail("\"$admins_name\" <$admins_email>",$subject,$message,$headers);
							}
						}
				
						echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $COMMON_FILE . " \"" . $newfile_name . "\" " . $RESULT_ADDED . ".</div>");
					} 
					else {
						echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $RESULT_ERROR . ".</div>");
					}
				}
			}
			else {
	
			$path = $home_dir . "clientdir/" . $client_id . "/ul";
			$ulfile = $path . "/" . basename($_FILES['file']['name']);
			$file_name = $_FILES['file']['name'];
		
			// check file format
			$extension_array = explode (".", $file_name);
			$extension_count = (count($extension_array) - 1);
			$extension_raw = $extension_array[$extension_count];
			$extension = strtolower($extension_raw);
		
			$get_ext_vars = $_SESSION['allowed_ext'];
			$ext_perms = split(',', $get_ext_vars);
					
			if (!in_array($extension, $ext_perms)) {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $extension . " documento náo permitido</div><br />");
				$showform = "0";
			}
			else {
					
				if(move_uploaded_file($_FILES['file']['tmp_name'], $ulfile)) {
		
					$added = date("Y-m-d");
					$link = "clientdir/" . $client_id . "/ul/" . $file_name;
		
					if ($_POST['file_title'] == '') {
						$file_title = $COMMON_UNTITLED . ": " . $file_name;
						$strip_title = $file_title;
					}
					else {
						$file_title = addslashes($_POST['file_title']);
						$strip_title = stripslashes($_POST['file_title']);
					}
			
					$SQL = " INSERT INTO ttcm_cfiles (client_id, project_id, file, name, link, added) VALUES ('$client_id','$pid','$file_name','$file_title','$link','$added') ";
					$result = $db_q($db,"$SQL",$cid);

					$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE type = '1' ";
					$retid7 = $db_q($db, $SQL7, $cid);
		
					while ( $row7 = $db_f($retid7) ) {
						$admins_name = $row7[ "name" ];
						$admins_name = stripslashes($admins_name);
						$admins_email = $row7[ "email" ];
						$admin_perms = $row7[ "permissions" ];
						$email_perms = split(',', $admin_perms);

						if ( ($admins_email != '') && (in_array("99", $email_perms)) ) {
					
							$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
							$logo = $web_path . $_SESSION['site_logo'];
							$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						
							$file_links = $web_path . $link;
							$file_link = "<a href=\"" . $file_links . "\">" . $file_name . "</a>";

							// GET CSS TEMPLATE
							$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
							$retid1 = $db_q($db, $SQL1, $cid);
							$row1 = $db_f($retid1);
							$todo_css = $row1[ "htmltext" ];
						
							// OBTER MODELOS DE E-MAIL
							$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '11' ";
							$retid4 = $db_q($db, $SQL4, $cid);
							$row4 = $db_f($retid4);
							$subject = $row4[ "subject" ];
							$todo_message = $row4[ "htmltext" ];
						
							// GET PROJECT TITLE
							$SQL = "SELECT title FROM ttcm_project WHERE project_id = '" . $pid . "'";
							$retid = $db_q($db, $SQL, $cid);
							$the_proj = $db_f( $retid );
							$project = stripslashes($the_proj[ 'title' ]);
						
							// GET COMPANY NAME
							$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $client_id . "'";
							$retid2 = $db_q($db, $SQL2, $cid);
							$the_client = $db_f( $retid2 );
							$client_name = stripslashes($the_client[ 'company' ]);
						
							$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
							$subject = str_replace('[file title]', $strip_title, $subject);
							$subject = str_replace('[client name]', $client_name, $subject);
						
							$message = $todo_css;
							$message .= $todo_message;
						
							$address = $_SESSION['admin_address1'];
							if ($_SESSION['admin_address2'] != '') {
								$address .= "<br />" . $_SESSION['admin_address2'];
							}
						
							$message = str_replace('[company]', $_SESSION[admin_company], $message);
							$message = str_replace('[logo]', "$logo_link", $message);
							$message = str_replace('[user name]', $admins_name, $message);
							$message = str_replace('[file title]', $strip_title, $message);
							$message = str_replace('[file link]', $file_link, $message);
							$message = str_replace('[address]', $address, $message);
							$message = str_replace('[city]', $_SESSION['admin_city'], $message);
							$message = str_replace('[state]', $_SESSION['admin_state'], $message);
							$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
							$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
							$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
							$message = str_replace('[website]', $_SESSION['admin_website'], $message);
							$message = str_replace('[project title]', $project, $message);
							$message = str_replace('[client name]', $client_name, $message);
							$message = str_replace('[web path]', $web_link, $message);
						
							$headers  = "MIME-Version: 1.0\n";
							$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

							$headers .= "From: \"" . $_SESSION['client_name'] . "\" <" . $_SESSION['client_email'] . ">\r\n";
					
							mail("\"$admins_name\" <$admins_email>",$subject,$message,$headers);
						}
					}
					echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp;" . $COMMON_FILE . " \"" . $file_name . "\" " . $RESULT_ADDED . ".</div>");
				} 
				else {
					echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $RESULT_ERROR . ".</div>");
				}
			}
		}
		}
		else {
			$added = date("Y-m-d");
		
			if ($_POST['file_title'] == '') {
				$file_title = $COMMON_UNTITLED . ": " . $file_name;
				$strip_title = $file_title;
			}
			else {
				$file_title = $_POST['file_title'];
				$strip_title = stripslashes($_POST['file_title']);
			}
				
			$link = $_POST['input_link'];
		
			$SQL = " INSERT INTO ttcm_cfiles (client_id, project_id, file, name, link, added) VALUES ('$client_id','$pid','$file_name','$file_title','$link','$added') ";
			$result = $db_q($db,"$SQL",$cid);
		
			$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE type = '1' ";
			$retid7 = $db_q($db, $SQL7, $cid);
		
			while ( $row7 = $db_f($retid7) ) {
				$admins_name = $row7[ "name" ];
				$admins_name = stripslashes($admins_name);
				$admins_email = $row7[ "email" ];
				$admin_perms = $row7[ "permissions" ];
				$email_perms = split(',', $admin_perms);

				if ( ($admins_email != '') && (in_array("99", $email_perms)) ) {
					
					$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
					$logo = $web_path . $_SESSION['site_logo'];
					$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						
						$file_links = $web_path . $link;
						$file_link = "<a href=\"" . $file_links . "\">" . $file_name . "</a>";

						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '11' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE project_id = '" . $pid . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = stripslashes($the_proj[ 'title' ]);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $client_id . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[file title]', $strip_title, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', "$logo_link", $message);
						$message = str_replace('[user name]', $admins_name, $message);
						$message = str_replace('[file title]', $strip_title, $message);
						$message = str_replace('[file link]', $link, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[project title]', $project, $message);
						$message = str_replace('[client name]', $client_name, $message);
						$message = str_replace('[web path]', $web_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['client_name'] . "\" <" . $_SESSION['client_email'] . ">\r\n";
					
						mail("\"$admins_name\" <$admins_email>",$subject,$message,$headers);
				}
			}
			echo("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp;" . $COMMON_FILE . " \"" . $strip_title . "\" " . $RESULT_ADDED . ".</div>");
		} 
	}
	break;
	
	// EDIT CLIENT
	case savecinfo:
	
		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
    
		include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
		include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
		
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD']=="POST") {
	
			$SQL = " UPDATE ttcm_client SET company = '" . $_POST['new_client_company'] . "', address1 = '" . $_POST['new_address1'] . "', address2 = '" . $_POST['new_address2'] . "', city = '" . $_POST['new_city'] . "', state = '" . $_POST['new_state'] . "', zip = '" . $_POST['new_zip'] . "', country = '" . $_POST['new_country'] . "', phone = '" . $_POST['new_phone'] . "', phone_alt = '" . $_POST['new_phone_alt'] . "', fax = '" . $_POST['new_fax'] . "' WHERE client_id = '" . $_POST['clid'] . "' ";
			$result = $db_q($db,"$SQL",$cid);
		
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $USER_CLIENTINFO . " " . $RESULT_SAVED . ".</div>");
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $RESULT_INVALID . ". " . $RESULT_FORMERROR . ".</div>");
		}
		break;
	
	// DELETE CLIENT UPLOADED FILE
	case delcfile:
	
		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
		
		$SQL = " SELECT link FROM ttcm_cfiles WHERE client_id = '" . $_SESSION['client_id'] . "' AND file_id = '" . $_GET['fid'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		$row = $db_f($retid);
		$file_path_orig = $row[ "link" ];
	
		$SQL2 = " DELETE FROM ttcm_cfiles WHERE client_id = '" . $_SESSION['client_id'] . "' AND file_id = '" . $_GET['fid'] . "' ";
		$db_q($db, $SQL2, $cid);
		
		$file_det = substr($file_path_orig, 0, 5);
		if ($file_det != 'http:') {
		
			$the_path = $home_dir . $file_path_orig;	
   			unlink("$the_path");
		}
		break;
		
	// ADD MESSAGE
	case addmessage:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			
			global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
			
			if ($_POST['message_title'] != '') {
	
				$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
				$logo = $web_path . $_SESSION['site_logo'];
				$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
				$now = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
				
				$rand_options = "ABCDEFGHIJKLMNOPQRSTUVWXYZabchefghjkmnpqrstuvwxyz0123456789";
			  	srand((double)microtime()*1000000); 
				$i = 0;
				while ($i <= 15) {
					$num = rand() % 33;
					$tmp = substr($rand_options, $num, 1);
					$verify = $verify . $tmp;
					$i++;
				}
				
				$message_title = addslashes($_POST['message_title']);
				$the_message = addslashes($_POST['message']);

				$SQL = " INSERT INTO ttcm_messages (client_id, project_id, message_title, message, posted, post_by, verify_id) VALUES ('$_SESSION[client_id]','$_POST[pid]','$message_title','$the_message','$now','$_POST[post_by]','$verify') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$msg_id = mysql_insert_id();
				
				if ($_POST['pid'] != '0') {
					$updated = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
					$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
					$result2 = $db_q($db,"$SQL2",$cid);
					
					$SQL3 = " UPDATE ttcm_messages SET updated = '" . $updated . "' WHERE message_id = '" . $msg_id . "' ";
					$result3 = $db_q($db,"$SQL3",$cid);
				}
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp; " . $ADDMESSAGE_ADDED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=addmsg\">" . $ADDMESSAGE_ADDMESSAGE . "</a>");
				echo ("<li><a href=\"main.php?pg=msg\">" . $ADDMESSAGE_RETURN . "</a>");
				echo ("</ul>");
			
				$SQL0 = " SELECT id, name, email, permissions FROM ttcm_user WHERE type = '1' ";
				$retid0 = $db_q($db, $SQL0, $cid);
			
				while ( $row0 = $db_f($retid0) ) {
					$admin_user_name = stripslashes($row0[ 'name' ]);
					$admin_user_email = $row0[ "email" ];
					$users_id = $row0[ "id" ];
					$admin_perms = $row0[ "permissions" ];
					$email_perms = split(',', $admin_perms);

						$strip_title = stripslashes($_POST['message_title']);
						$strip_message = stripslashes($_POST['message']);

					if ( ($admin_user_email != '') && (in_array("98", $email_perms)) ) {
						
						$verify_id = $verify;
						$message_link = $web_path . "message.php";
						$reply = $message_link . "?mid=" . $msg_id . "&id=" . $users_id . "&vid=" . $verify_id;
						$reply_link = "<a href=\"" . $reply . "\">Reply to \"" . $strip_title . "\"</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '4' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['pid'] . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = stripslashes($the_proj[ 'title' ]);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $admin_name, $subject);
						$subject = str_replace('[message title]', $strip_title, $subject);
						$subject = str_replace('[project title]', $project, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION['admin_company'], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $admin_name, $message);
						$message = str_replace('[message title]', $strip_title, $message);
						$message = str_replace('[message]', $strip_message, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[project title]', $project, $message);
						$message = str_replace('[client name]', $client_name, $message);
						$message = str_replace('[web path]', $web_link, $message);
						$message = str_replace('[reply link]', $reply_link, $message);

						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$admin_user_name\" <$admin_user_email>",$subject,$message,$headers);
					}
				}
			
				$showform = '0';
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $ADDMESSAGE_NOTITLE . "</div><br />");
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// UPDATE TO DO DONE
	case dtodo:
	
		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
		
		$todo = $_GET['todo'];
		$pid = $_GET['pid'];
		
		$SQL = " UPDATE ttcm_todo SET done = '1' WHERE todo_id = '" . $_GET['todo'] . "'";
		$result = $db_q($db,"$SQL",$cid);
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_GET['pid'] . "' ";
		$result2 = $db_q($db,"$SQL2",$cid);
		break;
	
	// UPDATE TO DO NOT DONE
	case ndtodo:

		global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;

		$SQL = " UPDATE ttcm_todo SET done = '0' WHERE todo_id = '" . $_GET['todo'] . "'";
		$result = $db_q($db,"$SQL",$cid);
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL2 = " UPDATE ttcm_project SET updated = '$updated' WHERE project_id = '" . $_GET['pid'] . "' ";
		$result2 = $db_q($db,"$SQL2",$cid);
		break;

		default:
		break;
}
?>