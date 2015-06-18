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

// GET STATUS OF CLIENT ACCOUNT
function get_client_status($client_id) {

	global $cid, $db_q, $db_f, $db;
	
	$client_id = $_SESSION['client_id'];
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_navigation.php" );

	$SQL = " SELECT status FROM ttcm_account WHERE client_id = '" . $client_id . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);
	$account_status = $row[ "status" ];
	
	$acct_stat = "<h3>" . $HEADER_ACCTSTAT . "</h3>\n";
	$acct_stat .= "<p><strong>" . $account_status . "</strong></p>\n";
	
	return $acct_stat; 
}

// MOST POPULAR HELP TOPICS
function mostpopular_help($how_many) {
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_helpsection.php" );

	global $cid, $db_q, $db_c, $db_f, $db;
	
	$limit = $how_many + 1;
	
	$popular_html = "<h3>" . $HELP_MOSTPOP . "</h3>\n";

	$SQL = "SELECT topic, topic_id FROM ttcm_topics ORDER BY views DESC";
	$retid2 = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid2 );
			
	if ( $number == '0' ) {
		$popular_html .= "<p>" . $HELP_NOPOP . "</p>\n";
	}
	else {
		for ( $count=1; $count<$limit; $count++ ) {

			$row2 = $db_f($retid2);
			$topic = $row2[ "topic" ];
			$topic = stripslashes($topic);
			$tid = $row2[ "topic_id" ];
	
			$popular_html .= "<p>" . $count . ". <a href=\"main.php?pg=topic&amp;tid=" . $tid . "\">" . $topic . "</a></p>\n";
		}
	}
	
	return $popular_html;
}

// GET FRONT LOGO
function front_logo() {

	global $cid, $db_q, $db_f, $db;
	
	$company = $_SESSION['admin_company'];
	
	$query = " SELECT logo FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);

	$row = $db_f($retid);
	$site_logo = $row[ "logo" ];
	
	$logolink = "<img src=\"" . $site_logo . "\" alt=\"" . $company . "\">";
	
	return $logolink;
}

// GENERATE RANDOM PASSWORD
function random_pw() {
  	
	$options = "ABCDEFGHIJKLMNOPQRSTUVWXYZabchefghjkmnpqrstuvwxyz0123456789";
  	srand((double)microtime()*1000000); 
	$i = 0;
	while ($i <= 7) {
		$num = rand() % 33;
		$tmp = substr($options, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

// RESET USER PASSWORD
function reset_pw($username) {
	
	global $cid, $db_q, $db_f, $db, $lang, $web_path, $home_dir;
	
		include( "lang/" . $lang . "/c_common.php" );
		include( "lang/" . $lang . "/c_userinfo.php" );
	
		$random_password = random_pw();
		$encpassword = md5($random_password);
		$SQL = "UPDATE ttcm_user SET password = '" . $encpassword . "' WHERE username = '" . $username . "' ";
		$retid = $db_q($db, $SQL, $cid);
							
		$SQL2 = " SELECT name, email FROM ttcm_user WHERE username = '" . $username . "' ";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$send_name = $row2[ "name" ];
		$send_name = stripslashes($send_name);
		$send_email = $row2[ "email" ];
		
		// PULL ADMIN DATA FROM DATABASE
		$query = " SELECT * FROM ttcm_admin WHERE company_id = '1' ";
		$retid = $db_q($db, $query, $cid);
		$row = $db_f($retid);
		
		$company = $row[ "company" ];
		$admin_company = stripslashes($company);
		$address1 = $row[ "address1" ];
		$admin_address1 = stripslashes($address1);
		$address2 = $row[ "address2" ];
		$admin_address2 = stripslashes($address2);
		$city = $row[ "city" ];
		$admin_city = stripslashes($city);
		$state = $row[ "state" ];
		$admin_state = stripslashes($state);
		$admin_zip = $row[ "zip" ];
		$country = $row[ "country" ];
		$admin_country = stripslashes($country);
		$admin_phone = $row[ "phone" ];
		$admin_phone_alt = $row[ "phone_alt" ];
		$admin_email = $row[ "email" ];
		$site_logo = $row[ "logo" ];
		
						$logo = $web_path . $site_logo;
						$logo_link = "<a href=\"" . $web_path . "\"><img src=\"" . $logo . "\" border=\"0\" alt=\"" . $admin_company . "\" /></a>";
						
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
						
						$subject = str_replace('[company]', $admin_company, $subject);
						
						$message = $todo_css;
						$message .= $todo_message;
						
						$address = $admin_address1;
						if ($admin_address2 != '') {
							$address .= "<br />" . $admin_address2;
						}
						
						$message = str_replace('[company]', $admin_company, $message);
						$message = str_replace('[logo]', $logo_link, $message);
						$message = str_replace('[user name]', $send_name, $message);
						$message = str_replace('[address]', $address, $message);
						$message = str_replace('[city]', $admin_city, $message);
						$message = str_replace('[state]', $admin_state, $message);
						$message = str_replace('[zip]', $admin_zip, $message);
						$message = str_replace('[phone]', $admin_phone, $message);
						$message = str_replace('[alternate phone]', $admin_phone_alt, $message);
						$message = str_replace('[website]', $admin_website, $message);
						$message = str_replace('[password]', $random_password, $message);
						$message = str_replace('[web path]', $web_link, $message);

						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

						$headers .= "From: " . $admin_company . " <" . $admin_email . ">\r\n";
					
						mail("$send_name <$send_email>",$subject,$message,$headers);
}

// COUNT NUMBER FROM TABLE
function count_number($from, $where) {

	global $cid, $db_q, $db_c, $db;

	$SQL = "SELECT * FROM $from WHERE $where ";
	$retid = $db_q($db, $SQL, $cid);
	$ret_number = $db_c( $retid );
	return $ret_number;
}

// CLIENT LOGO
function clientlogo($client_id) {

	global $db_q, $db, $cid, $db_f;

	$query = " SELECT logo FROM ttcm_client WHERE client_id = '" . $client_id . "' ";
	$retid = $db_q($db, $query, $cid);
	$row = $db_f($retid);
	$logo = $row[ "logo" ];
	
	$client = $_SESSION['client_company'];
		 
	if ($logo != '') {
		$logo_html .= "<p><img src=\"" . $logo . "\" alt=\"" . $client . "\"></p>\n";
	}
	
	return $logo_html;
}

// DISPLAY CLIENT INFORMATION
function get_client_info($client_id) {

	global $cid, $db_q, $db_f, $db, $db_c;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	if ($_SESSION['user_address1'] != '') {
		$SQL = "SELECT company FROM ttcm_client WHERE client_id = '" . $_SESSION['client_id'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		$row = $db_f($retid);
		$company = stripslashes($row[ "company" ]);
		$address1 = $_SESSION['user_address1'];
		$address2 = $_SESSION['user_address2'];
		$city = $_SESSION['user_city'];
		$state = $_SESSION['user_state'];
		$zip = $_SESSION['user_zip'];
		$country = $_SESSION['user_country'];
		$phone = $_SESSION['user_phone'];
		$phone_alt = $_SESSION['user_phone_alt'];
		$fax = $_SESSION['user_fax'];
	}
	else {
	
		$SQL = "SELECT company, address1, address2, city, state, zip, country, phone, phone_alt, fax FROM ttcm_client WHERE client_id = '" . $_SESSION['client_id'] . "' ";
		$retid = $db_q($db, $SQL, $cid);
		$row = $db_f($retid);
		$company = stripslashes($row[ "company" ]);
		$address1 = stripslashes($row[ "address1" ]);
		$address2 = stripslashes($row[ "address2" ]);
		$city = stripslashes($row[ "city" ]);
		$state = stripslashes($row[ "state" ]);
		$zip = $row[ "zip" ];
		$country = stripslashes($row[ "country" ]);
		$phone = $row[ "phone" ];
		$phone_alt = $row[ "phone_alt" ];
		$fax = $row[ "fax" ];
	}
	
	$cinfo_html = "<h3>Usu&aacute;rios e Clientes</h3>\n";
    $cinfo_html .= "<p><strong>" . $_SESSION['client_name'] . "</strong><br />\n";
    $cinfo_html .= $company . "<br />";
    $cinfo_html .= $address1;
    if ( $address2 != '' ) { 
		$cinfo_html .= "<br />" . $address2; 
	}
    $cinfo_html .= "<br />" . $city . ", " . $state . " " . $zip . "<br />" . $country;
    $cinfo_html .= "<h3>" . $COMMON_MAINPHONE . "</h3>\n";
    $cinfo_html .= "<p>" . $phone;
    if ( $phone_alt != '' ) { 
		$cinfo_html .= "<br />" . $phone_alt; 
	}
    if ( $fax != '' ) {
		$cinfo_html .= "<br />" . $COMMON_FAX . ": " . $fax; 
	}
    $cinfo_html .= "<h3>" . $COMMON_EMAIL . "</h3>\n";
    $cinfo_html .= "<p><a href=\"mailto:" . $_SESSION['client_email'] . "\">" . $_SESSION['client_email'] . "</a></p>";
	$cinfo_html .= "<h3>Outros Dados</h3>\n";
    $cinfo_html .= "<p>";
	if ( $_SESSION['aim_im'] != '' ) {
		$cinfo_html .= "<img src=\"images/aim.jpg\"> " . $_SESSION['aim_im'] . "<br />";
	}
	if ( $_SESSION['msn_im'] != '' ) {
		$cinfo_html .= "<img src=\"images/msn.jpg\"> " . $_SESSION['msn_im'] . "<br />";
	}
	if ( $_SESSION['yahoo_im'] != '' ) {
		$cinfo_html .= "<img src=\"images/yahoo.jpg\"> " . $_SESSION['yahoo_im'] . "<br />";
	}
	if ( $_SESSION['icq_im'] != '' ) {
		$cinfo_html .= "<img src=\"images/icq.jpg\"> " . $_SESSION['icq_im'] . "<br />";
	}
	if ( $_SESSION['skype_im'] != '' ) {
		$cinfo_html .= "<img src=\"images/skype.jpg\"> " . $_SESSION['skype_im'] . "<br />";
	}
	if ( ( $_SESSION['aim_im'] == '' ) && ( $_SESSION['msn_im'] == '' ) && ( $_SESSION['yahoo_im'] == '' ) && ( $_SESSION['icq_im'] == '' ) && ( $_SESSION['skype_im'] == '' ) ) {
		$cinfo_html .= $USER_NOIM;
	}
   
    $cinfo_html .= "<br /><h3>" . $USER_MODIFY . "</h3>\n";
    $cinfo_html .= "<a href=\"main.php?pg=changepw\" title=\"" . $USER_CHANGEPW . "\">" . $USER_CHANGEPW . "</a>\n";
	 
	// check if user has Client Edit permissions
	if (in_array("76", $user_perms)) {
    	$cinfo_html .= "<br /><a href=\"main.php?pg=clientmod\" title=\"" . $USER_MODCINFO . "\">" . $USER_MODCINFO . "</a>\n";
	}

	return $cinfo_html;
}

// DISPLAY ADMIN INFORMATION
function get_admin_info($company_id='') {

	global $cid, $db_q, $db_f, $db_c, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
	
	$admin_company = $_SESSION['admin_company'];
	$admin_address1 = $_SESSION['admin_address1'];
	$admin_address2 = $_SESSION['admin_address2'];
	$admin_city = $_SESSION['admin_city'];
	$admin_state = $_SESSION['admin_state'];
	$admin_zip = $_SESSION['admin_zip'];
	$admin_country = $_SESSION['admin_country'];
	$admin_phone = $_SESSION['admin_phone'];
	$admin_phone_alt = $_SESSION['admin_phone_alt'];
	$admin_fax = $_SESSION['admin_fax'];
	$admin_email = $_SESSION['admin_email'];
	$admin_aim = $_SESSION['admin_aim'];
	$admin_msn = $_SESSION['admin_msn'];
	$admin_yahoo = $_SESSION['admin_yahoo'];
	$admin_icq = $_SESSION['admin_icq'];
	$admin_skype = $_SESSION['admin_skype'];

	$ainfo_html = "<h3>" . $COMMON_ADDRESS . "</h3>\n";
    $ainfo_html .= "<p><strong>" . $admin_company . "</strong><br />\n";
    $ainfo_html .= $admin_address1 . "\n";
    if ( $admin_address2 != '' ) {
    	$ainfo_html .= "<br />" . $admin_address2 . "\n";
    }
    $ainfo_html .= "<br />" . $admin_city . ", " . $admin_state . " " . $admin_zip . "<br />" . $admin_country . "</p>\n";
    if ( $admin_phone != '' ) {
    	$ainfo_html .= "<h3>" . $COMMON_MAINPHONE . "</h3>\n";
        $ainfo_html .= "<p>" . $admin_phone . "\n";
    }
    if ( $admin_phone_alt != '' ) {
    	$ainfo_html .= "<br />" . $admin_phone_alt . "\n";
    }
    if ( $admin_fax != '' ) {
    	$ainfo_html .= "<br />" . $COMMON_FAX . ": " . $admin_fax . "\n";
    }
    if ( $admin_email != '' ) {
    	$ainfo_html .= "<h3>" . $COMMON_EMAIL . "</h3>\n";
        $ainfo_html .= "<p><a href=\"mailto:" . $admin_email . "\">" . $admin_email . "</a></p>\n";
    }
	$ainfo_html .= "<h3>" . $COMMON_IM . "</h3>\n<p>";
	if ( ( $admin_aim != '' ) || ( $admin_msn != '' ) || ( $admin_yahoo != '' ) || ( $admin_icq != '' ) || ( $admin_skype != '' ) ) {
		if ( $admin_aim != '' ) {
			$ainfo_html .= "<img src=\"images/aim.jpg\"> " . $admin_aim . "<br />";
		}
		if ( $admin_msn != '' ) {
			$ainfo_html .= "<img src=\"images/msn.jpg\"> " . $admin_msn . "<br />";
		}
		if ( $admin_yahoo != '' ) {
			$ainfo_html .= "<img src=\"images/yahoo.jpg\"> " . $admin_yahoo . "<br />";
		}
		if ( $admin_icq != '' ) {
			$ainfo_html .= "<img src=\"images/icq.jpg\"> " . $admin_icq . "<br />";
		}
		if ( $admin_skype != '' ) {
			$ainfo_html .= "<script type=\"text/javascript\" src=\"http://download.skype.com/share/skypebuttons/js/skypeCheck.js\"></script>\n";
			$ainfo_html .= "<img src=\"http://mystatus.skype.com/smallicon/" . $admin_skype . "\"> <a href=\"skype:" . $admin_skype . "?call\" onclick=\"return skypeCheck();\">" . $admin_skype . "</a>";
		}
	}
	else {
		$ainfo_html .= $USER_NOIM;
	}
	$ainfo_html .= "</p>\n<h3>" . $COMMON_WEBSITES . "</h3>\n";

	 $SQL2 = " SELECT website FROM ttcm_websites WHERE client_id = '0' ORDER BY website";
	 $retid2 = $db_q($db, $SQL2, $cid);
	 $number = $db_c( $retid2 );
	
	 if ($number == '0') { 
		 $ainfo_html .= "<h3>" . $USER_NOWEB . "</h3>";
	 }
	 else {
		while ( $row2 = $db_f($retid2) ) {
			$website = $row2[ "website" ];
			$ainfo_html .= "<a href=\"javascript:newWin('http://" . $website . "');\" title=\"" . $website . "\">" . $website . "</a><br />\n";	
		}
    }
    return $ainfo_html;
}

// SEARCH BOX
function searchbox($for, $search_title, $instruct) {

	global $cid, $db_q, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_search.php" );

	$search_html = "<h3>" . $search_title . " " . $COMMON_SEARCH . "</h3>\n";
    $search_html .= "<form name=\"search\" action=\"main.php?pg=search\" method=\"POST\">\n";
    $search_html .= "<input type=\"hidden\" name=\"for\" value=\"" . $for . "\" class=\"input-box\">\n";
    $search_html .= "<p>" . $instruct . "</p>\n";
    
    if ( $for == 'download' ) {
		$SQL = "SELECT file_type, type_id FROM ttcm_filetype ORDER BY file_type";
		$retid = $db_q($db, $SQL, $cid);
									
		$type_string = "<option value=\"0\">" . $DOWNLOADS_ALLTYPES . "</option>\n";
		while( $my_type = $db_f( $retid ) )
		{
			$type_id = $my_type[ "type_id" ];
			$type_title = $my_type[ "file_type" ];
	
			$type_string .= "<option value=\"" . $type_id . "\">" . $type_title . "</option>\n";
		}
		$search_html .= "<p><select name=\"type\" class=\"select-box\">" . $type_string . "</select></p>\n";
	}
	
    $search_html .= "<input type=\"text\" size=\"15\" class=\"input-box\" name=\"search\"> <input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\">\n";
    $search_html .= "</form>\n";
	
	return $search_html;
}

// PROJECT TITLE PULLDOWN MENU
function project_pulldown($client_id) {

	global $cid, $db_q, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	
	$SQL = " SELECT title FROM ttcm_project WHERE client_id = '" . $client_id . "' ORDER BY title ";
	$retid = $db_q($db, $SQL, $cid);
																
	$project_string = "<option value=\"" . $UPLOADS_NOPROJECT . "\">" . $UPLOADS_NOPROJECT . "</option>\n";

	while( $my_project = $db_f( $retid ) ) {
		$project_title = $my_project[ "title" ];
		$project_title = stripslashes($project_title);

		$project_string .= "<option value=\"" . $project_title . "\">" . $project_title . "</option>\n";
	}
	$project_menu = "<select name=\"project\" class=\"select-box\">" . $project_string . "</select>\n";
	
	return $project_menu;
}
?>