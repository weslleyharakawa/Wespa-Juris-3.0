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
if ($_GET['task'] != '') {
	$task = $_GET['task'];
}
else {
	$task = $_POST['task'];
}

// SWITCH FOR TASK
switch ($task) {
	
	// EDIT FILE
	case editfile:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			$file_title = addslashes($_POST['file_title']);
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );

			$SQL = " UPDATE ttcm_files SET type_id = '" . $_POST['type_id'] . "', name = '" . $file_title . "', link = '" . $_POST['link'] . "' WHERE file_id = '" . $_POST['file_id'] . "'";
			$result = $db_q($db,"$SQL",$cid);

			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $EDITFILE_UPDATED . "</div><br />");
			echo ("<p><a href=\"main.php?pg=files\">" . $NEXT_RETURNFILEMAN . "</a></p>");
		
			$showform = "0";
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// UPDATE TO DO DONE
	case dtodo:
		global $db_q, $db, $cid, $db_f;

		$SQL = " UPDATE ttcm_todo SET done = '1' WHERE todo_id = '" . $_GET['todo'] . "'";
		$result = $db_q($db,"$SQL",$cid);
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_GET['pid'] . "' ";
		$result2 = $db_q($db,"$SQL2",$cid);
		break;
	
	// UPDATE TO DO NOT DONE
	case ndtodo:
		global $db_q, $db, $cid, $db_f;

		$SQL = " UPDATE ttcm_todo SET done = '0' WHERE todo_id = '" . $_GET['todo'] . "'";
		$result = $db_q($db,"$SQL",$cid);
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_GET['pid'] . "' ";
		$result2 = $db_q($db,"$SQL2",$cid);
		break;
	
	// ADD TASK
	case addtask:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		
		$startdate = $_POST['startdate'];
		$miledate = $_POST['miledate'];
		$findate = $_POST['findate'];
		
		$stmo = substr($startdate,0,2);
		$stday = substr($startdate,3,2);
		$styr = substr($startdate,6,4);
		$start = $styr . "/" . $stmo . "/" . $stday;
			
		$mimo = substr($miledate,0,2);
		$miday = substr($miledate,3,2);
		$miyr = substr($miledate,6,4);
		$milestone = $miyr . "/" . $mimo . "/" . $miday;
			
		if ($findate != '') {
			$fmo = substr($findate,0,2);
			$fday = substr($findate,3,2);
			$fyr = substr($findate,6,4);
			$finish = $fyr . "/" . $fmo . "/" . $fday;
		}
		else {
			$finish = "0000/00/00";
		}
		
		$clid = $_POST['clid'];
		$pid = $_POST['pid'];
		$task_title = addslashes($_POST['task_title']);
		$description = addslashes($_POST['description']);
		$status = $_POST['status'];
		$notes = addslashes($_POST['notes']);
		$tuid = $_POST['tuid'];

		$SQL = " INSERT INTO ttcm_task (project_id, client_id, title, description, start, updated, status, notes, milestone, finish, assigned) 
		VALUES ('$pid','$clid','$task_title','$description','$start','$updated','$status','$notes','$milestone','$finish', '$tuid') ";
		$result = $db_q($db,"$SQL",$cid);
		
		$task_id = mysql_insert_id();

		$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		$result = $db_q($db,"$SQL2",$cid);

		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $_POST['task_title'] . "\" " . $ADDTASK_HASBEENADDED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=addtask&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_ADDTASKTPROJ . "</a>");
		echo ("<li><a href=\"main.php?pg=addtask\">" . $NEXT_ADDTASKNPROJ . "</a>");
		echo ("<li><a href=\"main.php?pg=addfiles&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_ADDFILETPROJ . "</a>");
		echo ("<li><a href=\"main.php?pg=addproj\">" . $NEXT_ADDPROJNCL . "</a>");
		echo ("<li><a href=\"main.php?pg=addproj&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_ADDPROJTCL . "</a>");
		echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
		echo ("</ul></p>");
		
		$showform = "0";
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
// ADD TO DO ITEM
		case addtodo:
			// CHECK TO ENSURE FORM WAS PROCESSED
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				
				include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
				include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
				
				global $db_q, $db, $cid, $db_f, $db_c, $web_path;
				
				$duedate = $_POST['duedate'];
				$todo_link = $_POST['todo_link'];
			
				$due_mo = substr($duedate,0,2);
				$due_day = substr($duedate,3,2);
				$due_yr = substr($duedate,6,4);
				
				$due_yr_short = substr($due_yr,2,2);
			
				$deadline = $due_yr . "/" . $due_mo . "/" . $due_day;
				
				if ($_SESSION['date_format'] == '%c/%e/%Y') {
					$email_date = $due_mo . "/" . $due_day . "/" . $due_yr;
				}
				else if ($_SESSION['date_format'] == '%e/%c/%Y' ) {
					$email_date = $due_day . "/" . $due_mo . "/" . $due_yr;
				}
				else if ($_SESSION['date_format'] == '%Y/%c/%e' ) {
					$email_date = $due_yr . "/" . $due_mo . "/" . $due_day;
				}
				else if ($_SESSION['date_format'] == '%c/%e/%y' ) {
					$email_date = $due_mo . "/" . $due_day . "/" . $due_yr_short;
				}
				else if ($_SESSION['date_format'] == '%e/%c/%y' ) {
					$email_date = $due_day . "/" . $due_mo . "/" . $due_yr_short;
				}
				else if ($_SESSION['date_format'] == '%y/%c/%e' ) {
					$email_date = $due_yr_short . "/" . $due_mo . "/" . $due_day;
				}
				
				$todo_item = addslashes($_POST['item']);
				
				if ( ( $todo_link == "http://" ) || ( $todo_link == '' ) ) {
					$todo_link = '';
				}
				
				$clid = $_POST['clid'];

				$SQL = " INSERT INTO ttcm_todo (client_id, project_id, item, deadline, link) VALUES ('$clid','$_POST[pid]','$todo_item','$deadline', '$todo_link') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
				$SQL3 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
				$result3 = $db_q($db,"$SQL3",$cid);
				
				$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE client_id = '" . $clid . "' ";
				$retid7 = $db_q($db, $SQL7, $cid);
				$number = $db_c( $retid7 );
				
				$admin_sent = 0;

				while ( $row7 = $db_f($retid7) ) {
					
					$users_name = stripslashes($row7[ 'name' ]);
					$users_email = $row7[ "email" ];
					$user_perms = $row7[ "permissions" ];
					$email_perms = split(',', $user_perms);

					if ( ($users_email != '') && (in_array("92", $email_perms)) ) {
						
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '2' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['pid'] . "'";
						$retid3 = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid3 );
						$project = stripslashes($the_proj[ 'title' ]);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$strip_item = stripslashes($_POST['item']);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[todo item]', $strip_item, $subject);
						$subject = str_replace('[deadline]', $email_date, $subject);
						$subject = str_replace('[project title]', $project, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $users_name, $message);
						$message = str_replace('[todo item]', $strip_item, $message);
						$message = str_replace('[deadline]', $email_date, $message);
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

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
					}
				}	

				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDTODO_ADDED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=addtodo&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_ADDTODOTPROJ . "</a>");
				echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
				echo ("</ul></p>");
				
				$showform = "0";
				}
				else {
					echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
				}
				break;
		
	// ADD LINK
	case addlink:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$link_title = addslashes($_POST['link_title']);
			$link_desc = addslashes($_POST['link_desc']);
			
			$SQL = " INSERT INTO ttcm_links (client_id, link_title, link_desc, link) VALUES ('$_POST[client_id]','$link_title','$link_desc','$_POST[link]') ";
			$result = $db_q($db,"$SQL",$cid);
		
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDLINK_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addlink&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_ADDLINKTCL . "</a>");
			echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_RETURNTCL . "</a>.");
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD WEBSITE
	case addwebsite:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$SQL = " INSERT INTO ttcm_websites (client_id, website) VALUES ('$_POST[client_id]','$_POST[website]') ";
			$result = $db_q($db,"$SQL",$cid);
		
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDWEBSITE_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addwebsite&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_ADDWEBTCL . "</a>");
			if ($_POST['client_id'] != '0') {
				echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_RETURNTCL . "</a>");
			}
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// ADD HELP CATEGORY
	case addhelpcat:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$new_category = addslashes($_POST['category']);
			
			$SQL = "INSERT INTO ttcm_helpcat (category) VALUES ('$new_category') ";
			$result = $db_q($db,"$SQL",$cid);
	
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $new_category . "\" " . $COMMON_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addhelpcat\">" . $NEXT_ADDHELPCAT . "</a>");
			echo ("<li><a href=\"main.php?pg=addtopic\">" . $NEXT_ADDHELPTOPIC . "</a>");
			echo ("<li><a href=\"main.php?pg=help\">" . $NEXT_RETURNHELP . "</a>");
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD FILE
	case addfile:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			global $db_q, $db, $cid, $db_f, $home_dir, $web_path;
			
			$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
				$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $_SESSION['site_logo'] . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
				
						$admin_company = $_SESSION['admin_company'];
						$admin_website = $_SESSION['admin_website'];
						$site_logo = $_SESSION['site_logo'];
						$admin_address1 = $_SESSION['admin_address1'];
						$admin_city = $_SESSION['admin_city'];
						$admin_state = $_SESSION['admin_state'];
						$admin_zip = $_SESSION['admin_zip'];
						$admin_phone = $_SESSION['admin_phone'];
						$admin_website = $_SESSION['admin_website'];
						$admin_phone_alt =  $_SESSION['admin_phone_alt'];
	
			if ($_FILES['file']['size'] != '0') {
				
				if ( ini_get('safe_mode') ) {
					
					$file_name = $_FILES['file']['name'];
					$path = $home_dir . "clientdir/dl";
					$ulfile = $path . "/" . basename($_FILES['file']['name']);
					
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
						
						$file_name = $_FILES['file']['name'];
						$added = date("Y-m-d", time() + $_SESSION['serverdiff'] * 60 * 60);
						$link = "clientdir/dl/" . $file_name;
						$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
						
						if ($_POST['file_title'] == '') {
							$file_title = $COMMON_UNTITLED . ": " . $file_name;
						}
						else {
							$file_title = addslashes($_POST['file_title']);
						}
			
						$SQL = " INSERT INTO ttcm_files (client_id, type_id, project_id, file, name, link, added, task_id) VALUES ('$_POST[clid]','$_POST[type_id]','$_POST[project_id]','$file_name','$file_title','$link','$added','$_POST[task_id]') ";
						$result = $db_q($db,"$SQL",$cid);
		
						$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['project_id'] . "' ";
						$result2 = $db_q($db,"$SQL2",$cid);
						
						$SQL7 = " SELECT email, name, permissions FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
						$retid7 = $db_q($db, $SQL7, $cid);
						
						$admin_sent = 0;

						while ( $row7 = $db_f($retid7) ) {
						$users_name = stripslashes($row7[ "name" ]);
						$users_email = $row7[ "email" ];
						$user_perms = $row7[ "permissions" ];
						$email_perms = split(',', $user_perms);

					if ( ($users_email != '') && (in_array("93", $email_perms)) ) {
						
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
							
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '3' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['project_id'] . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = stripslashes($the_proj[ 'title' ]);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$strip_title = stripslashes($_POST['file_title']);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[file title]', $strip_title, $subject);
						$subject = str_replace('[project title]', $project, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $users_name, $message);
						$message = str_replace('[file title]', $strip_title, $message);
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

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
						}
						}

						echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $file_name . " " . $COMMON_ADDED . "</div>");
						echo ("<br /><ul class=\"circle\">");
						if ($_POST['project_id'] != '0') {
							echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['project_id'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
						}
						echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
						echo ("</ul>");
						
						$showform = "0";
					}
					else {
						echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_ERROR . "</div><br />");
					}
				}
				
				}
				else {
					$file_name = $_FILES['file']['name'];
					$path = $home_dir . "clientdir/" . $_POST['clid'] . "/dl";
					$ulfile = $path . "/" . basename($_FILES['file']['name']);
					
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
						
						if ($_POST['file_title'] == '') {
							$file_title = $COMMON_UNTITLED . ": " . $file_name;
						}
						else {
							$file_title = addslashes($_POST['file_title']);
						}
					
					$file_name = $_FILES['file']['name'];
		
					$added = date("Y-m-d", time() + $_SESSION['serverdiff'] * 60 * 60);
					$link = "clientdir/" . $_POST['clid'] . "/dl/" . $file_name;
					$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
			
					$SQL = " INSERT INTO ttcm_files (client_id, type_id, project_id, file, name, link, added, task_id) VALUES ('$_POST[clid]','$_POST[type_id]','$_POST[project_id]','$file_name','$file_title','$link','$added','$_POST[task_id]') ";
					$result = $db_q($db,"$SQL",$cid);
		
					$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
					$result2 = $db_q($db,"$SQL2",$cid);
					
					$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
					$retid7 = $db_q($db, $SQL7, $cid);
					
					$admin_sent = 0;

					while ( $row7 = $db_f($retid7) ) {
					$users_name = stripslashes($row7[ "name" ]);
					$users_email = $row7[ "email" ];
					$user_perms = $row7[ "permissions" ];
					$email_perms = split(',', $user_perms);

					if ( ($users_email != '') && (in_array("93", $email_perms)) ) {
						
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '3' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['project_id'] . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = stripslashes($the_proj[ 'title' ]);
						$strip_title = stripslashes($file_title);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[file title]', $strip_title, $subject);
						$subject = str_replace('[project title]', $project, $subject);
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
						$message = str_replace('[file title]', $strip_title, $message);
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

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
					} 
					}

					echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $file_name . " " . $COMMON_ADDED . "</div>");
					echo ("<br /><ul class=\"circle\">");
					echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['project_id'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
					echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
					echo ("</ul>");
						
					$showform = "0";
					}
					else {
						echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_ERROR . "</div><br />");
					}
				}
			}
			}
			else { 
				$file_name = $_FILES['file']['name'];
				$added = date("Y-m-d", time() + $_SESSION['serverdiff'] * 60 * 60);
				$due = $year . "/" . $month . "/" . $day;
				$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
				
				if ($_POST['file_title'] == '') {
					$file_title = $COMMON_UNTITLED . ": " . $file_name;
				}
				else {
					$file_title = addslashes($_POST['file_title']);
				}
			
				$SQL = " INSERT INTO ttcm_files (client_id, type_id, project_id, file, name, link, added, task_id) VALUES ('$_POST[clid]','$_POST[type_id]','$_POST[project_id]','$file_name','$file_title','$_POST[input_link]','$added','$_POST[task_id]') ";
				$result = $db_q($db,"$SQL",$cid);

				$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['project_id'] . "' ";
				$result2 = $db_q($db,"$SQL2",$cid);
				
				$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
				$retid7 = $db_q($db, $SQL7, $cid);
				
				$admin_sent = 0;

				while ( $row7 = $db_f($retid7) ) {
					$users_name = stripslashes($row7[ "name" ]);
					$users_email = $row7[ "email" ];
					$user_perms = $row7[ "permissions" ];
					$email_perms = split(',', $user_perms);

					if ( ($users_email != '') && (in_array("93", $email_perms)) ) {
						
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
					
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '3' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET PROJECT TITLE
						$SQL = "SELECT title FROM ttcm_project WHERE client_id = '" . $_POST['project_id'] . "'";
						$retid = $db_q($db, $SQL, $cid);
						$the_proj = $db_f( $retid );
						$project = stripslashes($the_proj[ 'title' ]);
						$strip_title = stripslashes($file_title);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[file title]', $strip_title, $subject);
						$subject = str_replace('[project title]', $project, $subject);
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
						$message = str_replace('[file title]', $strip_title, $message);
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

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
				}
				}
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $file_title . " " . $COMMON_ADDED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['project_id'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
				echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
				echo ("</ul></p>");
						
				$showform = "0";
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// ADD TOPIC
	case addtopic:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$topic = addslashes($_POST['topic']);
			$description = addslashes($_POST['description']);

			$SQL = " INSERT INTO ttcm_topics (cat_id, topic, description) VALUES ('$_POST[cat_id]','$topic','$description') ";
			$result = $db_q($db,"$SQL",$cid);
			echo mysql_error();
			
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $_POST['topic'] . "\" " . $COMMON_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addtopic\">" . $NEXT_ADDHELPTOPIC . "</a>");
			echo ("<li><a href=\"main.php?pg=addhelpcat\">" . $NEXT_ADDHELPCAT . "</a>");
			echo ("<li><a href=\"main.php?pg=help\">" . $NEXT_RETURNHELP . "</a>");
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// ADD MESSAGE
	case addmessage:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			if ($_POST['message_title'] != '') {
				
				$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
				$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $_SESSION['site_logo'] . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
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

				$SQL = " INSERT INTO ttcm_messages (client_id, project_id, message_title, message, posted, post_by, verify_id) VALUES ('$_POST[clid]','$_POST[pid]','$message_title','$the_message','$now','$_POST[post_by]','$verify') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$msg_id = mysql_insert_id();
				
				if ($_POST['pid'] != '0') {
					$updated = date("Y/m/d G:i:s", time() + $_SESSION[serverdiff] * 60 * 60);
					$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
					$result2 = $db_q($db,"$SQL2",$cid);
					
					$SQL3 = " UPDATE ttcm_messages SET updated = '" . $updated . "' WHERE message_id = '" . $msg_id . "' ";
					$result3 = $db_q($db,"$SQL3",$cid);
				}
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDMESSAGE_ADDED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=addmsg\">" . $NEXT_ADDMESSAGE . "</a>");
				echo ("<li><a href=\"main.php?pg=msg\">" . $NEXT_RETURNMESSAGE . "</a>");
				echo ("</ul></p>");
			
				$SQL7 = " SELECT id, name, email, permissions FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
				$retid7 = $db_q($db, $SQL7, $cid);
				
				$admin_sent = 0;
				
				$strip_title = stripslashes($_POST['message_title']);
				$strip_message = stripslashes($_POST['message']);
			
				while ( $row7 = $db_f($retid7) ) {
					$users_name = stripslashes($row7[ 'name' ]);
					$users_email = $row7[ "email" ];
					$users_id = $row7[ "id" ];
					$user_perms = $row7[ "permissions" ];
					$email_perms = split(',', $user_perms);

					if ( ($users_email != '') && (in_array("94", $email_perms)) ) {
						
						$verify_id = $verify;
						$message_link = $web_path . "message.php";
						$reply = $message_link . "?mid=" . $msg_id . "&id=" . $users_id . "&vid=" . $verify_id;
						$reply_link = "<a href=\"" . $reply . "\">Reply to \"" . $strip_title . "\"</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						
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
						$subject = str_replace('[user name]', $users_name, $subject);
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
						$message = str_replace('[user name]', $users_name, $message);
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
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
					}
				}
			
				$showform = '0';
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $ADDMESSAGE_NOTITLE . "</div><br />");
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD MESSAGE REPLY
	case addquickreply:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	
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
			
				$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
				$retid7 = $db_q($db, $SQL7, $cid);
				
				$admin_sent = 0;
			
				while ( $row7 = $db_f($retid7) ) {
					$users_name = stripslashes($row7[ 'name' ]);
					$users_email = $row7[ "email" ];
					$users_perms = $row7[ "permissions" ];
					$email_perms = split(',', $users_perms);

					if ( ($users_email != '') && (in_array("95", $email_perms)) ) {
						
						$SQL1 = "SELECT message_title, verify_id FROM ttcm_messages WHERE message_id = '" . $_POST['mid'] . "'";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$message_title = $row1[ "message_title" ];
						$strip_title = stripslashes($message_title);
						$verify_id = $row1[ "verify_id" ];
						
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
						$message_link = $web_path . "message.php";
						$reply = $message_link . "?mid=" . $_POST['mid'] . "&id=" . $_SESSION['valid_id'] . "&vid=" . $verify_id;
						$reply_link = "<a href=\"" . $reply . "\">Reply to \"" . $strip_title . "\"</a>";

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
						$project = stripslashes($the_proj[ 'title' ]);
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[message title]', $strip_title, $subject);
						$subject = str_replace('[project title]', $project, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$strip_comment = stripslashes($_POST['comment']);
						
						$message = str_replace('[company]', $_SESSION['admin_company'], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $users_name, $message);
						$message = str_replace('[message title]', $strip_title, $message);
						$message = str_replace('[message reply]', $strip_comment, $message);
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
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);

					}
				}
			
				$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// ADD NOTE
	case addnote:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			global $db_q, $db, $cid, $db_f;
			
			$note = addslashes($_POST['note']);

			$SQL = " INSERT INTO ttcm_notes (client_id, project_id, note) VALUES ('$_POST[clid]','$_POST[pid]','$note') ";
			$result = $db_q($db,"$SQL",$cid);

			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDNOTE_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addnotes&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_ADDNOTETCL . "</a>");
			echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// ADD PROJECT
	case addproject:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	
			$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
			
			$startdate = $_POST['startdate'];
			$miledate = $_POST['miledate'];
			$findate = $_POST['findate'];
			
			$stmo = substr($startdate,0,2);
			$stday = substr($startdate,3,2);
			$styr = substr($startdate,6,4);
			$start = "$styr/$stmo/$stday";
			
			$mimo = substr($miledate,0,2);
			$miday = substr($miledate,3,2);
			$miyr = substr($miledate,6,4);
			$milestone = "$miyr/$mimo/$miday";
			
			if ($findate != '') {
				$fmo = substr($findate,0,2);
				$fday = substr($findate,3,2);
				$fyr = substr($findate,6,4);
				$finish = "$fyr/$fmo/$fday";
			}
			else {
				$finish = "0000/00/00";
			}
		
			if ( $_POST['project_title'] == '' ) {
				$project_title = $COMMON_UNTITLED;
				$strip_title = $project_title;
			}
			else {
				$project_title = addslashes($_POST['project_title']);
				$strip_title = stripslashes($_POST['project_title']);
			}
			
			if ($_SESSION['valid_id'] != '1') {
				$puser_perms = '1,' . $_SESSION['valid_id'];
			}
			else {
				$puser_perms = '1';
			}

			$description = addslashes($_POST['description']);

			$SQL = " INSERT INTO ttcm_project (client_id, title, description, start, updated, status, cost, milestone, finish, permissions) 
			VALUES ('$_POST[client_id]','$project_title','$description','$start','$updated','$_POST[status]','$_POST[cost]','$milestone','$finish','$puser_perms') ";
			$result = $db_q($db,"$SQL",$cid);	
		
			$project_id = mysql_insert_id();
			$strip_description = stripslashes($_POST['description']);
			
			$SQL7 = " SELECT name, email, permissions FROM ttcm_user WHERE client_id = '" . $_POST['client_id'] . "' ";
			$retid7 = $db_q($db, $SQL7, $cid);
			
			$admin_sent = 0;

			while ( $row7 = $db_f($retid7) ) {
				$users_name = stripslashes($row7[ 'name' ]);
				$users_email = $row7[ "email" ];
				$user_perms = $row7[ "permissions" ];
				$email_perms = split(',', $user_perms);

				if ( ($users_email != '') && (in_array("96", $email_perms)) ) {
					
					$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
					$logo = $web_path . $_SESSION['site_logo'];
					$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
					
					// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '6' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						$subject = str_replace('[user name]', $users_name, $subject);
						$subject = str_replace('[project title]', $strip_title, $subject);
						$subject = str_replace('[client name]', $client_name, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION['admin_company'], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $users_name, $message);
						$message = str_replace('[project title]', $strip_title, $message);
						$message = str_replace('[project description]', $strip_description, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[client name]', $client_name, $message);
						$message = str_replace('[web path]', $web_link, $message);
						$message = str_replace('[reply link]', $reply_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						
						if ($admin_sent == 0) {
							$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						}
						
						$admin_sent++;
					
						mail("\"$users_name\" <$users_email>",$subject,$message,$headers);
			}
			}

			echo ("<div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $strip_title . "\" " . $COMMON_ADDED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=projperms&amp;pid=" . $project_id . "\">" . $NEXT_ADDPROJPERMS . "</a>");
			echo ("<li><a href=\"main.php?pg=addtask&amp;clid=" . $_POST['client_id'] . "&amp;pid=" . $project_id . "\">" . $NEXT_ADDTASKTPROJ . "</a>");
			echo ("<li><a href=\"main.php?pg=addproj&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_ADDPROJTCL . "</a>");
			echo ("<li><a href=\"main.php?pg=addproj\">" . $NEXT_ADDPROJNCL . "</a>");
			echo ("<li><a href=\"main.php?pg=projects&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
			echo ("</ul></p>");
			
			$showform = "0";
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}

		break;
	
	// ADD USER
	case adduser:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_GET['do'] == "add") {
			
			global $db_q, $db, $db_c, $cid, $db_f, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$new_username = $_POST['username'];
			$new_password = $_POST["password"];
			
			$SQL_check = " SELECT username FROM ttcm_user WHERE username = '" . $_POST['new_username'] . "' ";
			$SQLretid = $db_q($db, $SQL_check, $cid);
			$username_dup = $db_c( $SQLretid );
			
			if ($username_dup > 0) {
				echo("<p><strong>" . $ADDUSER_TAKEN . "</strong> " . $ADDUSER_CHOOSE . "</p>");
				$showform = "1";
			}
			
			else {
				
				$encpassword = md5($new_password);
				$name = addslashes($_POST['name']);
				$address1 = addslashes($_POST['user_address1']);
				$address2 = addslashes($_POST['user_address2']);
				$city = addslashes($_POST['user_city']);
				$state = addslashes($_POST['user_state']);
				$country = addslashes($_POST['user_country']);
				
				$strip_name = stripslashes($_POST['name']);
				
				$SQL1 = " SELECT permissions, type FROM ttcm_usertypes WHERE usertype_id = '" . $_POST['type'] . "' ";
				$retid1 = $db_q($db, $SQL1, $cid);
				$row1 = $db_f($retid1);
				
				$perms = $row1['permissions'];
				$perms_array = split(',', $perms);
				$user_type = $row1['type'];

				$SQL = " INSERT INTO ttcm_user (address1, address2, city, state, zip, country, phone, phone_alt, fax, client_id, username, password, email, name, type, aim, msn, yahoo, icq, skype, permissions) 
				VALUES ('$address1', '$address2', '$city', '$state', '$_POST[user_zip]', '$country', '$_POST[user_phone]', '$_POST[user_phone_alt]', '$_POST[user_fax]', '$_POST[client_id]','$new_username','$encpassword','$_POST[email]','$name','$user_type','$_POST[aim]','$_POST[msn]','$_POST[yahoo]','$_POST[icq]','$_POST[skype]','$perms') ";
				$result = $db_q($db,"$SQL",$cid);
				
				$user_id = mysql_insert_id();
				
				if (in_array("100", $perms_array)) {
					$SQL = "SELECT project_id, permissions FROM ttcm_project WHERE project_id > '0' ";
					$retid = $db_q($db, $SQL, $cid);
					while ($row = $db_f($retid)) {
						$proj_perms = $row['permissions'];
						$proj_id = $row['project_id'];
						$proj_array = split(',', $proj_perms);
						
						if (!in_array($user_id, $proj_array)) {
							$new_perms = $proj_perms . "," . $user_id;
							$SQL = " UPDATE ttcm_project SET permissions = '" . $new_perms . "' WHERE project_id = '" . $proj_id . "' ";
							$result = $db_q($db,"$SQL",$cid);
							echo mysql_error();
						}
					}
				}
				
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
						// GET CSS TEMPLATE
						$SQL1 = " SELECT htmltext FROM ttcm_templates WHERE template_id = '1' ";
						$retid1 = $db_q($db, $SQL1, $cid);
						$row1 = $db_f($retid1);
						$todo_css = $row1[ "htmltext" ];
						
						// OBTER MODELOS DE E-MAIL
						$SQL4 = " SELECT subject, htmltext FROM ttcm_templates WHERE template_id = '7' ";
						$retid4 = $db_q($db, $SQL4, $cid);
						$row4 = $db_f($retid4);
						$subject = $row4[ "subject" ];
						$todo_message = $row4[ "htmltext" ];
						
						// GET COMPANY NAME
						$SQL2 = "SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['client_id'] . "'";
						$retid2 = $db_q($db, $SQL2, $cid);
						$the_client = $db_f( $retid2 );
						$client_name = stripslashes($the_client[ 'company' ]);
						
						$subject = str_replace('[company]', $_SESSION['admin_company'], $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $_SESSION['admin_address1'];
						if ($_SESSION['admin_address2'] != '') {
							$address .= "<br />" . $_SESSION['admin_address2'];
						}
						
						$message = str_replace('[company]', $_SESSION[admin_company], $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $strip_name, $message);
						$message = str_replace('[username]', $new_username, $message);
						$message = str_replace('[password]', $new_password, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $_SESSION['admin_city'], $message);
						$message = str_replace('[state]', $_SESSION['admin_state'], $message);
						$message = str_replace('[zip]', $_SESSION['admin_zip'], $message);
						$message = str_replace('[phone]', $_SESSION['admin_phone'], $message);
						$message = str_replace('[alternate phone]', $_SESSION['admin_phone_alt'], $message);
						$message = str_replace('[website]', $_SESSION['admin_website'], $message);
						$message = str_replace('[client name]', $client_name, $message);
						$message = str_replace('[web path]', $web_link, $message);
						
						$headers  = "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset='iso-8859-1'\n";

						$headers .= "From: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
						$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$strip_name\" <$_POST[email]>",$subject,$message,$headers);
			
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDUSER_ADDED . " " . $strip_name . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=addperms&amp;uid=" . $user_id . "&amp;permtype=" . $_POST['type'] . "\">" . $NEXT_ADDUSERPERMS . "</a>");
				echo ("<li><a href=\"main.php?pg=adduser&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_ADDUSERTCL . "</a>");
				echo ("<li><a href=\"main.php?pg=adduser\">" . $NEXT_ADDUSERNCL . "</a>");
				echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_RETURNTCL . "</a>");
				echo ("</ul></p>");

				$showform = "0";
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// SAVE USER PERMISSIONS
	case addprojperms:
		
		global $db_q, $db, $cid, $db_f;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
		
		$perms = $_POST['perms'];
			
		$comma_perms = implode(",",$perms);
		
		$SQL = " UPDATE ttcm_project SET permissions = '" . $comma_perms . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		$result = $db_q($db,"$SQL",$cid);
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDPERM_PERMSAVED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=adduser\">" . $NEXT_ADDUSERNCL . "</a>");
		echo ("<li><a href=\"main.php?pg=addclient\">" . $NEXT_ADDCLIENT . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");;
		echo ("</ul></p>");
			
		$showform = "0";
		break;

	// SAVE PROJECT PERMISSIONS
	case saveperms:
	
		global $db_q, $db, $cid, $db_f;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
		
		$comma_perms = implode(",",$_POST['perms']);
		
		$SQL = " UPDATE ttcm_user SET permissions = '" . $comma_perms . "' WHERE id = '" . $_POST['uid'] . "' ";
		$result = $db_q($db,"$SQL",$cid);
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ADDPERM_PERMSAVED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=adduser\">" . $NEXT_ADDUSERNCL . "</a>");
		echo ("<li><a href=\"main.php?pg=addclient\">" . $NEXT_ADDCLIENT . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");;
		echo ("</ul></p>");
			
		$showform = "0";
		
		break;

	// DELETE ADMIN UPLOADED FILE
	case delfile:
		global $db_q, $db, $cid, $db_f, $home_dir;
		
		$SQL = " SELECT link FROM ttcm_files WHERE file_id = '" . $_GET['fid'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		$row = $db_f($retid);
		$file_path_orig = $row[ "link" ];
	
		$SQL2 = " DELETE FROM ttcm_files WHERE file_id = '" . $_GET['fid'] . "' ";
		$db_q($db, $SQL2, $cid);
		
		$file_det = substr($file_path_orig, 0, 5);
		if ($file_det != 'http:') {
		
			$the_path = $home_dir . $file_path_orig;	
   			unlink($the_path);
		}
		break;

	// DELETE CLIENT UPLOADED FILE
	case delcfile:
		global $db_q, $db, $cid, $db_f, $home_dir;
		
		$SQL = "SELECT link FROM ttcm_cfiles WHERE file_id = '" . $_GET['fid'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		$row = $db_f($retid);
		$file_path_orig = $row[ "link" ];
	
		$SQL2 = "DELETE FROM ttcm_cfiles WHERE file_id = '" . $_GET['fid'] . "' ";
		$db_q($db, $SQL2, $cid);
		
		$the_path = $home_dir . $file_path_orig;	
   		unlink("$the_path");
		break;
	
	// DELETE USER
	case deluser:
		global $db_q, $db, $cid, $db_f;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
		$SQL = " DELETE FROM ttcm_user WHERE id = '" . $_POST['uid'] . "' ";
		$db_q($db, $SQL, $cid);
	
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $_POST['user_name'] . "\" " . $COMMON_DELETED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=adduser\">" . $NEXT_ADDUSERNCL . "</a>");
		echo ("<li><a href=\"main.php?pg=allusers\">" . $NEXT_RETURNUSERS . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");
		echo ("</ul></p>");
		
		$showform = '0';
		break;
		
	// DELETE TO DO ITEM
	case deltodo:
		global $db_q, $db, $cid, $db_f;
   		$SQL = " DELETE FROM ttcm_todo WHERE todo_id = '" . $_GET['tdid'] . "' ";
		$db_q($db, $SQL, $cid);		
		break;
	
	// DELETE CLIENT NOTE
	case delnote:
		global $db_q, $db, $cid, $db_f;
		$SQL = " DELETE FROM ttcm_notes WHERE note_id = '" . $_GET['nid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;
		
	// DELETE PROJECT TASK
	case deltask:
		global $db_q, $db, $cid, $db_f;
		$SQL = " DELETE FROM ttcm_task WHERE task_id = '" . $_GET['tid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;
		
	// DELETE CLIENT PROJECT
	case delproj:
	
		global $db_q, $db, $cid, $db_f, $web_path, $home_dir;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	
		// REMOVE PROJECT NOTES
		$SQL4 = " DELETE FROM ttcm_notes WHERE project_id = '" . $_POST['pid'] . "' ";
		$db_q($db, $SQL4, $cid);
		
		// REMOVE PROJECT TASKS
		$SQL5 = " DELETE FROM ttcm_task WHERE project_id = '" . $_POST['pid'] . "' ";
		$db_q($db, $SQL5, $cid);
		
		// REMOVE PROJECT TO DO ITEMS
		$SQL6 = " DELETE FROM ttcm_todo WHERE project_id = '" . $_POST['pid'] . "' ";
		$db_q($db, $SQL6, $cid);	
	
		// REMOVE CLIENT FILES
		$SQL = " SELECT file_id, link FROM ttcm_cfiles WHERE project_id = '" . $_POST['pid'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		while ( $row = $db_f($retid) ) {
			$file_path_orig = $row[ "link" ];
	
			$SQL2 = " DELETE FROM ttcm_cfiles WHERE file_id = '" . $row[ "file_id" ] . "' ";
			$db_q($db, $SQL2, $cid);
		
			$file_det = substr($file_path_orig, 0, 5);
			if ($file_det != 'http:') {
		
				$the_path = $home_dir . $file_path_orig;	
   				unlink("$the_path");
			}
		}
	
		// REMOVE PROJECT FILES
		$SQL3 = " SELECT file_id, link FROM ttcm_files WHERE project_id = '" . $_POST['pid'] . "' ";
		$retid3 = $db_q($db, $SQL3, $cid);
		while ( $row3 = $db_f($retid3) ) {
			$file_path_orig2 = $row3[ "link" ];
	
			$SQL4 = " DELETE FROM ttcm_files WHERE file_id = '" . $row3[ "file_id" ] . "' ";
			$db_q($db, $SQL4, $cid);
		
			$file_det2 = substr($file_path_orig2, 0, 5);
			if ($file_det2 != 'http:') {
		
				$the_path2 = $home_dir . $file_path_orig;	
   				unlink("$the_path2");
			}
		}
		
		$SQL7 = " DELETE FROM ttcm_project WHERE project_id = '" . $_POST['pid'] . "' ";
		$db_q($db, $SQL7, $cid);
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . stripslashes($_POST['p_name']) . "\" " . $PROJECTS_DELETE . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=addproj\">" . $NEXT_ADDPROJNCL . "</a>");
		echo ("<li><a href=\"main.php?pg=projects\">" . $NEXT_RETURNPROJECTS . "</a>");
		echo ("</ul></p>");
		
		$showform = '0';
		break;
		
	// DELETE CLIENT
	case delclient:
		
		global $db_q, $db, $cid, $db_f, $home_dir;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );

		// REMOVE CLIENT ACCOUNT
		$SQL8 = " DELETE FROM ttcm_account WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL8, $cid);
		
		// REMOVE CLIENT ACCOUNT
		$SQL10 = " DELETE FROM ttcm_links WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL10, $cid);
		
		// REMOVE CLIENT MESSAGES
		$SQL11 = " DELETE FROM ttcm_messages WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL11, $cid);
		
		// REMOVE CLIENT USERS
		$SQL12 = " DELETE FROM ttcm_user WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL12, $cid);
		
		// REMOVE CLIENT WEBSITES
		$SQL13 = " DELETE FROM ttcm_websites WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL13, $cid);
	
		// REMOVE PROJECT NOTES
		$SQL4 = " DELETE FROM ttcm_notes WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL4, $cid);
		
		// REMOVE PROJECT TASKS
		$SQL5 = " DELETE FROM ttcm_task WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL5, $cid);
		
		// REMOVE PROJECT TO DO ITEMS
		$SQL6 = " DELETE FROM ttcm_todo WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL6, $cid);	
		
		// REMOVE CLIENT LOGO IMAGE
		$SQL7 = "SELECT logo FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "' ";
		$retid7 = $db_q($db, $SQL7, $cid);
		$row7 = $db_f($retid7);
		$the_logo = $home_dir . $row7['logo'];	
   		unlink("$the_logo");
	
		// REMOVE CLIENT FILES
		$SQL = " SELECT file_id, link FROM ttcm_cfiles WHERE client_id = '" . $_POST['clid'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		while ( $row = $db_f($retid) ) {
			
			$file_path_orig = $row[ "link" ];
	
			$SQL2 = " DELETE FROM ttcm_cfiles WHERE file_id = '" . $row[ "file_id" ] . "' ";
			$db_q($db, $SQL2, $cid);
		
			$file_det = substr($file_path_orig, 0, 5);
			if ($file_det != 'http:') {
		
				$the_path = $home_dir . $file_path_orig;	
   				unlink("$the_path");
			}
		}
	
		// REMOVE PROJECT FILES
		$SQL3 = " SELECT file_id, link FROM ttcm_files WHERE client_id = '" . $_POST['clid'] . "' ";
		$retid3 = $db_q($db, $SQL3, $cid);
		while ( $row3 = $db_f($retid3) ) {
			
			$file_path_orig2 = $row3[ "link" ];
	
			$SQL4 = " DELETE FROM ttcm_files WHERE file_id = '" . $row3[ "file_id" ] . "' ";
			$db_q($db, $SQL4, $cid);
		
			$file_det2 = substr($file_path_orig2, 0, 5);
			if ($file_det2 != 'http:') {
				$the_path2 = $home_dir . $file_path_orig2;	
   				unlink("$the_path2");
			}
		}
		
		// REMOVE CLIENT PROJECTS
		$SQL7 = " DELETE FROM ttcm_project WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL7, $cid);
		
		// REMOVE PROJECT NOTES
		$SQL9 = " DELETE FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "' ";
		$db_q($db, $SQL9, $cid);
		
		if ( !ini_get('safe_mode') ) {
			
			$dir = $home_dir . "clientdir/" . $_POST['clid'];
			
			// REMOVE CLIENT DIRECTORIES
			rmdir("$dir/dl"); 
			rmdir("$dir/ul"); 
			rmdir("$dir");

		}
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp;\"" . $_POST['cl_name'] . "\" " . $CLIENTS_DELETED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=addclient\">" . $NEXT_ADDCLIENT . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");
		echo ("</ul></p>");
		
		$showform = '0';
		break;
	
	// EDIT CLIENT STATUS
	case clientstatus:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;

			$SQL = " UPDATE ttcm_account SET status = '" . $_POST['status'] . "' WHERE account_id = '" . $_POST['account_id'] . "' ";
			$result = $db_q($db,"$SQL",$cid);
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// EDIT CLIENT
	case editclient:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			if ($_POST['company'] != '') {
				
				$company = addslashes($_POST['company']);
				$address1 = addslashes($_POST['address1']);
				$address2 = addslashes($_POST['address2']);
				$city = addslashes($_POST['city']);
				$state = addslashes($_POST['state']);
				$country = addslashes($_POST['country']);
	
				$SQL = " UPDATE ttcm_client SET company = '" . $company . "', address1 = '" . $address1 . "', 
				address2 = '" . $address2 . "', city = '" . $city . "', state = '" . $state . "', 
				zip = '" . $_POST['zip'] . "', country = '" . $country . "', phone = '" . $_POST['phone'] . "', 
				phone_alt = '" . $_POST['phone_alt'] . "', fax = '" . $_POST['fax'] . "' WHERE client_id = '" . $_POST['clid'] . "' ";
				$result = $db_q($db,"$SQL",$cid);
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $_POST['company'] . "\" $COMMON_UPDATED</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_GET['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
				echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");
				echo ("<li><a href=\"main.php?pg=addclient\">" . $NEXT_ADDCLIENT . "</a>");
				echo ("</ul></p>");
		
				$showform = '0';
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; Você precisa informar um nome para este Cliente!</div><br />");
				$showform = '1';
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD CLIENT
	case addclient:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $home_dir;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
			
			if ($_POST['company'] != '') {
				
				$company = addslashes($_POST['company']);
				$address1 = addslashes($_POST['address1']);
				$address2 = addslashes($_POST['address2']);
				$city = addslashes($_POST['city']);
				$state = addslashes($_POST['state']);
				$country = addslashes($_POST['country']);
		
				$SQL = " INSERT INTO ttcm_client ";
				$SQL = $SQL . " (company, address1, address2, city, state, zip, country, phone, phone_alt, fax) VALUES ";
				$SQL = $SQL . " ('$company','$address1','$address2','$city','$state','$_POST[zip]','$country','$_POST[phone]','$_POST[phone_alt]', '$_POST[fax]') ";

				$result = $db_q($db,"$SQL",$cid);
				echo mysql_error();
		
				$new_id = mysql_insert_id();
		
				$SQL2 = " INSERT INTO ttcm_account (client_id, status) VALUES ('$new_id','$_SESSION[default_acl]') ";
				$result2 = $db_q($db,"$SQL2",$cid);
		
				if ( !ini_get('safe_mode') ) {
					
					$dir = $home_dir . "/clientdir/" . $new_id;
			
					// CREATE CLIENT DIRECTORIES
					mkdir("$dir", 0777); 
					chmod("$dir", 0777 ); 
					mkdir("$dir/dl", 0777); 
					chmod("$dir/dl", 0777 ); 
					mkdir("$dir/ul", 0777); 
					chmod("$dir/ul", 0777 ); 

				}

				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; \"" . $_POST['company'] . "\" " . $COMMON_ADDED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=adduser&amp;clid=" . $new_id . "\">" . $NEXT_ADDUSERTCL . "</a>");
				echo ("<li><a href=\"main.php?pg=addproj&amp;clid=" . $new_id . "\">" . $NEXT_ADDPROJTCL . "</a>");
				echo ("<li><a href=\"main.php?pg=addclient\">" . $NEXT_ADDCLIENT . "</a>");
				echo ("</ul></p>");
		
				$showform = '0';
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $ADDCLIENT_NONAME . "</div><br />");
				$showform = '1';
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// CHANGE PASSWORD
	case changepw:
	
		global $db_q, $db, $cid, $db_f, $web_path;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_userinfo.php" );
			
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$encpassword = md5($_POST['newpassword']);
						
			$SQL = "UPDATE ttcm_user SET password = '" . $encpassword . "' WHERE id = '" . $_SESSION['valid_id'] . "' ";
			$result = $db_q($db,"$SQL",$cid);
			

			if ($_SESSION['user_email'] != '') { 
	
						$web_link = "<a href=\"" . $web_path . "\">" . $web_path . "</a>";
						$logo = $web_path . $_SESSION['site_logo'];
						$logo_link = "<a href=\"" . $_SESSION['admin_website'] . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $_SESSION['admin_company'] . "\" /></a>";
	
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
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $_SESSION[admin_name], $message);
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
						$headers .= "Bcc: \"" . $_SESSION['admin_company'] . "\" <" . $_SESSION['admin_email'] . ">\r\n";
					
						mail("\"$_SESSION[admin_name]\" <$_SESSION[user_email]>",$subject,$message,$headers);
						
				echo("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $CHANGEPW_PWCHANGE . " " . $CHANGEPW_ECONFIRM . " " . $_SESSION['user_email'] . "</div><br />");
			}
	 		else {
				echo("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $CHANGEPW_PWCHANGE . "</div><br />");
			}
		}
	break;
	
	// EDIT USER
	case edituser:
	
		global $db_q, $db, $cid, $db_f;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$name = addslashes($_POST['user_name']);
			$address1 = addslashes($_POST['user_address1']);
			$address2 = addslashes($_POST['user_address2']);
			$city = addslashes($_POST['user_city']);
			$state = addslashes($_POST['user_state']);
			$country = addslashes($_POST['user_country']);
			$new_username = $_POST['new_username'];
		
		$SQL = "UPDATE ttcm_user SET type = '" . $_POST['type'] . "', client_id = '" . $_POST['client_id'] . "', name = '" . $name . "', email = '" . $_POST['email'] . "', 
		username = '" . $new_username . "', aim = '" . $_POST['aim'] . "', msn = '" . $_POST['msn'] . "', yahoo = '" . $_POST['yahoo'] . "', 
		skype = '" . $_POST['skype'] . "', icq = '" . $_POST['icq'] . "', address1 = '" . $address1 . "', address2 = '" . $address2 . "', city = '" . $city . "', 
		state = '" . $state . "', zip = '" . $_POST['user_zip'] . "', country = '" . $country . "', phone = '" . $_POST['user_phone'] . "', phone_alt = '" . $_POST['user_phone_alt'] . "',
		fax = '" . $_POST['user_fax'] . "' WHERE id = '" . $_POST['uid'] . "'";
		$result = $db_q($db,"$SQL",$cid);
		echo mysql_error();
 
			if ($_POST['newpassword'] != '') {
				$encpassword = md5($_POST['newpassword']);
				$SQL2 = " UPDATE ttcm_user SET password = '" . $encpassword . "' WHERE id = '" . $_POST['uid'] . "' ";
				$result2 = $db_q($db,"$SQL2",$cid);
			}
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $_POST['user_name'] . " " . $COMMON_UPDATED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_RETURNTCL . "</a>");
		echo ("<li><a href=\"main.php?pg=adduser&amp;clid=" . $_POST['client_id'] . "\">" . $NEXT_ADDUSERTCL . "</a>");
		echo ("</ul></p>");
		
		$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// UPDATE HELP TOPIC
	case edittopic:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$topic = addslashes($_POST['topic']);
			$description = addslashes($_POST['description']);
		
			$SQL = " UPDATE ttcm_topics SET topic = '" . $topic . "', cat_id = '" . $_POST['cat_id'] . "', description = '" . $description . "' WHERE topic_id = '" . $_POST['tid'] . "' ";
			$result = $db_q($db,"$SQL",$cid);
		
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $EDITTOPIC_UPDATED . "</div><br />");
			echo ("<p><ul class=\"circle\">");
			echo ("<li><a href=\"main.php?pg=addtopic\">" . $NEXT_ADDHELPTOPIC . "</a>");
			echo ("<li><a href=\"main.php?pg=addhelpcat\">" . $NEXT_ADDHELPCAT . "</a>");
			echo ("<li><a href=\"main.php?pg=help\">" . $NEXT_RETURNHELP . "</a>");
			echo ("</ul></p>");
			
			$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// UPLOAD LOGO
	case addlogo:
	
		global $db_q, $db, $cid, $db_f, $web_path, $home_dir;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$path = $home_dir . "images";
			$ulfile = $path . "/" . basename($_FILES['file']['name']);
			
			$file_name = $_FILES['file']['name'];

			if(move_uploaded_file($_FILES['file']['tmp_name'], $ulfile)) {
	
				$logo = "images/" . $file_name;
				
				$_SESSION['site_logo'] = $logo;
				
				$SQL = " UPDATE ttcm_admin SET logo = '" . $logo . "' WHERE company_id = '1' ";
				$result = $db_q($db,"$SQL",$cid);
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $file_name . " " . $COMMON_ADDED . "</div><br />");
			} 
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_ERROR . "</div><br />");
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// UPLOAD CLIENT LOGO
	case clogo:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $home_dir, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			
			$clid = $_POST['clid'];
			
			if ( ini_get('safe_mode') ) {

				$path = $home_dir . "clientdir/dl";
				$ulfile = $path . "/" . $clid . "_" . basename($_FILES['file']['name']);
				
				$file_name = $_FILES['file']['name'];
				
				if (move_uploaded_file($_FILES['file']['tmp_name'], $ulfile)) {

					$new_filename = $clid . "_" . basename($_FILES['file']['name']);
					$logo = "clientdir/dl/" . $new_filename;
					$SQL = " UPDATE ttcm_client SET logo = '" . $logo . "' WHERE client_id = '" . $_POST['clid'] . "' ";
					$result = $db_q($db,"$SQL",$cid);
					echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $new_filename . " " . $COMMON_ADDED . "</div><br />");
				} 
				else {
					echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_ERROR . "</div><br />");
				}
			}
			else {
				$path = $home_dir . "clientdir/" . $clid;
				$ulfile = $path . "/" . basename($_FILES['file']['name']);
				
				$file_name = $_FILES['file']['name'];
				
				if(move_uploaded_file($_FILES['file']['tmp_name'], $ulfile)) {

					$logo = "clientdir/" . $clid . "/" . $file_name;
					
					$SQL = " UPDATE ttcm_client SET logo = '" . $logo . "' WHERE client_id = '" . $_POST['clid'] . "' ";
					$result = $db_q($db,"$SQL",$cid);
					echo ("<div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $file_name . " " . $COMMON_ADDED . "</div><br />");
				} 
				else {
					echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_ERROR . "</div><br />");
				}
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
			
	// EDIT STATUS
	case editstatus:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
		global $db_q, $db, $cid, $db_f;
			
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		$status_name = addslashes($_POST['name']);
		
		$SQL = " UPDATE ttcm_status SET name = '" . $status_name . "', type = '" . $_POST['type'] . "' WHERE status_id = '" . $_POST['status_id'] . "' ";
		$result = $db_q($db,"$SQL",$cid);
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $EDITSTATUS_UPDATED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=status\">" . $NEXT_RETURNSTATUS . "</a>");
		echo ("</ul></p>");
			
		$showform = '0';
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// EDIT MESSAGE
	case editmessage:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $home_dir, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );
		
			$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
			
			if ($_POST['message_title'] != '') {
				
				$message_title = addslashes($_POST['message_title']);
				$message = addslashes($_POST['message']);
		
				$SQL = " UPDATE ttcm_messages SET client_id = '" . $_POST['clid'] . "', project_id = '" . $_POST['pid'] . "', message_title = '" . $message_title . "', updated = '" . $updated . "', message = '" . $message . "' WHERE message_id = '" . $_POST['mid'] . "'";
				$result = $db_q($db,"$SQL",$cid);
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $EDITMESSAGE_UPDATED . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=addmsg\">" . $NEXT_ADDMESSAGE . "</a>");
				echo ("<li><a href=\"main.php?pg=msg\">" . $NEXT_RETURNMESSAGE . "</a>");
				echo ("</ul></p>");
		
				$showform = '0';
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $ADDMESSAGE_NOTITLE . "</div><br />");
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// EDITAR MODELO DE E-MAIL
	case editetemplate:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $home_dir, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
			
			if ($_POST['template_id'] == '1') {
				$SQL = " UPDATE ttcm_templates SET htmltext = '" . $_POST['email_body'] . "' WHERE template_id = '" . $_POST['template_id'] . "'";
				$result = $db_q($db,"$SQL",$cid);
				echo mysql_error();
		
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ETEMPLATE_SUCCESS . "</div><br />");
				echo ("<p><ul class=\"circle\">");
				echo ("<li><a href=\"main.php?pg=templates\">" . $NEXT_EDITETEMPLATES . "</a>");
				echo ("</ul></p>");
				$showform = '0';
			}
			else {
				if ($_POST['email_subject'] != '') {
		
					$SQL = " UPDATE ttcm_templates SET subject = '" . $_POST['email_subject'] . "', htmltext = '" . $_POST['email_body'] . "' WHERE template_id = '" . $_POST['template_id'] . "'";
					$result = $db_q($db,"$SQL",$cid);
		
					echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $ETEMPLATE_SUCCESS . "</div><br />");
					echo ("<p><ul class=\"circle\">");
					echo ("<li><a href=\"main.php?pg=templates\">" . $NEXT_EDITETEMPLATES . "</a>");
					echo ("</ul></p>");
		
					$showform = '0';
				}
				else {
					echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $ETEMPLATE_NOSUBJECT . "</div><br />");
				}
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// EDIT PROJECT
	case editproject:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f, $home_dir, $web_path;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		
		if ($_POST['newstart'] != '') {
			$newstart = $_POST['newstart'];
			$stmo = substr($newstart,0,2);
			$stday = substr($newstart,3,2);
			$styr = substr($newstart,6,4);
			$start = "$styr/$stmo/$stday";
		}
		else {
			$start = $_POST['oldstart'];
		}
		
		if ($_POST['newmilestone'] != '') {
			$newmilestone = $_POST['newmilestone'];
			$mimo = substr($newmilestone,0,2);
			$miday = substr($newmilestone,3,2);
			$miyr = substr($newmilestone,6,4);
			$milestone = "$miyr/$mimo/$miday";
		}
		else {
			$milestone = $_POST['oldmilestone'];
		}
			
		if ($_POST['newfinish'] != '') {
			$newfinish = $_POST['newfinish'];
			$fmo = substr($newfinish,0,2);
			$fday = substr($newfinish,3,2);
			$fyr = substr($newfinish,6,4);
			$finish = "$fyr/$fmo/$fday";
		}
		else {
			$finish = $_POST['oldfinish'];
		}
		
		$project_title = addslashes($_POST['project_title']);
		$description = addslashes($_POST['description']);
		
		$SQL = " UPDATE ttcm_project SET client_id = '" . $_POST['clid'] . "', title = '" . $project_title . "', description = '" . $description . "', start = '" . $start . "', updated = '" . $updated . "', finish = '" . $finish . "', status = '" . $_POST['status'] . "', cost = '" . $_POST['cost'] . "', milestone = '" . $milestone . "' WHERE project_id = '" . $_POST['pid'] . "'";

		$result = $db_q($db,"$SQL",$cid);
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $_POST['project_title'] . " " . $COMMON_UPDATED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_RETURNPROJECT . "</a>");
		echo ("<li><a href=\"main.php?pg=projects&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNPROJTCL . "</a>");
		echo ("<li><a href=\"main.php?pg=client&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTCL . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");
		echo ("</ul></p>");
		
		$showform = "0";
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// EDIT TASK
	case edittask:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
		
			global $home_dir, $web_path;
		
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		
		if ($_POST['newstart'] != '') {
			$newstart = $_POST['newstart'];
			$stmo = substr($newstart,0,2);
			$stday = substr($newstart,3,2);
			$styr = substr($newstart,6,4);
			$start = "$styr/$stmo/$stday";
		}
		else {
			$start = $_POST['oldstart'];
		}
		
		if ($_POST['newmilestone'] != '') {
			$newmilestone = $_POST['newmilestone'];
			$mimo = substr($newmilestone,0,2);
			$miday = substr($newmilestone,3,2);
			$miyr = substr($newmilestone,6,4);
			$milestone = "$miyr/$mimo/$miday";
		}
		else {
			$milestone = $_POST['oldmilestone'];
		}
			
		if ($_POST['newfinish'] != '') {
			$newfinish = $_POST['newfinish'];
			$fmo = substr($newfinish,0,2);
			$fday = substr($newfinish,3,2);
			$fyr = substr($newfinish,6,4);
			$finish = "$fyr/$fmo/$fday";
			}
		else {
			$finish = $_POST['oldfinish'];
		}
		
		$task_title = addslashes($_POST['task_title']);
		$description = addslashes($_POST['description']);
		
		$SQL = " UPDATE ttcm_task SET project_id = '" . $_POST['pid'] . "', client_id = '" . $_POST['clid'] . "', title = '" . $task_title . "', description = '" . $description . "', start = '" . $start . "', updated = '" . $updated . "', status = '" . $_POST['status'] . "', finish = '" . $finish . "', notes = '" . $_POST['notes'] . "', milestone = '" . $milestone . "', assigned = '" . $_POST['tauid'] . "' WHERE task_id = '" . $_POST['tid'] . "'";
		$result = $db_q($db,"$SQL",$cid);
			
		$SQL2 = " UPDATE ttcm_project SET updated = '" . $_POST['updated'] . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $_POST['task_title'] . " " . $COMMON_UPDATED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=tasks\">" . $NEXT_RETURNACTIVETASK . "</a>");
		echo ("<li><a href=\"main.php?pg=tasks&amp;clid=" . $_POST['clid'] . "\">" . $NEXT_RETURNTASKTCL . "</a>");
		echo ("<li><a href=\"main.php?pg=proj&amp;clid=" . $_POST['clid'] . "&amp;pid=" . $_POST['pid'] . "\">" . $NEXT_RETURNPROJECT . "</a>");
		echo ("<li><a href=\"main.php?pg=clients\">" . $NEXT_RETURNCLIENTS . "</a>");
		echo ("</ul></p>");
		
		$showform = "0";
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// DELETE HELP TOPIC
	case deltopic:
		global $db_q, $db, $cid, $db_f;
		$SQL = " DELETE FROM ttcm_topics WHERE topic_id = '" . $_GET['tid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;
		
	// DELETE HELP CATEGORY
	case delhcat:
		global $db_q, $db, $cid, $db_f;
		$SQL = "DELETE FROM ttcm_helpcat WHERE cat_id = '" . $_GET['catid'] . "' ";
		$db_q($db, $SQL, $cid);	
		$SQL2 = "DELETE FROM ttcm_topics WHERE cat_id = '" . $_GET['catid'] . "' ";
		$db_q($db, $SQL2, $cid);
		break;

	// DELETE FILE TYPE
	case deltype:
		global $db_q, $db, $cid, $db_f;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		$SQL = "DELETE FROM ttcm_filetype WHERE type_id = '" . $_GET['type_id'] . "' ";
		$db_q($db, $SQL, $cid);
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $FILETYPES_DELETED . "</div><br />");
		break;
		
	// EXCLUÍR NÍVEL DE USUÁRIO
	case delusertype:
		global $db_q, $db, $cid, $db_f;

		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		if ($_GET['users'] != '0') {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $USERTYPE_STILLUSERS . "</div><br />");
		}
		else {
			$SQL = "DELETE FROM ttcm_usertypes WHERE usertype_id = '" . $_GET['usertype_id'] . "' ";
			$db_q($db, $SQL, $cid);
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $USERTYPE_DELETED . "</div><br />");
		}
		break;
		
	// ADICIONAR NÍVEL DE USUÁRIO
	case addusertype:
		global $db_q, $db, $cid, $db_f;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		$comma_perms = implode(",",$_POST['perms']);
		$usertype = addslashes($_POST['usertype']);
		$description = addslashes($_POST['type_desc']);

		$SQL = "INSERT INTO ttcm_usertypes (name, description, permissions) VALUES ('$usertype', '$description', '$comma_perms') ";
		$result = $db_q($db,"$SQL",$cid);
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $USERTYPE_ADDED . "</div><br />");
		break;
	
	// EDITAR NÍVEL DE USUÁRIO
	case editusertype:
	
		global $db_q, $db, $cid, $db_f;
		
		include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
		
		$comma_perms = implode(",",$_POST['perms']);
		
		$SQL = " UPDATE ttcm_usertypes SET name = '" . addslashes($_POST['usertype']) . "', description = '" . addslashes($_POST['type_desc']) . "', 
		permissions = '" . $comma_perms . "' WHERE usertype_id = '" . $_POST['usertype_id'] . "' ";
		$result = $db_q($db,"$SQL",$cid);
		
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $USERTYPE_SAVED . "</div><br />");
		echo ("<p><ul class=\"circle\">");
		echo ("<li><a href=\"main.php?pg=usertypes\">" . $NEXT_USERTYPES . "</a>");
		echo ("<li><a href=\"main.php?pg=addusertype\">" . $NEXT_ADDUSERTYPE . "</a>");;
		echo ("</ul></p>");
			
		$showform = "0";
		
		break;

	// ADD FILE TYPE
	case addfiletype:
		global $db_q, $db, $cid, $db_f;
	
		include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
		$file_type = addslashes($_POST['file_type']);

		$SQL = "INSERT INTO ttcm_filetype (file_type) VALUES ('$file_type') ";
		$result = $db_q($db,"$SQL",$cid);
		echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $FILETYPES_ADDED . "</div><br />");
		break;

	// DELETE STATUS OPTION
	case delstat:
		global $db_q, $db, $cid, $db_f;
		$SQL = "DELETE FROM ttcm_status WHERE status_id = '" . $_GET['status_id'] . "' ";
		$db_q($db, $SQL, $cid);
		break;

	// SAVE ADMIN SETTINGS
	case saveadmin:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
			
			$_SESSION['admin_company'] = $_POST['new_admin_company'];
			$_SESSION['admin_address1'] = $_POST['new_admin_address1'];
			$_SESSION['admin_address2'] = $_POST['new_admin_address2'];
			$_SESSION['admin_city'] = $_POST['new_admin_city'];
			$_SESSION['admin_state'] = $_POST['new_admin_state'];
			$_SESSION['admin_zip'] = $_POST['new_admin_zip'];
			$_SESSION['admin_country'] = $_POST['new_admin_country'];
			$_SESSION['admin_email'] = $_POST['new_admin_email'];
			$_SESSION['admin_phone'] = $_POST['new_admin_phone'];
			$_SESSION['admin_phone_alt'] = $_POST['new_admin_phone_alt'];
			$_SESSION['admin_fax'] = $_POST['new_admin_fax'];
			$_SESSION['admin_aim'] = $_POST['new_admin_aim'];
			$_SESSION['admin_msn'] = $_POST['new_admin_msn'];
			$_SESSION['admin_yahoo'] = $_POST['new_admin_yahoo'];
			$_SESSION['admin_icq'] = $_POST['new_admin_icq'];
			$_SESSION['admin_skype'] = $_POST['new_admin_skype'];
			
			$new_company = addslashes($_POST['new_admin_company']);
			$new_address1 = addslashes($_POST['new_admin_address1']);
			$new_address2 = addslashes($_POST['new_admin_address2']);
			$new_city = addslashes($_POST['new_admin_city']);
			$new_state = addslashes($_POST['new_admin_state']);
			$new_country = addslashes($_POST['new_admin_country']);
		
			$SQL = "UPDATE ttcm_admin SET company = '" . $new_company . "', address1 = '" . $new_address1 . "', 
			address2 = '" . $new_address2 . "', city = '" . $new_city . "', state = '" . $new_state . "', 
			zip = '" . $_POST['new_admin_zip'] . "', country = '" . $new_country . "', email = '" . $_POST['new_admin_email'] . "', 
			phone = '" . $_POST['new_admin_phone'] . "', phone_alt = '" . $_POST['new_admin_phone_alt'] . "', fax = '" . $_POST['new_admin_fax'] . "', 
			aim = '" . $_POST['new_admin_aim'] . "', msn = '" . $_POST['new_admin_msn'] . "', yahoo = '" . $_POST['new_admin_yahoo'] . "', 
			icq = '" . $_POST['new_admin_icq'] . "', skype = '" . $_POST['new_admin_skype'] . "' 
			WHERE company_id = '" . $_POST['company_id'] . "'";
			$result = $db_q($db,"$SQL",$cid);
			if (!$result) {
				echo( mysql_error());
			}
			else {
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_SAVED . "</div><br />"); 
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// SAVE DEFAULT SETTINGS
	case savedefault:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
				
			$SQL = " UPDATE ttcm_admin SET def_aclient = '" . $_POST['def_addclient'] . "', def_aproject = '" . $_POST['def_addproject'] . "', def_projdone = '" . $_POST['def_projectdone'] . "', def_atask = '" . $_POST['def_addtask'] . "', def_taskdone = '" . $_POST['def_taskdone'] . "', def_ainvoice = '" . $_POST['def_addinvoice'] . "', def_invdone = '" . $_POST['def_invdone'] . "' WHERE company_id = '1' ";
			$result = $db_q($db,"$SQL",$cid);
			if (!$result) {
				echo( mysql_error());
			}
			else {
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_DEFAULTSAVED . "</div><br />"); 
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
// SAVE CURRENCY SETTINGS
	case savecurrency:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
			
			$_SESSION['currency'] = $_POST['new_currency'];
			$_SESSION['language'] = $_POST['new_language'];
				
			$SQL = " UPDATE ttcm_admin SET currency = '" . $_POST['new_currency'] . "', language = '" . $_POST['new_language'] . "' WHERE company_id = '1' ";
			$result = $db_q($db,"$SQL",$cid);
			if (!$result) {
				echo( mysql_error());
			}
			else {
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_CURRENCYSAVED . "</div><br />"); 
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
				
	// SAVE SIDE DEFAULT ADMIN SETTINGS
	case defsideset:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
			
			$_SESSION['serverdiff'] = $_POST['new_serverdiff'];
			$_SESSION['date_format'] = $_POST['new_dateformat'];
			$_SESSION['allowed_ext'] = $_POST['new_extensions'];
			
			$SQL = " UPDATE ttcm_admin SET serverdiff = '" . $_POST['new_serverdiff'] . "', date_format = '" . $_POST['new_dateformat'] . "', 
			file_ext = '" . $_POST['new_extensions'] . "' WHERE company_id = '1' ";
			$result = $db_q($db,"$SQL",$cid);
			if (!$result) {
				echo( mysql_error());
			}
			else {
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_SIDESAVE . "</div><br />"); 
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// SAVE SIDE APPEARANCE ADMIN SETTINGS
	case appsideset:
			// CHECK TO ENSURE FORM WAS PROCESSED
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				
				global $db_q, $db, $cid, $db_f;
				
				include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
				include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

				$SQL = " UPDATE ttcm_admin SET outcolor = '" . $_POST['new_outcolor'] . "', overcolor = '" . $_POST['new_overcolor'] . "' WHERE company_id = '1' ";
				$result = $db_q($db,"$SQL",$cid);
				if (!$result) {
					echo( mysql_error());
				}
				else {
					echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_SIDESAVE . "</div><br />"); 
				}
			}
			else {
				echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
			}
			break;
		
	// SAVE APPEARANCE ADMIN SETTINGS
	case saveappear:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
		
			$SQL = " UPDATE ttcm_admin SET messages_active = '" . $_POST['vis_message'] . "', clients_active = '" . $_POST['vis_client'] . "', 
			projects_active = '" . $_POST['vis_project'] . "', files_active = '" . $_POST['vis_file'] . "', help_active = '" . $_POST['vis_help'] . "', 
			upload_active = '" . $_POST['vis_upload'] . "' WHERE company_id = '1' ";
			$result = $db_q($db,"$SQL",$cid);
			if (!$result) {
				echo( mysql_error());
			}
			else {
				$_SESSION['messages_active'] = $_POST['vis_message'];
				$_SESSION['clients_active'] = $_POST['vis_client'];
				$_SESSION['projects_active'] = $_POST['vis_project'];
				$_SESSION['files_active'] = $_POST['vis_file'];
				$_SESSION['help_active'] = $_POST['vis_help'];
				$_SESSION['upload_active'] = $_POST['vis_upload'];
				
				echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $SETTINGS_SIDESAVE . "</div><br />"); 
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
		
	// ADD STATUS OPTION
	case addstat:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			
			$name = addslashes($_POST['name']);
			$type = $_POST['type'];
		
			$SQL = " INSERT INTO ttcm_status (name, type) VALUES ('$name','$type') ";
			$result = $db_q($db,"$SQL",$cid);
			echo mysql_error();
			
			echo("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $_POST['name'] . " " . $COMMON_ADDED . "</div><br />");
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// MAKE PROJECT DONE
	case projdone:
		global $db_q, $db, $cid, $db_f;
		$done = date("Y-m-d", time() + $_SESSION['serverdiff'] * 60 * 60);
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL = " UPDATE ttcm_project SET finish = '" . $done . "', updated = '" . $updated . "', status = '" . $_SESSION['default_prd'] . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		$result = $db_q($db,"$SQL",$cid); 
		
		$SQL2 = " DELETE FROM ttcm_todo WHERE project_id = '" . $_POST['pid'] . "' ";
		$db_q($db, $SQL2, $cid);
		break;
	
	// MAKE PROJECT UNDONE
	case projnotdone:
		global $db_q, $db, $cid, $db_f;
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL = " UPDATE ttcm_project SET finish = '0000/00/00 00:00:00', updated = '" . $updated . "', status = '" . $_SESSION['default_apr'] . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		$result = $db_q($db,"$SQL",$cid); 
		break;
		
	// UPDATE PROJECT STATUS
	case projstat:
		global $db_q, $db, $cid, $db_f;
		$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
		$SQL = " UPDATE ttcm_project SET status = '" . $_POST['vari'] . "', updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
		$result = $db_q($db,"$SQL",$cid);
		break;
		
	// UPDATE PROJECT TASK
	case projtask:
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			global $db_q, $db, $cid, $db_f;
		
			$finish = date("Y-m-d", time() + $_SESSION['serverdiff'] * 60 * 60);
			$updated = date("Y/m/d G:i:s", time() + $_SESSION['serverdiff'] * 60 * 60);
			$SQL = " UPDATE ttcm_task SET finish = '" . $finish . "', updated = '" . $updated . "', status = '" . $_SESSION['default_tad'] . "' WHERE task_id = '" . $_POST['vari'] . "' ";
			$result = $db_q($db,"$SQL",$cid); 
			$SQL2 = " UPDATE ttcm_project SET updated = '" . $updated . "' WHERE project_id = '" . $_POST['pid'] . "' ";
			$result2 = $db_q($db,"$SQL2",$cid);
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;

	// SAVE ADMIN USER INFO
	case saveainfo:
		global $db_q, $db_c, $db, $cid, $db_f;
		
		// CHECK TO ENSURE FORM WAS PROCESSED
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
			
			$_SESSION['admin_name'] = $_POST['name'];
			$_SESSION['user_email'] = $_POST['email'];
			$_SESSION['aim_im'] = $_POST['new_aim'];
			$_SESSION['msn_im'] = $_POST['new_msn'];
			$_SESSION['yahoo_im'] = $_POST['new_yahoo'];
			$_SESSION['icq_im'] = $_POST['new_icq'];
			$_SESSION['skype_im'] = $_POST['new_skype'];
			$_SESSION['user_address1'] = $_POST['new_user_address1'];
			$_SESSION['user_address2'] = $_POST['new_user_address2'];
			$_SESSION['user_city'] = $_POST['new_user_city'];
			$_SESSION['user_state'] = $_POST['new_user_state'];
			$_SESSION['user_zip'] = $_POST['new_user_zip'];
			$_SESSION['user_country'] = $_POST['new_user_country'];
			$_SESSION['user_phone'] = $_POST['new_user_phone'];
			$_SESSION['user_phone_alt'] = $_POST['new_user_phone_alt'];
			$_SESSION['user_fax'] = $_POST['new_user_fax'];
			
			$name = addslashes($_POST['name']);
		
			$SQL = " UPDATE ttcm_user SET name = '" . $name . "', email = '" . $_POST['email'] . "', aim = '" . $_POST['new_aim'] . "', 
			msn = '" . $_POST['new_msn'] . "', yahoo = '" . $_POST['new_yahoo'] . "', icq = '" . $_POST['new_icq'] . "', 
			skype = '" . $_POST['new_skype'] . "', address1 = '" . $_POST['new_user_address1'] . "',  address2 = '" . $_POST['new_user_address2'] . "', 
			city = '" . $_POST['new_user_city'] . "', state = '" . $_POST['new_user_state'] . "', zip = '" . $_POST['new_user_zip'] . "', 
			country = '" . $_POST['new_user_country'] . "', phone = '" . $_POST['new_user_phone'] . "', phone_alt = '" . $_POST['new_user_phone_alt'] . "', 
			fax = '" . $_POST['new_user_fax'] . "' WHERE id = '" . $_POST['vid'] . "'";
			$result = $db_q($db,"$SQL",$cid);
			echo mysql_error();
			
			echo ("&nbsp;<br /><div id=\"success\"><img src=\"../images/success.gif\" align=\"left\"> &nbsp; " . $_POST['name'] . " " . $COMMON_UPDATED . "</div><br />");
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $COMMON_INVALID . "</div><br />");
		}
		break;
	
	// DELETE MESSAGE
	case delmessage:
		global $db_q, $db, $cid, $db_f;
		$SQL1 = " DELETE FROM ttcm_comments WHERE message_id = '" . $_GET['mid'] . "' ";
		$db_q($db, $SQL1, $cid);
		$SQL = " DELETE FROM ttcm_messages WHERE message_id = '" . $_GET['mid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;
	
	// DELETE LINK
	case dellink:
		global $db_q, $db, $cid, $db_f;
		$SQL = " DELETE FROM ttcm_links WHERE link_id = '" . $_GET['linkid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;
		
	// DELETE WEBSITE
	case delweb:
		global $db_q, $db, $cid, $db_f;
		$SQL = " DELETE FROM ttcm_websites WHERE web_id = '" . $_GET['webid'] . "' ";
		$db_q($db, $SQL, $cid);
		break;

	default:
		break;
}
?>