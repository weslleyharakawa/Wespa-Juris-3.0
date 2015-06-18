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

// CHECK FOR CHOSEN CLIENT PROJECTS
function cproject_selected($clid) {
	
	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	if ( ( $clid != '' ) && ( $clid != '0' ) ) {
		$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "' ";
		$retid = $db_q($db, $query, $cid);
		$row = $db_f($retid);

		$presult = "<h1>" . $PROJECTS_PROJFOR . " " . stripslashes($row[ 'company' ]) . "</h1>\n";
	}
	else {
		$presult = "<h1>" . $PROJECTS_PROJECTS . "</h1>\n";
	}
	
	return $presult;
}

// CHECK FOR CHOSEN CLIENT PROJECTS
function ctask_selected($clid, $tuid) {
	
	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	if ( ( $clid != '' ) && ( $clid != '0' ) ) {
		$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "' ";
		$retid = $db_q($db, $query, $cid);
		$row = $db_f($retid);
		
		$turesult = "<h1>" . $TASKS_TASKSFOR . stripslashes($row[ 'company' ]) . "</h1>\n";
	}
	else if ( $tuid != '' ) {
		if ($tuid != '0') {
			$query = "SELECT name FROM ttcm_user WHERE id = '" . $tuid . "' ";
			$retid = $db_q($db, $query, $cid);

			$row = $db_f($retid);
			$task_user = stripslashes($row[ 'name' ]);
		}
		else {
			$task_user = $COMMON_NOBODY;
		}
		$turesult = "<h1>" . $TASKS_ASSIGNEDTO . $task_user . "</h1>\n";
	}
	else {
		$turesult = "<h1>" . $TASKS_TASKS . "</h1>\n";
	}
	return $turesult;
}

// CHECK FOR CHOSEN CLIENT MESSAGES
function cmessages_selected($clid) {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	if ( $clid != '' ) {
		$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "' ";
		$retid = $db_q($db, $query, $cid);
		$row = $db_f($retid);
	
		$message_html = "<h1>" . $MESSAGES_FOR . stripslashes($row[ 'company' ]) . "</h1>\n";
	} 
	else
	{
      $message_html = "<h1>" . $COMMON_MESSAGES . "</h1>\n";
	}

	return $message_html;
}

// Exibe a lista atual de Clientes
function show_clientlist() {

	global $db, $cid, $db_q, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );

	$client_list = "<h3>" . $ADDCLIENT_LIST . "</h3>\n";
   
	$SQL = "SELECT company FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $SQL, $cid);
	
		while ( $row = $db_f($retid) ) {
			$client_list .= "<p>" . stripslashes($row[ 'company' ]) . "</p>\n";	
		}

	return $client_list;
}

// GET FRONT LOGO
function front_logo() {

	global $cid, $db_q, $db_f, $db;
	
	$query = "SELECT logo FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);
	$row = $db_f($retid);
	
	$logolink = "<img src=\"" . $row[ 'logo' ] . "\" alt=\"logo\" title=\"imagem ou foto\">";
	
	return $logolink;
}

// SHOW WEBSITES
function show_websites($client_id) {

	global $user_perms, $db, $cid, $db_q, $db_f, $db_c;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$webs = "<h3>" . $COMMON_WEBSITE . " <a href=\"main.php?pg=addwebsite&amp;clid=" . $client_id . "\" title=\"" . $COMMON_ADD . "\">[ " . $COMMON_ADD . " ]</a></h3>\n";
   
	$SQL = "SELECT client_id, web_id, website FROM ttcm_websites WHERE client_id = " . $client_id . " ORDER BY website";
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == '0') { 
		$webs .= "<p>" . $CLIENT_NOWEB . "</p>";
	}
	else {
		
		while ( $row = $db_f($retid) ) {
			$webs .= "<tr><td class=\"body\" valign=\"top\">";
			// check if user has Websites permissions
			if (in_array("33", $user_perms)) {
				$webs .= "<p><a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $row[ 'client_id' ] . "&amp;webid=" . $row[ 'web_id' ] . "&amp;task=delweb\" title=\"" . $COMMON_DELETE . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"" . $COMMON_DELETE . "\"></a> ";
			}
			$webs .= "<a href=\"javascript:newWin('http://" . $row[ 'website' ] . "');\" title=\"" . $row[ 'website' ] . "\">" . $row[ 'website' ] . "</a></p>\n";	
		}
   }

	return $webs;
}

// SHOW CURRENT HELP CATEGORIES
function current_helpcats() {

	global $db_q, $cid, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_helpsection.php" );

   	$helpcat = "<h3>" . $HELP_CATS . "</h3>\n";
   
	$SQL = "SELECT category FROM ttcm_helpcat ORDER BY category";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ($number == '0') { 
		$helpcat .= "<p>Não há Categorias</p>";
	}
	else {
		while ( $row = $db_f($retid) ) {
			$helpcat .= "<p>" . stripslashes($row[ 'category' ]) . "</p>\n";			
		}
	}

	return $helpcat;
}

// SHOW RECENT MESSAGES
function recent_posts() {

	global $db, $cid, $db_q, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

   	$recent_posts = "<h3>" . $MESSAGES_RECENTM . "</h3>\n";
   
	$SQL = "SELECT message_id, message_title FROM ttcm_messages WHERE message_id > '0' ORDER BY posted DESC LIMIT 5";
	$retid = $db_q($db, $SQL, $cid);
	
	while ( $row = $db_f($retid) ) {
		$recent_posts .= "<p><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] . "\">" . stripslashes($row[ 'message_title' ]) . "</a></p>\n";	
	}

	return $recent_posts;
}

// SHOW RECENT COMMENTS
function recent_comments() {

	global $db, $cid, $db_q, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

   	$recent_comments = "<h3>" . $MESSAGES_RECENTC . "</h3>\n";
   
	$SQL = "SELECT comment, message_id FROM ttcm_comments WHERE comment_id > '0' ORDER BY posted DESC LIMIT 5";
	$retid = $db_q($db, $SQL, $cid);
	
		while ( $row = $db_f($retid) ) {
			$comment = stripslashes($row[ 'comment' ]);
			
			$abbr_comment = substr($comment, 0, 25);
			
			$recent_comments .= "<p><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] . "\">" . $abbr_comment . "...</a></p>\n";	
		}

	return $recent_comments;
}

// CURRENCY CODE PULLDOWN MENU
function currency_pulldown($currency) {
	
	include("currency.php");

	foreach ($coptions as $key => $curr)
	{
		$curr_op = substr($curr, 0, 3);
		
		$currency_pd .= "<option value=\"" . $curr_op . "\"";
		if ( $curr_op == $currency ) {
			$currency_pd .= "SELECTED";
		}
	$currency_pd .= ">" . $curr . "</option>\n";
	}
	
	return $currency_pd;
}

// LANGUAGE PULLDOWN MENU
function language_pulldown($lang) {
	
	include("languages.php");

	foreach ($loptions as $key => $lan)
	{
		$lang_op = substr($lan, 0, 3);
		
		$language_pd .= "<option value=\"" . $lang_op . "\"";
		if ( $lang_op == $lang ) {
			$language_pd .= "SELECTED";
		}
	$language_pd .= ">" . $lan . "</option>\n";
	}
	
	return $language_pd;
}

// CLIENT PULLDOWN MENU
function client_pulldown($clid) {

	global $db_q, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );

	$query = "SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
																
	$client_string = "<option value=\"0\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

	while( $my_client = $db_f( $retid ) )
		{		
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ( $my_client[ 'client_id' ] == $clid ) {
				$client_string .= "SELECTED"; }
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}

	return $client_string;
}

// PROJECT PULLDOWN MENU
function project_pulldown($clid, $pid) {

	global $db_q, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	
	$SQL = "SELECT project_id, title FROM ttcm_project WHERE client_id = '" . $clid . "'";
	$retid2 = $db_q($db, $SQL, $cid);
							
	$project_string = "<option value=\"#\">" . $COMMON_SELECTPROJ . " ...</option>\n";

	while( $my_client = $db_f( $retid2 ) )
		{
			$project_string .= "<option value=\"" . $my_client[ 'project_id' ] . "\"";
			if ( $my_client[ 'project_id' ] == $pid ) {
				$project_string .= "SELECTED";
			}
			$project_string .= ">" . stripslashes($my_client[ 'title' ]) . "</option>\n";	
		}
	return $project_string;
}

// STATUS PULLDOWN MENU
function status_pulldown($type) {

	global $db_q, $db, $cid, $db_f;

	$SQL = "SELECT name FROM ttcm_status WHERE type = '" . $type . "' ORDER BY name";
	$retid = $db_q($db, $SQL, $cid);

	$status_string = '';
	
	while( $my_status = $db_f( $retid ) )
	{
		$status_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
		$status_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
	} 
	
	return $status_string;
}

// VISIBILITY PULLDOWN MENU
function visibility_pulldown($active) {
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	$visibility_string = '';

		$visibility_string .= "<option value=\"1\"";
		if ($active == '1') {
			$visibility_string .= " SELECTED"; 
		}
		$visibility_string .= ">" . $SETTINGS_ACTIVE . "</option>";
		$visibility_string .= "<option value=\"0\"";
		if ($active == '0') {
			$visibility_string .= " SELECTED"; 
		}
		$visibility_string .= ">" . $SETTINGS_HIDDEN . "</option>";
	
	return $visibility_string;
}

// STATUS PULLDOWN MENU
function cstatus_pulldown($type, $old_stat) {

	global $db_q, $db, $cid, $db_f;
	
	$query = "SELECT name FROM ttcm_status WHERE type = '" . $type . "' ORDER BY name";
	$retid = $db_q($db, $query, $cid);

		while( $my_status = $db_f( $retid ) )
		{
			$cstatus_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
			if ($old_stat == $my_status[ 'name' ]) {
				$cstatus_string .= " SELECTED"; }
			$cstatus_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
		}

	return $cstatus_string;
}

// HELP TOPIC PULLDOWN MENU
function help_pulldown() {

	global $db_q, $db, $cid, $db_f;

	$query = "SELECT cat_id, category FROM ttcm_helpcat ORDER BY category";
	$retid = $db_q($db, $query, $cid);
															
	$cat_string = "<option value=\"#\">" . $COMMON_SELECTCAT . " ...</option>\n";

		while( $my_cat = $db_f( $retid ) )
		{
			$cat_string .= "<option value=\"" . $my_cat[ 'cat_id' ] . "\">" . stripslashes($my_cat[ 'category' ]) . "</option>\n";
		}
		
	return $cat_string;
}

// SHOW PROJECT USERS
function project_users($pid) {
	
	global $user_perms, $db_q, $db_c, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$projusers = "<h3>" . $PROJECT_PROJUSERS;
	// check if user has User permissions
	if (in_array("3", $user_perms)) {
		$projusers .= " <a href=\"main.php?pg=projperms&amp;pid=" . $pid . "\">[ " . $COMMON_EDIT . " ]</a>";
	}
	$projusers .= "</h3>\n";

	$query = "SELECT permissions FROM ttcm_project WHERE project_id = '" . $pid . "' ";
	$retid1 = $db_q($db, $query, $cid);
	$row1 = $db_f($retid1);
	$permissions = $row1[ "permissions" ];
	$projperms = split(',', $permissions);

	foreach ($projperms as $user) {
   	
		$SQL = "SELECT username FROM ttcm_user WHERE id = '" . $user . "' ";
		$retid = $db_q($db, $SQL, $cid);
	
		$number = $db_c( $retid );
	
		if ($number == '0') { 
			$projusers .= "<p>- " . $SEARCH_NOUSERS . "</p>"; 
		}
		else {
			$row = $db_f($retid);
			$projusers .= "- " . $row[ 'username' ] . "<br />";
		}
	}
	
	return $projusers;
}

// DEFAULT SIDE SETTINGS
function side_defsettings($serverdiff) {

	global $db_q, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	$query = "SELECT serverdiff, date_format, file_ext FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);

	$row = $db_f($retid);
	$old_serverdiff = $row[ "serverdiff" ];
	$old_dateformat = $row[ "date_format" ];
	$old_extensions = $row[ "file_ext" ];

	$now_time = date("Y/m/d G:i:s");
	$you_time = date("Y/m/d G:i:s", time() + $old_serverdiff * 60 * 60);
	
	$sidesettings .= "<FORM NAME=\"savedefset\" ACTION=\"main.php?pg=settings\" METHOD=\"POST\">\n";
	$sidesettings .= "<input type=\"hidden\" name=\"task\" value=\"defsideset\">\n";
	$sidesettings .= "<h3>" . $SETTINGS_TIMEOFFSET . "</h3>\n";
   	$sidesettings .= "<p>" . $SETTINGS_ENTERTIME . "</p>\n";
	$sidesettings .= "<p><strong>" . $SETTINGS_SERVERTIME . ":</strong><br />" . $now_time . "</p>\n";
	$sidesettings .= "<p><strong>" . $SETTINGS_YOURTIME . ":</strong><br />" . $you_time . "</p>\n";
	$sidesettings .= "<p><input type=\"text\" name=\"new_serverdiff\" size=\"5\" value=\"" . $old_serverdiff . "\" class=\"input-box\"> horas</p>\n";
	$sidesettings .= "<h3>" . $SETTINGS_DATEFORMAT . "</h3>\n";
   	$sidesettings .= "<p>" . $SETTINGS_DATEINSTRUCT . "</p>\n";
	$sidesettings .= "<p><select name=\"new_dateformat\" class=\"body\">";
	$sidesettings .= "<option value=\"%c/%e/%Y\"";
	if ($old_dateformat == '%c/%e/%Y' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">MM/DD/YYYY</option>\n";
	$sidesettings .= "<option value=\"%e/%c/%Y\"";
	if ($old_dateformat == '%e/%c/%Y' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">DD/MM/YYYY</option>\n";
	$sidesettings .= "<option value=\"%Y/%c/%e\"";
	if ($old_dateformat == '%Y/%c/%e' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">YYYY/MM/DD</option>\n";
	$sidesettings .= "<option value=\"%c/%e/%y\"";
	if ($old_dateformat == '%c/%e/%y' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">MM/DD/YY</option>\n";
	$sidesettings .= "<option value=\"%e/%c/%y\"";
	if ($old_dateformat == '%e/%c/%y' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">DD/MM/YY</option>\n";
	$sidesettings .= "<option value=\"%y/%c/%e\"";
	if ($old_dateformat == '%y/%c/%e' ) {
		$sidesettings .= " SELECTED";
	}
	$sidesettings .= ">YY/MM/DD</option>\n";
	$sidesettings .= "</select></p>\n";
	$sidesettings .= "<h3>" . $SETTINGS_ALLOWEDEXT . "</h3><p>" . $SETTINGS_EXTDESC . "</p>\n";
	$sidesettings .= "<p><input type=\"text\" name=\"new_extensions\" size=\"25\" value=\"" . $old_extensions . "\" class=\"input-box\"></p>\n";
	$sidesettings .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVESET . "\"></p>\n";
   	$sidesettings .= "</FORM>\n";

	return $sidesettings;
}

// APPEARANCE SIDE SETTINGS
function side_appsettings() {

	global $db_q, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	$query = "SELECT outcolor, overcolor FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);

	$row = $db_f($retid);
	$old_outcolor = $row[ "outcolor" ];
	$old_overcolor = $row[ "overcolor" ];

	$sidesettings .= "<FORM NAME=\"saveappset\" ACTION=\"main.php?pg=appearance\" METHOD=\"POST\">\n";
	$sidesettings .= "<input type=\"hidden\" name=\"task\" value=\"appsideset\">\n";
	$sidesettings .= "<h3>" . $SETTINGS_COLORSET . "</h3>\n";
	$sidesettings .= "<p>" . $SETTINGS_ROLLOVER . "<br />\n";
	$sidesettings .= "<input type=\"text\" name=\"new_overcolor\" size=\"10\" value=\"" . $old_overcolor . "\" class=\"input-box\">\n";
	$sidesettings .= "<p>" . $SETTINGS_ROLLOUT . "<br />\n";
	$sidesettings .= "<input type=\"text\" name=\"new_outcolor\" size=\"10\" value=\"" . $old_outcolor . "\" class=\"input-box\">\n";
	$sidesettings .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVESET . "\"></p>\n";
   	$sidesettings .= "</FORM>\n";

	return $sidesettings;
}

// PROJECTS BY CLIENT
function choose_cproject($clid) {
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$client_menu = client_pulldown("$clid");
	
	$byclient .= "<h3>" . $PROJECTS_BYCLIENT . "</h3>\n";
   	$byclient .= "<p>" . $PROJECTS_SELECTCLIENT . "</p>\n";
	$byclient .= "<FORM NAME=\"search\" ACTION=\"main.php?pg=projects\" METHOD=\"POST\">\n";
	$byclient .= "<p><select name=\"clid\" class=\"select-box\">" . $client_menu . "</select></p>\n";
   	$byclient .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
   	$byclient .= "</FORM>\n";

	return $byclient;
}

// SIDE STATUS OPTION
function side_status() {
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
   	$add_status = "<h3>" . $STATUS_ADDOPTION . "</h3>\n";
   	$add_status .= "<p>" . $STATUS_ADDINSTRUCT . "</p>\n";
   	$add_status .= "<FORM NAME=\"add\" ACTION=\"main.php?pg=status\" METHOD=\"POST\">\n";
	$add_status .= "<input type=\"hidden\" name=\"task\" value=\"addstat\">\n";
   	$add_status .= "<p><select name=\"type\" class=\"select-box\">\n";
   	$add_status .= "<option value=\"account\" SELECTED>" . $COMMON_ACCOUNT . "</option>\n";
   	$add_status .= "<option value=\"project\">" . $COMMON_PROJECT . "</option>\n";
   	$add_status .= "<option value=\"tasks\">" . $COMMON_TASK . "</option>\n";
	if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {
		$add_status .= "<option value=\"invoice\">" . $COMMON_INVOICE . "</option></select></p>\n";
	}
	if ( ($_SESSION["mod2_installed"] == '1') && ($_SESSION["mod2_active"] == '1') ) {
		$add_status .= "<option value=\"invoice\">" . $COMMON_INVOICE . "</option></select></p>\n";
	}
   	$add_status .= "<p><input type=\"text\" size=\"20\" class=\"input-box\" name=\"name\"></p>\n";
   	$add_status .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $STATUS_ADDSTATUS . "\"></p>\n";
   	$add_status .= "</FORM>\n";

	return $add_status;
}

// COMPANY LOGO SETTINGS
function logo_settings() {

	global $db_q, $db, $cid, $db_f, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

   	$logo_html = "<h3>$LOGO_SITELOGO <a href=\"main.php?pg=alogo\" title=\"editar imagem foto ou logo\">[ " . $COMMON_EDIT . " ]</a></h3>\n";

	$query = "SELECT logo FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);
	$row = $db_f($retid);
		 
	if ( $row[ 'logo' ] != '') {
		
		$logo_link = $web_path . $row['logo'];
		$logo_html .= "<p><img src=\"" . $logo_link . "\" alt=\"logo\"></p>\n";
	} else {
		$logo_html .= "<p>" . $LOGO_NOLOGO . "</p>\n";
	}
	
	return $logo_html;
}

// CLIENT LOGO SETTINGS
function client_logo($clid) {

	global $db_q, $db, $cid, $db_f, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

   	$logo_html = "<h3>" . $LOGO_CLIENTLOGO . " <a href=\"main.php?pg=clogo&amp;clid=" . $_GET['clid'] . "\" title=\"imagem ou foto\">[ " . $COMMON_EDIT . " ]</a></h3>\n";

	$query = "SELECT logo FROM ttcm_client WHERE client_id = '" . $_GET['clid'] . "' ";
	$retid = $db_q($db, $query, $cid);
	$row = $db_f($retid);
	
	$logo_link = $web_path . $row[ 'logo' ];
		 
	if ( $row[ 'logo' ] != '' ) {
		$logo_html .= "<p><img src=\"" . $logo_link . "\" alt=\"logo\"></p>\n";
	} else {
		$logo_html .= "<p>" . $LOGO_NOLOGO . "</p>\n";
	}
	
	return $logo_html;
}

// MESSAGES BY CLIENT
function messages_byclient() {

	global $db_q, $db, $cid, $db_f;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );
	
	$byclient = "<h3>" . $MESSAGES_BYCLIENT . "</h3>\n";
   	$byclient .= "<p>" . $MESSAGES_SELECT . "</p>\n";

	$client_string = client_pulldown("$clid");
	
	$byclient .= "<FORM NAME=\"search\" ACTION=\"main.php?pg=" . $_GET['pg'] . "\" METHOD=\"POST\">\n";
	$byclient .= "<p><select name=\"clid\" class=\"select-box\">" . $client_string . "</select></p>\n";
   	$byclient .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
   	$byclient .= "</FORM>\n";

	return $byclient;
}

// SEARCH BOX
function searchbox($for, $search_title, $instruct) {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	$search_html = "<h3>" . $search_title . "</h3>\n";
    $search_html .= "<form name=\"search\" action=\"main.php?pg=search\" method=\"POST\">\n";
    $search_html .= "<p><input type=\"hidden\" name=\"for\" value=\"" . $for . "\"></p>\n";
    $search_html .= "<p>" . $instruct . "</p>\n";
    
    if ( $for == 'download' ) {
		$SQL = "SELECT file_type, type_id FROM ttcm_filetype ORDER BY file_type ";
		$retid = $db_q($db, $SQL, $cid);
									
		$type_string = "<option value=\"0\">" . $FILETYPES_ALLTYPES . "</option>\n";
		while( $my_type = $db_f( $retid ) )
		{		
			$type_string .= "<option value=\"" . $my_type[ 'type_id' ] . "\">" . stripslashes($my_type[ 'file_type' ]) . "</option>\n";
		}
		$search_html .= "<p><select name=\"type\" class=\"select-box\">" . $type_string . "</select></p>\n";
	}
	
    $search_html .= "<p><input type=\"text\" size=\"15\" class=\"input-box\" name=\"search\"></p>";
	$search_html .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
    $search_html .= "</FORM>\n";
	
	return $search_html;
}

// CLIENT TASK SELECT
function choose_ctasks() {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

   	$tmenu = "<h3>" . $TASKS_BYCLIENT . "</h3>\n";
   	$tmenu .= "<p>" . $TASKS_BYCINSTRUCT . "</p>\n";

	$query = "SELECT client_id, company FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
																
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

	while( $my_client = $db_f( $retid ) )
	{
		$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
	}
	
	$tmenu .= "<FORM NAME=\"search\" ACTION=\"main.php?pg=alltasks\" METHOD=\"POST\">\n";
	$tmenu .= "<p><select name=\"clid\" class=\"select-box\">" . $client_string . "</select></p>\n";
   	$tmenu .= "<p><input type=\"submit\" class=\"submit-button\" VALUE=\"" . $COMMON_SEARCH . "\"></p>\n";
   	$tmenu .= "</FORM>\n";

	return $tmenu;
}

// USER TASK SELECT
function choose_utasks() {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

   	$tmenu = "<h3>" . $TASKS_BYUSER . "</h3>\n";
   	$tmenu .= "<p>" . $TASKS_BYUINSTRUCT . "</p>\n";

	$query = "SELECT id, name FROM ttcm_user WHERE type = '1' ORDER BY name";
	$retid = $db_q($db, $query, $cid);
																
	$user_string = "<option value=\"#\">" . $COMMON_SELECTUSER . " ...</option>\n";
	$user_string .= "<option value=\"0\">" . $COMMON_NOASSIGN . "</option>\n";

	while( $my_user = $db_f( $retid ) )
	{
		$user_string .= "<option value=\"" . $my_user[ 'id' ] . "\">" . stripslashes($my_user[ 'name' ]) . "</option>\n";
	}
	
	$tmenu .= "<FORM NAME=\"search\" ACTION=\"main.php?pg=alltasks\" METHOD=\"POST\">\n";
	$tmenu .= "<p><select name=\"tuid\" class=\"select-box\">" . $user_string . "</select></p>\n";
   	$tmenu .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
   	$tmenu .= "</FORM>\n";

	return $tmenu;
}

// CLIENT FILES SELECT
function choose_cfiles() {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

   	$choose_html = "<h3>" . $FILES_BYCLIENT . "</h3>\n";
   	$choose_html .= "<p>" . $FILES_BYINSTRUCT . "</p>\n";

	$query = "SELECT client_id, company FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
							
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

	while( $my_client = $db_f( $retid ) )
	{			
		$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
	}
	
	$choose_html .= "<FORM NAME=\"search\" ACTION=\"main.php?pg=files\" METHOD=\"POST\">\n";
	$choose_html .= "<p><select name=\"clid\" class=\"select-box\">" . $client_string . "</select></p>\n";
   	$choose_html .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
   	$choose_html .= "</FORM>\n";

   	$choose_html .= "<h3>" . $FILESBYTYPE_HEADER . "</h3>\n";
   	$choose_html .= "<p>" . $FILESBYTYPE_INSTRUCT . "</p>\n";
	$choose_html .= "<p><a href=\"main.php?pg=filesbytype\" title=\"" . $FILESBYTYPE_HEADER . "\">" . $FILESBYTYPE_HEADER . "</a></p>\n";

	return $choose_html;
}

// GET COMPANY NAME
function company_name($clid) {

	global $cid, $db_q, $db_f, $db;
	
	$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "' ";
	$retid = $db_q($db, $query, $cid);
	$row = $db_f($retid);
	$client_company = stripslashes($row[ 'company' ]);
	
	return $client_company;
}

// PROJECT STATUS PULL-DOWN
function project_statusmenu($status) {

	global $cid, $db_q, $db_f, $db;

	$query = "SELECT name FROM ttcm_status WHERE type = 'project' ORDER BY name";
	$retid = $db_q($db, $query, $cid);

	$status_string = '';
	
	while( $my_status = $db_f( $retid ) )
	{
		$status_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
			if ( $status == $my_status[ 'name' ] )
			{
				$status_string .= " SELECTED";
			}
			$status_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
	}
	return $status_string;
}

// DISPLAY ADMIN INFORMATION
function get_admin_info($company_id='') {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	
	if ($_SESSION['user_address1'] != '') {
		$company = $_SESSION['admin_company'];
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
		$company = $_SESSION['admin_company'];
		$address1 = $_SESSION['admin_address1'];
		$address2 = $_SESSION['admin_address2'];
		$city = $_SESSION['admin_city'];
		$state = $_SESSION['admin_state'];
		$zip = $_SESSION['admin_zip'];
		$country = $_SESSION['admin_country'];
		$phone = $_SESSION['admin_phone'];
		$phone_alt = $_SESSION['admin_phone_alt'];
		$fax = $_SESSION['admin_fax'];
	}

	$ainfo_html = "<h3>" . $COMMON_ADDRESS . "</h3>\n";
    $ainfo_html .= "<p><strong>" . $company . "</strong><br />\n";
    $ainfo_html .= $address1 . "\n";
    if ( $address2 != '' ) {
    	$ainfo_html .= "<br />" . $address2 . "\n";
    }
    $ainfo_html .= "<br />" . $city . ", " . $state . " " . $zip . "<br />" . $country . "</p>\n";
    if ( $phone != '' ) {
    	$ainfo_html .= "<h3>" . $COMMON_PHONE . "</h3>\n";
      	$ainfo_html .= "<p>" . $phone . "\n";
    }
    if ( $phone_alt != '' ) {
    	$ainfo_html .= "<br />" . $phone_alt . "\n";
    }
    $ainfo_html .= "</p>\n";
    if ( $fax != '' ) {
    	$ainfo_html .= "<p>" . $COMMON_FAX . ": " . $fax . "</p>\n";
    }
    if ( $_SESSION['user_email'] != '' ) {
    	$ainfo_html .= "<h3>" . $COMMON_EMAIL . "</h3>\n";
		$ainfo_html .= "<p><a href=\"mailto:" . $_SESSION['user_email'] . "\" title=\"" . $COMMON_EMAIL . "\">" . $_SESSION['user_email'] . "</a></p>\n";
    }
	 	$ainfo_html .= "<h3>" . $COMMON_IM . "</h3>\n<p>";
			if ( $_SESSION['aim_im'] != '' ) {
				$ainfo_html .= "<img src=\"../images/aim.jpg\" alt=\"" . $COMMON_AIM . "\"> " . $_SESSION['aim_im'] . "<br />";
			}
			if ( $_SESSION['msn_im'] != '' ) {
				$ainfo_html .= "<img src=\"../images/msn.jpg\" alt=\"" . $COMMON_MSN . "\"> " . $_SESSION['msn_im'] . "<br />";
			}
			if ( $_SESSION['yahoo_im'] != '' ) {
				$ainfo_html .= "<img src=\"../images/yahoo.jpg\" alt=\"" . $COMMON_YAHOO . "\"> " . $_SESSION['yahoo_im'] . "<br />";
			}
			if ( $_SESSION['icq_im'] != '' ) {
				$ainfo_html .= "<img src=\"../images/icq.jpg\" alt=\"" . $COMMON_ICQ . "\"> " . $_SESSION['icq_im'] . "<br />";
			}
			if ( $_SESSION['skype_im'] != '' ) {
				$ainfo_html .= "<img src=\"../images/skype.jpg\" alt=\"" . $COMMON_SKYPE . "\"> " . $_SESSION['skype_im'] . "<br />";
			}
		$ainfo_html .= "</p>";
    
    return $ainfo_html;
}

// FILE TYPE SELECTION BOX
function filetypes_search() {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );
	
	$ftsearch = "<h3>" . $FILESBYTYPE_HEADER . "</h3>\n";
   	$ftsearch .= "<p>" . $FILESBYTYPE_BYINSTRUCT . "</p>\n";

	$query = "SELECT type_id, file_type FROM ttcm_filetype ORDER BY file_type";
	$retid = $db_q($db, $query, $cid);
							
	$type_string = "<option value=\"#\">" . $COMMON_SELECTFILETYPE . " ...</option>\n";

	while( $my_type = $db_f( $retid ) )
	{
		$type_string .= "<option value=\"" . $my_type[ 'type_id' ] . "\">" . stripslashes($my_type[ 'file_type' ]) . "</option>\n";
	}
		
	$ftsearch .= "<FORM NAME=\"search\" ACTION=\"all_type.php\" METHOD=\"POST\">\n";
	$ftsearch .= "<p><select name=\"type_id\" class=\"select-box\">" . $type_string . "</select></p>\n";
    $ftsearch .= "<p><input type=\"submit\" class=\"submit-button\" value=\"" . $COMMON_SEARCH . "\"></p>\n";
    $ftsearch .= "</FORM>\n";

	return $ftsearch;
}

// DISPLAY HELP CATEGORIES
function help_categories() {

	global $cid, $db_q, $db_f, $db_c, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_helpsection.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$help_cats = "<h3>" . $HELP_CATS . " <a href=\"main.php?pg=addhelpcat\">[ " . $COMMON_ADD . " ]</a></h3>\n";
	
	$SQL = "SELECT cat_id, category FROM ttcm_helpcat ORDER BY category";
	$retid = $db_q($db, $SQL, $cid);

	$number = $db_c( $retid );
	
	while ( $row = $db_f($retid) ) {
		// check if user has Help permissions
		if (in_array("65", $user_perms)) {
			$help_cats .= "<a href=\"main.php?pg=help&amp;catid=" . $row[ 'cat_id' ] . "&amp;task=delhcat\" title=\"excluir " . stripslashes($row[ 'category' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a> ";
		}
		$help_cats .= stripslashes($row[ 'category' ]) . "<br />\n";	
	}
   
	$help_cats .= "<p><em>" . $HELP_NOTE . "</em></p>\n";
	
	return $help_cats;
}

// SHOW FILE TYPES
function show_filetypes() {

	global $cid, $db_q, $db_f, $db_c, $db;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

   	$show_types = "<h3>" . $FILETYPES_HEADER . " <a href=\"main.php?pg=filetypes\" title=\"adicionar tipo de documento\">[ " . $COMMON_ADD . " ]</a></h3>\n";
   
	$SQL = "SELECT file_type FROM ttcm_filetype ORDER BY file_type";
	$retid = $db_q($db, $SQL, $cid);
	
	while ( $row = $db_f($retid) ) 
	{
		$show_types .= "- " . stripslashes($row[ 'file_type' ]) . "<br />\n";
	}

	return $show_types;
}

// TOPIC PULL-DOWN
function help_topicmenu($catid) {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_helpsection.php" );
 
	$query = "SELECT cat_id, category FROM ttcm_helpcat ORDER BY category";
	$retid = $db_q($db, $query, $cid);
	
	$option = '';
								
	$cat_string = "<option value=\"#\">" . $COMMON_SELECTCAT . " ...</option>\n";

	while( $my_cat = $db_f( $retid ) )
	{	
		if ( $my_cat[ 'cat_id' ] == $catid ) {
			$option = ' SELECTED';
		}
		
		$cat_string .= "<option value=\"" . $my_cat[ 'cat_id' ] . "\" " . $option . ">" . stripslashes($my_cat[ 'category' ]) . "</option>\n";	
			$option = '';
	}
		
	return $cat_string;
}

// SHOW USERS FOR CLIENT
function cl_users($client_id) {

	global $cid, $db_q, $db_f, $db_c, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );

	$cusers = "<h3>" . $CLIENT_USERS . "</h3>\n";
   
	$SQL = "SELECT username FROM ttcm_user WHERE client_id = '" . $client_id . "' ORDER BY username";
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	$count = 0;
	
	if (!$retid) { echo( mysql_error()); }
	else {
		while ( ( $row = $db_f($retid) ) AND ( $count < 15 ) ) {
			$cusers .= "<p>- " . $row[ 'username' ] . "</p>\n";
			$count++;
		}
	}
	$cusers .= "<p><a href=\"main.php?pg=allusers\" title=\"" . $COMMON_VIEWALL . "\">" . $COMMON_VIEWALL . "</a></p>\n";
	
	return $cusers;
}

// SHOW CLIENT INFO
function client_info($clid) {

	global $cid, $db_q, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$query = "SELECT company, address1, address2, city, state, zip, country, phone, phone_alt, fax FROM ttcm_client WHERE client_id = '" . $clid . "' ";
	$retid = $db_q($db, $query, $cid);
	
		$row = $db_f($retid);
		
		$cinfo = "<h2>" . $CLIENT_INFO . " <a href=\"main.php?pg=editclient&amp;clid=" . $clid . "\" title=\"editar " . stripslashes($row[ 'company' ]) . "\">[ " . $COMMON_EDIT . " ]</a></h2>\n";
		$cinfo .= "<h3>" . $COMMON_ADDRESS . "</h3>\n";
		$cinfo .= "<p><strong>" . stripslashes($row[ 'company' ]) . "</strong><br />\n";
      	$cinfo .= stripslashes($row[ 'address1' ]) . "\n";
      
		if ( $row[ 'address2' ] != '' ) {
			$cinfo .= "<br />" . stripslashes($row[ 'address2' ]) . "\n";
		}
      	$cinfo .= "<br />" . stripslashes($row[ 'city' ]) . ", " . stripslashes($row[ 'state' ]) . " " . $row[ 'zip' ] . "<br />" . stripslashes($row[ 'country' ]) . "</p>\n";
		$cinfo .= "<h3>" . $COMMON_PHONE . "</h3>\n";
		$cinfo .= "<p>" . $row[ 'phone' ] . "\n";
      
		if ( $row[ 'phone_alt' ] != '' ) {
			$cinfo .= "<br />" . $row[ 'phone_alt' ];
		}
		if ( $row[ 'fax' ] != '' ) {
			$cinfo .= "<br />" . $COMMON_FAX . ": " . $row[ 'fax' ] . "</p>";
		}
		
		return $cinfo;
}

// SHOW CLIENT LINKS
function client_links($clid) {

	global $cid, $db_q, $db_f, $db_c, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$ulfiles = "<h3>" . $CLIENT_LINKS;
	// check if user has Link permissions
	if (in_array("37", $user_perms)) {
		$ulfiles .= " <a href=\"main.php?pg=addlink&amp;clid=" . $clid . "\" title=\"adicionar link externo a um website\">[ " . $COMMON_ADD . " ]</a>";
	}
	$ulfiles .= "</h3>\n";
   
	$SQL = "SELECT link_id, link_title, link FROM ttcm_links WHERE client_id = '" . $clid . "' ORDER BY link_title";
	$retid = $db_q($db, $SQL, $cid);

	$number = $db_c( $retid );

	$count = 0;
	
	if (!$retid) { echo( mysql_error()); }
	else {
	
		if ( $number == '0' ) {
			$ulfiles .= "<p>" . $CLIENT_NOLINKS . "</p>\n";
   		} 
		else {
	
			while ( $row = $db_f($retid) ) {
				// check if user has Link permissions
				if (in_array("38", $user_perms)) {
					$ulfiles .= "<p><a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;linkid=" . $row[ 'link_id' ] . "&amp;task=dellink\" title=\"excluir " . stripslashes($row[ 'link_title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a> ";
				}
				$ulfiles .= "<a href=\"javascript:newWin('http://" . $row[ 'link' ] . "');\" title=\"abrir " . stripslashes($row[ 'link_title' ]) . "\">" . stripslashes($row[ 'link_title' ]) . "</a>\n";
			}
		}
	}
	
	return $ulfiles;
}

// SHOW CLIENT UPLOADED FILES
function uploaded_files($clid) {

	global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$ulfiles = "<h3>" . $CLIENT_UPLOADEDFILES . "</h3>\n";
   
	$SQL = "SELECT file_id, link, name FROM ttcm_cfiles WHERE client_id = '" . $clid . "' ORDER BY name";
	$retid = $db_q($db, $SQL, $cid);

	$number = $db_c( $retid );
	$count = 0;
	
	if (!$retid) { echo( mysql_error()); }
	else {
		if ( $number == '0' ) {
			$ulfiles .= "<p>" . $CLIENT_NOULFILES . "</p>\n";
   	} 
		else {
			while ( $row = $db_f($retid) ) {
				$ulfiles .= "<p>";
				$file_link = $web_path . $row[ 'link' ];

				// check if user has Client Files permissions
				if (in_array("40", $user_perms)) {
					$ulfiles .= "<a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delcfile\" title=\"excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a> ";
				}
				$ulfiles .= "<a href=\"javascript:newWin('" . $file_link . "');\" title=\"ver " . stripslashes($row[ 'name' ]) . "\">" . stripslashes($row[ 'name' ]) . "</a></p>\n";
			}
		}
	}
	
	return $ulfiles;
}
?>