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

switch ($ftype) {

// ADMIN DATA
	case admindata:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$query = " SELECT company, address1, address2, city, state, zip, country, phone, phone_alt, fax, email, aim, icq, msn, yahoo, skype FROM ttcm_admin WHERE company_id = '1' ";
	$retid = $db_q($db, $query, $cid);

	$row = $db_f($retid);
	$old_admin_email = $row[ 'email' ];
	$old_aol = $row[ 'aim' ];
	$old_icq = $row[ 'icq' ];
	$old_msn = $row[ 'msn' ];
	$old_yahoo = $row[ 'yahoo' ];
	$old_skype = $row[ 'skype' ];

	echo ("<FORM NAME=\"edit\" ACTION=\"main.php?pg=editadmin\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"saveadmin\">
	<input type=\"hidden\" name=\"company_id\" value=\"1\">
	<br />
	<h3>" . $EDITADMIN_YBUSINESS . "</h3>
	<label for=\"new_admin_company\">" . $EDITADMIN_COMPANYNAME . ":</label>
	<input type=\"text\" size=\"30\" id=\"new_admin_company\" class=\"input-box\" name=\"new_admin_company\" value=\"" . stripslashes($row[ 'company' ]) . "\">
	<br />
	<h3>" . $EDITADMIN_BLOCATION . "</h3>
	<label for=\"new_admin_address1\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" size=\"35\" id=\"new_admin_address1\" class=\"input-box\" name=\"new_admin_address1\" value=\"" . stripslashes($row[ 'address1' ]) . "\"><br />
	<label for=\"new_admin_address2\"></label>
	<input type=\"text\" size=\"35\" id=\"new_admin_address2\" class=\"input-box\" name=\"new_admin_address2\" value=\"" . stripslashes($row[ 'address2' ]) . "\"><br />
	<label for=\"new_admin_city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"new_admin_city\" class=\"input-box\" name=\"new_admin_city\" value=\"" . stripslashes($row[ 'city' ]) . "\"><br />
	<label for=\"new_admin_state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_admin_state\" class=\"input-box\" name=\"new_admin_state\" value=\"" . stripslashes($row[ 'state' ]) . "\"><br />
	<label for=\"new_admin_zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"new_admin_zip\" class=\"input-box\" name=\"new_admin_zip\" value=\"" . $row[ 'zip' ] . "\"><br />
	<label for=\"new_admin_country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"new_admin_country\" class=\"input-box\" name=\"new_admin_country\" value=\"" . stripslashes($row[ 'country' ]) . "\"><br />
	<br />
	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>
	<label for=\"new_admin_phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_admin_phone\" class=\"input-box\" name=\"new_admin_phone\" value=\"" . $row[ 'phone' ] . "\"><br />
	<label for=\"new_admin_phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_admin_phone_alt\" class=\"input-box\" name=\"new_admin_phone_alt\" value=\"" . $row[ 'phone_alt' ] . "\"><br />
	<label for=\"new_admin_fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_admin_fax\" class=\"input-box\" name=\"new_admin_fax\" value=\"" . $row[ 'fax' ] . "\"><br />
	<label for=\"new_admin_email\">" . $EDITADMIN_EMAIL . ":</label>
	<input type=\"text\" size=\"35\" id=\"new_admin_email\" class=\"input-box\" name=\"new_admin_email\" value=\"" . $row[ 'email' ] . "\"><br />
	<br />
	<input type=\"submit\" class=\"submit-button\" value=\"" . $EDITADMIN_SAVEINFO . "\">
	</FORM>");
	break;

// DEFAULT STATUS SETTINGS
	case settings:
	
		global $cid, $db_q, $db_c, $db_f, $db;

		$query = " SELECT def_aclient, def_aproject, def_projdone, def_atask, def_taskdone, def_ainvoice, def_invdone, currency, language FROM ttcm_admin WHERE company_id = '1' ";
		$retid = $db_q($db, $query, $cid);

		$row = $db_f($retid);
		$olddef_addclient = $row[ 'def_aclient' ];
		$olddef_addproject = $row[ 'def_aproject' ];
		$olddef_projdone = $row[ 'def_projdone' ];
		$olddef_addtask = $row[ 'def_atask' ];
		$olddef_taskdone = $row[ 'def_taskdone' ];
		$olddef_addinvoice = $row[ 'def_ainvoice' ];
		$olddef_invdone = $row[ 'def_invdone' ];
		$old_currency = $row[ 'currency' ];
		$old_language = $row[ 'language' ];
		
		$clientstat = cstatus_pulldown(account,"$olddef_addclient");
		$projectstat = cstatus_pulldown(project,"$olddef_addproject");
		$taskstat = cstatus_pulldown(tasks,"$olddef_addtask");
		$doneprojstat = cstatus_pulldown(project,"$olddef_projdone");
		$donetaskstat = cstatus_pulldown(tasks,"$olddef_taskdone");
		$doneinvstat = cstatus_pulldown(invoice,"$olddef_invdone");
		
		$currency_pulldown = currency_pulldown($old_currency);
		$language_pulldown = language_pulldown($old_language);

		echo ("<h1>" . $SETTINGS_DEFAULT . " <a href=\"main.php?pg=status\">[ " . $SETTINGS_EDITSTATUS . " ]</a></h1>
		<FORM NAME=\"edit\" ACTION=\"main.php?pg=settings\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"savedefault\">
		<input type=\"hidden\" name=\"company_id\" value=\"1\">
		<h3>" . $SETTINGS_ADDCLIENT . "</h3>" . $SETTINGS_ADDCLIENTINSTRUCT . ":<br />
		<select name=\"def_addclient\" id=\"def_addclient\" class=\"select-box\">" . $clientstat . "</select>

		<br /><br />
		<h3>" . $SETTINGS_ADDPROJECT . "</h3>" . $SETTINGS_ADDPROJECTINSTRUCT . ":<br />
		<select name=\"def_addproject\" id=\"def_addproject\" class=\"select-box\">" . $projectstat . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_ADDTASK . "</h3>" . $SETTINGS_ADDTASKINSTRUCT . ":<br />
		<select name=\"def_addtask\" id=\"def_addtask\" class=\"select-box\">" . $taskstat . "</select>");

		if ($_SESSION["mod1_installed"] == '1') {
			$invoicestat = cstatus_pulldown(invoice,"$olddef_addinvoice");
			echo ("<br /><br />
			<h3>" . $SETTINGS_ADDINVOICE . "</h3>" . $SETTINGS_ADDINVOICEINSTRUCT . ":<br />
			<select name=\"def_addinvoice\" id=\"def_addinvoice\" class=\"select-box\">" . $invoicestat . "</select>");
		}
		
		echo ("<br /><br />
		<h3>" . $SETTINGS_FINISHPROJ . "</h3>" . $SETTINGS_FINISHPROJINSTRUCT . ":<br />
		<select name=\"def_projectdone\" id=\"def_projectdone\" class=\"select-box\">" . $doneprojstat . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_FINISHTASK . "</h3>" . $SETTINGS_FINISHTASKINSTRUCT . ":<br />
		<select name=\"def_taskdone\" id=\"def_taskdone\" class=\"select-box\">" . $donetaskstat . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_INVOICEPD . "</h3>" . $SETTINGS_INVOICEPDINSTRUCT . ":<br />
		<select name=\"def_invdone\" id=\"def_invoice\" class=\"select-box\">" . $doneinvstat . "</select>
		
		<br /><br />
		<input type=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVEDEFAULT . "\">
		</FORM>
		<br />
		<br />
		
		<h1>" . $SETTINGS_LANGUAGECURR . "</h1>
		<FORM NAME=\"edit\" ACTION=\"main.php?pg=settings\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"savecurrency\">
		<input type=\"hidden\" name=\"company_id\" value=\"1\">
		
		<h3>" . $SETTINGS_CURRENCY . "</h3>" . $SETTINGS_CURRENCYINSTRUCT . ":<br />
		<select name=\"new_currency\" id=\"new_currency\" class=\"select-box\">" . $currency_pulldown . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_LANGUAGE . "</h3>" . $SETTINGS_LANGUAGEINSTRUCT . ":<br />
		<select name=\"new_language\" id=\"new_language\" class=\"select-box\">" . $language_pulldown . "</select>
		
		<br /><br />
		<input type=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVELANGCURR . "\">
		</FORM>");
		break;
		
// DEFAULT APPEARANCE SETTINGS
	case appsettings:
	
		global $cid, $db_q, $db_c, $db_f, $db;

		$query = " SELECT messages_active, clients_active, projects_active, files_active, help_active, upload_active FROM ttcm_admin WHERE company_id = '1' ";
		$retid = $db_q($db, $query, $cid);

		$row = $db_f($retid);
		$messages_active = $row[ 'messages_active' ];
		$clients_active = $row[ 'clients_active' ];
		$projects_active = $row[ 'projects_active' ];
		$files_active = $row[ 'files_active' ];
		$help_active = $row[ 'help_active' ];
		$uploads_active = $row[ 'upload_active' ];
		
		$messagevis = visibility_pulldown("$messages_active");
		$clientvis = visibility_pulldown("$clients_active");
		$projectvis = visibility_pulldown("$projects_active");
		$filevis = visibility_pulldown("$files_active");
		$helpvis = visibility_pulldown("$help_active");
		$uploadvis = visibility_pulldown("$uploads_active");
	
		echo ("<h1>" . $SETTINGS_BASEACTIVE . "</h1>
		<FORM NAME=\"edit\" ACTION=\"main.php?pg=appearance\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"saveappear\">
		<input type=\"hidden\" name=\"company_id\" value=\"1\">
		<h3>" . $SETTINGS_MESSAGEACTIVE . "</h3>" . $SETTINGS_MESSAGEONOFF . ":<br />
		<select name=\"vis_message\" id=\"vis_message\" class=\"select-box\">" . $messagevis . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_CLIENTSACTIVE . "</h3>" . $SETTINGS_CLIENTSONOFF . ":<br />
		<select name=\"vis_client\" id=\"vis_client\" class=\"select-box\">" . $clientvis . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_PROJECTSACTIVE . "</h3>" . $SETTINGS_PROJECTSONOFF . ":<br />
		<select name=\"vis_project\" id=\"vis_project\" class=\"select-box\">" . $projectvis . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_FILESACTIVE . "</h3>" . $SETTINGS_FILESONOFF . ":<br />
		<select name=\"vis_file\" id=\"vis_file\" class=\"select-box\">" . $filevis . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_UPLOADSACTIVE . "</h3>" . $SETTINGS_UPLOADSONOFF . ":<br />
		<select name=\"vis_upload\" id=\"vis_upload\" class=\"select-box\">" . $uploadvis . "</select>
		
		<br /><br />
		<h3>" . $SETTINGS_HELPACTIVE . "</h3>" . $SETTINGS_HELPONOFF . ":<br />
		<select name=\"vis_help\" id=\"vis_help\" class=\"select-box\">" . $helpvis . "</select>
		
		<br /><br />
		<input type=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVEVISIBLE . "\">
		
		</FORM>");
		break;

// ADD USER PERMISSION SETTINGS
	case addperms:
	
		global $cid, $db_q, $db_c, $db_f, $db;
	
		$querynam = " SELECT name, permissions, type FROM ttcm_user WHERE id = '" . $_GET['uid'] . "'";
		$retid2 = $db_q($db, $querynam, $cid);
									
		$my_client = $db_f( $retid2 );
		$old_permissions = $my_client[ 'permissions' ];
		$permtype = $my_client[ 'type' ];
		
		$getperm_vars = split(',', $old_permissions);

		echo("<h1>" . $ADDPERM_HEADER . " " . $my_client[ 'name' ] . "</h1><br />
		<FORM NAME=\"edit\" ACTION=\"main.php?pg=editperms\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"saveperms\">
		<input type=\"hidden\" name=\"uid\" value=\"" . $_GET['uid'] . "\">
		<table class=\"table\">");
		
		$query = "SELECT perm_id, section, ttcm_permfunctions.task, ttcm_permfunctions.function 
		FROM ttcm_permissions left outer join ttcm_permfunctions on ttcm_permissions.function_id = ttcm_permfunctions.function_id 
		WHERE ttcm_permissions.usertype = '" . $permtype . "' ORDER BY ttcm_permissions.section, ttcm_permfunctions.function, ttcm_permfunctions.task";
		
		$retid = $db_q($db, $query, $cid);
		
		$old_section = '';
		$old_function = '';
		
		while ($row = $db_f($retid)) {
			$perm_id = $row[ 'perm_id' ];
			
			$checked = '';
		
			if ($row[ 'section' ] != $old_section ) {
				echo("
				<tr class=\"title\">
				<td class=\"left\" colspan=\"2\">" . $row[ 'section' ] . "</td>
				</tr>");
			}
			if ($row[ 'function' ] != $old_function ) {
				echo("
				<tr>
				<td class=\"left\"><strong>" . $row[ 'function' ] . "</strong></td>
				<td class=\"left\">");
			}
			
			if (in_array($perm_id, $getperm_vars)) {
				$checked = "checked";
			}
			
			echo("<input type=\"checkbox\" name=\"perms[]\" value=\"" . $perm_id . "\" " . $checked . "> " . $row[ 'task' ] . "&nbsp; ");
				
			$old_section = $row[ 'section' ];
			$old_function = $row[ 'function' ];
		}
		
		echo("</table>
		<p><input TYPE=\"submit\" class=\"submit-button\" value=\"" . $SETTINGS_SAVEPERMS . "\"></p>
		</FORM>");
		break;
		
// ADD PROJECT PERMISSIONS
	case projectperms:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$SQL = " SELECT title, permissions FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "'";
	$retid2 = $db_q($db, $SQL, $cid);

	$my_project = $db_f( $retid2 );
	$project_perms = $my_project[ 'permissions' ];
	
	$getprojperm_vars = split(',', $project_perms);
	
	echo("<h1>" . $ADDPROJPERM_HEADER . " " . stripslashes($my_project[ 'title' ]) . "</h1>
   	<p>" . $ADDPROJPERM_MAINTEXT . "</p>
	<h2>" . $ADDPROJPERM_PERMLIST . "</h2>");
			
	echo("<FORM NAME=\"edit\" ACTION=\"main.php?pg=editperms\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addprojperms\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<table class=\"table\">
		<tr class=\"title\">
   			<td>" . $COL_ALLOW . "</td>
   			<td class=\"left\">" . $COL_NAME . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=name&amp;projperm_lby=ASC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=name&amp;projperm_lby=DESC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>
   			<td class=\"left\">" . $COL_USERNAME . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=username&amp;projperm_lby=ASC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=username&amp;projperm_lby=DESC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>
			<td class=\"left\">" . $COL_LASTLOGIN . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=last_login&amp;projperm_lby=ASC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;projperm_oby=last_login&amp;projperm_lby=DESC&amp;pid=" . $_GET['pid'] . "\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>
   		</tr>");

	$projperm_oby = $_SESSION['projperm_oby'];
	$projperm_lby = $_SESSION['projperm_lby'];
	
	$SQL = " SELECT username, id, name, last_login FROM ttcm_user WHERE type = '1' ORDER BY " . $projperm_oby . " " . $projperm_lby;
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
		while ( $row = $db_f($retid) ) {
			$last_login = $row[ 'last_login' ];
			
			$checked = '';
				
			if (in_array($row[ id ], $getprojperm_vars)) {
				$checked = "checked";
			}
			
			$SQL2 = " SELECT DATE_FORMAT('$last_login','$_SESSION[date_format] at %l:%i %p') AS last_login2 FROM ttcm_user WHERE id = '" . $row[ 'id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
	
		echo("<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">
      			<td><input type=\"checkbox\" class=\"input-box\" name=\"perms[]\" value=\"" . $row[ 'id' ] . "\" " . $checked . "></td>
				<td class=\"left\"><strong>" . $row[ 'name' ] . "</strong></td>
      			<td class=\"left\">" . $row[ 'username' ] . "</td>
				<td class=\"left\">" . $row2[ 'last_login2' ] . "</td>
      		  </tr>");
			
		}
		echo("</table>
		<br /><br />
		<input type=\"submit\" class=\"submit-button\" value=\"" . $EDITPERM_EDITPERM . "\">
		</FORM>");
	break;

// EDIT USER PERMISSION SETTINGS
	case editperms:
	
		global $cid, $db_q, $db_c, $db_f, $db;
	
		$querynam = " SELECT name, permissions, type FROM ttcm_user WHERE id = '" . $_GET['uid'] . "'";
		$retid2 = $db_q($db, $querynam, $cid);
									
		$my_client = $db_f( $retid2 );
		$old_permissions = $my_client[ 'permissions' ];
		
		$getperm_vars = split(',', $old_permissions);

		echo("<h1>" . $EDITPERM_HEADER . ": " . $my_client[ 'name' ] . "</h1><br />
		<FORM NAME=\"edit\" ACTION=\"main.php?pg=editperms\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"saveperms\">
		<input type=\"hidden\" name=\"uid\" value=\"" . $_GET['uid'] . "\">
		<table class=\"table\">");
		
		$query = "SELECT perm_id, section, ttcm_permfunctions.task, ttcm_permfunctions.function 
		FROM ttcm_permissions left outer join ttcm_permfunctions on ttcm_permissions.function_id = ttcm_permfunctions.function_id 
		WHERE ttcm_permissions.usertype = '" . $my_client[ 'type' ] . "' ORDER BY ttcm_permissions.section, ttcm_permfunctions.function, ttcm_permfunctions.task";
		
		$retid = $db_q($db, $query, $cid);
		
		$old_section = '';
		$old_function = '';
		
		while ($row = $db_f($retid)) {
			$checked = '';
		
			if ($old_section != $row[ 'section' ]) {
				echo("
				<tr class=\"title\">
				<td class=\"left\" colspan=\"2\">" . $row[ 'section' ] . "</td>
				</tr>");
			}
			if ($old_function != $row[ 'function' ]) {
				echo("
				<tr>
				<td class=\"left\"><strong>" . $row[ 'function' ] . "</strong></td>
				<td class=\"left\">");
			}
			
			if (in_array($row[ 'perm_id' ], $getperm_vars)) {
				$checked = "checked";
			}
			
			echo("<input type=\"checkbox\" name=\"perms[]\" value=\"" . $row[ 'perm_id' ] . "\" " . $checked . "> " . $row[ 'task' ] . " &nbsp; ");
				
			$old_section = $row[ 'section' ];
			$old_function = $row[ 'function' ];
		}
		
		echo("</table>
			<p><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITPERM_EDITPERM . "\"></p>
		</FORM>");
		break;

// DELETE USER
	case deleteuser:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$query = " SELECT name FROM ttcm_user WHERE id = '" . $_GET['uid'] . "'";
	$retid = $db_q($db, $query, $cid);	
	$my_client = $db_f( $retid );
	
	echo ("<div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $DUSER_SURE . " \"" . stripslashes($my_client[ 'name' ]) . "\"?</div>
	<br />" . $DUSER_CONFIRM . "<br />
	<FORM NAME=\"remove\" ACTION=\"main.php?pg=" . $_GET['pg'] . "&amp;task=deluser\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"uid\" value=\"" . $_GET['uid'] . "\">
	<input type=\"hidden\" name=\"user_name\" value=\"" . stripslashes($my_client[ 'name' ]) . "\">
	<p align=\"center\"><input type=\"submit\" class=\"submit-button\" VALUE=\"" . $DUSER_DELETE . "\"></p>
	</FORM>");
	break;
	
// DELETE PROJECT
	case deleteproject:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$query = " SELECT title FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "'";
	$retid = $db_q($db, $query, $cid);		
	$my_proj = $db_f( $retid );
	
	echo ("<div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $DPROJECT_SURE . " \"" . stripslashes($my_proj[ 'title' ]) . "\"?</div>
	<br />" . $DPROJECT_CONFIRM . "<br />
	<form name=\"remove\" action=\"main.php?pg=" . $_GET['pg'] . "&amp;task=delproj\" method=\"POST\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<input type=\"hidden\" name=\"p_name\" value=\"" . stripslashes($my_proj[ 'title' ]) . "\">
	<p align=\"center\"><input type=\"submit\" class=\"submit-button\" VALUE=\"" . $DPROJECT_DELETE . "\"></p>
	</FORM>");
	break;
	
// DELETE CLIENT
	case deleteclient:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$query1 = " SELECT company FROM ttcm_client WHERE client_id = '" . $_GET['clid'] . "'";
	$retid1 = $db_q($db, $query1, $cid);	
	$my_client = $db_f( $retid1 );
	
	echo ("<div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; " . $DCLIENT_SURE . " \"" . stripslashes($my_client[ 'company' ]) . "\"?</div>
	<br />" . $DCLIENT_CONFIRM . "<br />
	<form name=\"remove\" action=\"main.php?pg=" . $_GET['pg'] . "&amp;task=delclient\" method=\"POST\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"cl_name\" value=\"" . stripslashes($my_client[ 'company' ]) . "\">
	<p align=\"center\"><input type=\"submit\" class=\"submit-button\" value=\"" . $DCLIENT_DELETE . "\"></p>
	</form>");
	break;

// CLIENT STATUS BOX
	case clientstatus:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$SQL = " SELECT account_id, status FROM ttcm_account WHERE client_id = '" . $_GET['clid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);
	
	$SQL2 = " SELECT name, status_id FROM ttcm_status WHERE type = 'account' ORDER BY name";
	$retid = $db_q($db, $SQL2, $cid);

		while( $my_status = $db_f( $retid ) )
		{
			$status_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
			if ($status = $row[ 'status' ] == $my_status[ 'name' ]) {
				$status_string .= " selected"; }
			$status_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
		} 

		echo ("<form name=\"edit\" action=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "\" method=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"clientstatus\">
		<input type=\"hidden\" name=\"account_id\" value=\"" . $row[ 'account_id' ] . "\">" . $COMMON_ACCTSTATUS . ": 
		<select name=\"status\" class=\"body\">" . $status_string . "</select>"); 
		if (in_array("42", $user_perms)) {
			echo("<input type=\"submit\" class=\"body\" value=\"" . $COMMON_EDIT . "\">");
		}
		if (in_array("55", $user_perms)) {
			echo(" <a href=\"main.php?pg=status\">[ editar op&ccedil;&otilde;es ]</a>");
		}
		echo("</FORM>");
		break;

// EDIT FILE
	case editfile:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$SQL = " SELECT client_id, project_id, task_id, type_id, file, name, link FROM ttcm_files WHERE file_id = '" . $_GET['file_id'] . "'";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);

	$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "' ";
	$retid4 = $db_q($db, $query, $cid);
	$row4 = $db_f($retid4);
	
	if ( $row[ 'project_id' ] != '0' ) {
		$SQL2 = " SELECT title FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		
		$client_project = stripslashes($row2[ 'title' ]);
	}
	else { 
		$client_project = $COMMON_NOPROJECT; 
	}
	
	if ( $row[ 'task_id' ] != '0' ) {
		$SQL3 = " SELECT title FROM ttcm_task WHERE task_id = '" . $row[ 'task_id' ] . "'";
		$retid3 = $db_q($db, $SQL3, $cid);
		$row3 = $db_f($retid3);
		$client_task = stripslashes($row3[ 'title' ]);
	}
	else { 
		$client_task = $COMMON_NOTASK; 
	}

	$query = " SELECT file_type, type_id FROM ttcm_filetype ORDER BY file_type";
	$retid = $db_q($db, $query, $cid);

		while( $my_type = $db_f( $retid ) )
		{
			$type_string .= "<option value=\"" . $my_type[ 'type_id' ] . "\"";
			if ($my_type[ 'type_id' ] == $row[ 'type_id' ]) {
				$type_string .= " selected"; }
			$type_string .= ">" . stripslashes($my_type[ 'file_type' ]) . "</option>\n";
		} 

	echo $EDITFILE_MODIFY;
	echo ("<p><FORM NAME=\"add\" ACTION=\"main.php?pg=editfile\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"file_id\" value=\"" . $_GET['file_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editfile\">
	<h3>" . $COMMON_CLIENT . ": " . stripslashes($row4[ 'company' ]) . "</h3>
	
	<h3>" . $COMMON_PROJECT . ": " . $client_project . "</h3>
	
	<h3>" . $COMMON_TASK . ": " . $client_task . "</h3>

	<h3>" . $EDITFILE_TYPEOFFILE . "</h3>

	<label for=\"type_id\">" . $EDITFILE_TYPE . ":</label>
	<select id=\"type_id\" name=\"type_id\" class=\"select-box\">" . $type_string . "</select>

	<br /><br />
	<label for=\"file_title\">" . $EDITFILE_TITLE . ":</label>
	<input type=\"text\" id=\"file_title\" size=\"40\" class=\"input-box\" name=\"file_title\" value=\"" . stripslashes($row[ 'name' ]) . "\">

	<br /><br />
	<label for=\"link\">" . $EDITFILE_REF . "</label>
	<input type=\"text\" id=\"link\" size=\"40\" class=\"input-box\" name=\"link\" value=\"" . $row[ 'link' ] . "\">

	<br /><br />
	<input type=\"submit\" class=\"submit-button\" value=\"" . $EDITFILE_SAVEFILE . "\">
	</FORM>");
	break;

// EDIT CLIENT FORM
	case editclient:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$SQL = " SELECT company, country, address1, address2, city, state, zip, phone, phone_alt, fax FROM ttcm_client WHERE client_id = '" . $_GET['clid'] . "'";
	$retid = $db_q($db, $SQL, $cid);
	
		$row = $db_f($retid);

	echo $EDITCLIENT_INSTRUCT;
	echo ("<form name=\"add\" ACTION=\"main.php?pg=editclient&amp;clid=" . $_GET['clid'] . "\" method=\"POST\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editclient\">
	
	<h3>" . $COMMON_CLIENT . "</h3>
	
	<label for=\"company\">" . $COMMON_COMPANY . ":</label>
	<input type=\"text\" id=\"company\" size=\"30\" class=\"input-box\" name=\"company\" value=\"" . stripslashes($row[ 'company' ]) . "\">

	<h3>" . $EDITCLIENT_LOCATION . "</h3>

	<label for=\"address\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" id=\"address\" size=\"40\" class=\"input-box\" name=\"address1\" value=\"" . stripslashes($row[ 'address1' ]) . "\"><br />
	<label for=\"address2\"></label>
	<input type=\"text\" size=\"40\" id=\"address2\" class=\"input-box\" name=\"address2\" value=\"" . stripslashes($row[ 'address2' ]) . "\"><br />

	<label for=\"city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"city\" class=\"input-box\" name=\"city\" value=\"" . stripslashes($row[ 'city' ]) . "\"><br />

	<label for=\"state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"state\" class=\"input-box\" name=\"state\" value=\"" . stripslashes($row[ 'state' ]) . "\"><br />

	<label for=\"zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"zip\" class=\"input-box\" name=\"zip\" value=\"" . $row[ 'zip' ] . "\"><br />

	<label for=\"country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"country\" class=\"input-box\" name=\"country\" value=\"" . stripslashes($row[ 'country' ]) . "\">
	
	<br /><br />
	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>

	<label for=\"phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"phone\" class=\"input-box\" name=\"phone\" value=\"" . $row[ 'phone' ] . "\"></br />

	<label for=\"phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"phone_alt\" class=\"input-box\" name=\"phone_alt\" value=\"" . $row[ 'phone_alt' ] . "\"></br />

	<label for=\"fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"fax\"  class=\"input-box\" name=\"fax\" value=\"" . $row[ 'fax' ] . "\">

	<br /><br />
	<input type=\"submit\" class=\"submit-button\" value=\"" . $EDITCLIENT_SAVECLIENT . "\">
	</FORM>");
	break;

// ADD CLIENT FORM
	case addclient:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	echo ("<FORM NAME=\"add\" ACTION=\"main.php?pg=addclient\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addclient\">
	<h3>" . $COMMON_CLIENT . "</h3>

	<label for=\"company\">" . $COMMON_COMPANY . ":</label>
	<input type=\"text\" od=\"company\" size=\"30\" class=\"input-box\" name=\"company\">
	
	<br /><br />
	<h3>" . $EDITADMIN_BLOCATION . "</h3>

	<label for=\"address\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" size=\"40\" id=\"address\" class=\"input-box\" name=\"address1\"><br />
	<label for=\"address2\"></label>
	<input type=\"text\" size=\"40\" id=\"address2\" class=\"input-box\" name=\"address2\"><br />
	
	<label for=\"city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"city\" class=\"input-box\" name=\"city\"><br />
	
	<label for=\"state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"state\" class=\"input-box\" name=\"state\"><br />

	<label for=\"zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"zip\" class=\"input-box\" name=\"zip\"><br />

	<label for=\"country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"country\" class=\"input-box\" name=\"country\">

	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>

	<label for=\"phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"phone\" name=\"phone\"><br />
	
	<label for=\"phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"phone_alt\" name=\"phone_alt\"><br />
	
	<label for=\"fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"fax\" name=\"fax\"><br />
	
	<br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDCLIENT_BUTTON . "\">
	</FORM>");
	break;

// USER INFO FORM
	case yinfo:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	echo ("<FORM NAME=\"change\" ACTION=\"main.php?pg=usermod\" METHOD=\"POST\">
    <input type=\"hidden\" name=\"vid\" value=\"" . $_SESSION['valid_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"saveainfo\">
	<h3>" . $COMMON_NAME . "</h3>
	<label for=\"name\">" . $COMMON_NAME . ":</label>
	<input type=\"text\" size=\"30\" id=\"name\" name=\"name\" value=\"" . $_SESSION['admin_name'] . "\">
	<br />
	<h3>" . $COMMON_ADDRESS . "</h3>
	<label for=\"new_user_address1\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" size=\"35\" id=\"new_user_address1\" name=\"new_user_address1\" value=\"" . $_SESSION[ 'user_address1' ] . "\"><br />
	<label for=\"new_user_address2\"></label>
	<input type=\"text\" size=\"35\" id=\"new_user_address2\" name=\"new_user_address2\" value=\"" . $_SESSION[ 'user_address2' ] . "\"><br />
	<label for=\"new_user_city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"new_user_city\" name=\"new_user_city\" value=\"" . $_SESSION[ 'user_city' ] . "\"><br />
	<label for=\"new_user_state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_user_state\" name=\"new_user_state\" value=\"" . $_SESSION[ 'user_state' ] . "\"><br />
	<label for=\"new_user_zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"new_user_zip\" name=\"new_user_zip\" value=\"" . $_SESSION[ 'user_zip' ] . "\"><br />
	<label for=\"new_user_country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"new_user_country\" name=\"new_user_country\" value=\"" . $_SESSION[ 'user_country' ] . "\"><br />
	<br />
	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>
	<label for=\"new_user_phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_user_phone\" name=\"new_user_phone\" value=\"" . $_SESSION[ 'user_phone' ] . "\"><br />
	<label for=\"new_user_phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_user_phone_alt\" name=\"new_user_phone_alt\" value=\"" . $_SESSION[ 'user_phone_alt' ] . "\"><br />
	<label for=\"new_user_fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"new_user_fax\" name=\"new_user_fax\" value=\"" . $_SESSION[ 'user_fax' ] . "\"><br />
	<label for=\"new_admin_email\">" . $COMMON_EMAIL . ":</label>
	<input type=\"text\" size=\"35\" id=\"email\" name=\"email\" value=\"" . $_SESSION['user_email'] . "\"><br />
	<br />

	<input type=\"submit\" class=\"submit-button\" value=\"" . $YINFO_SAVEINFO . "\">
	</FORM>");
	break;

// ADD LOGO
	case addlogo:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	echo ("<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"main.php?pg=alogo\" METHOD=\"post\">
	<input type=\"hidden\" name=\"task\" value=\"addlogo\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $LOGO_UPLOAD . "</strong></td>
			<td valign=\"top\" class=\"body\"><br />
			<input name=\"file\" type=\"file\" size=\"25\" class=\"input-box\"></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $LOGO_CHANGE . "\"></td>
		</tr>
	</table>
	</FORM>");
	break;
	
// ADD/EDIT CLIENT LOGO
	case clogo:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	echo ("<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"main.php?pg=clogo&amp;clid=" . $_GET['clid'] . "\" METHOD=\"post\">
	<input type=\"hidden\" name=\"task\" value=\"clogo\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $LOGO_UPLOAD . "</strong></td>
			<td valign=\"top\" class=\"body\"><br />
			<input name=\"file\" type=\"file\" size=\"25\" class=\"input-box\"></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $LOGO_CHANGE . "\"></td>
		</tr>
	</table>
	</FORM>");
	break;

// ADD FILE TYPE FORM
	case addfiletype:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	echo ("<h2>" . $FILETYPES_ADDTYPE . "</h2>
	<p>" . $FILETYPES_INSTRUCT . "</p>
         <FORM NAME=\"add\" ACTION=\"main.php?pg=filetypes\" METHOD=\"POST\">
			<input type=\"hidden\" name=\"task\" value=\"addfiletype\">
         <input type=\"text\" size=\"20\" class=\"input-box\" NAME=\"file_type\"><p>
         <input type=\"submit\" class=\"body\" value=\"" . $FILETYPES_ADDNEW . "\">
         </FORM>");
	break;

// FORMULÁRIO PARA ADICIONAR NÍVEL DE USUÁRIO
	case addusertype:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	}
	else {
		$type = '0';
	}
		
	echo ("<FORM NAME=\"add\" ACTION=\"main.php?pg=addusertype\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"addusertype\">
		
        <label for=\"type\">" . $USERTYPE_SIDE . " </label>
		<select name=\"type\" id=\"type\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"select-box\">
		<option value=\"main.php?pg=addusertype&amp;type=1\"");
		if ($type == '1') {
			echo(" selected"); 
		}
		echo (">" . $USERTYPE_ADMINSIDE . "</option>
		<option value=\"main.php?pg=addusertype&amp;type=0\"");
		if ($type == '0') {
			echo(" selected"); 
		}
		echo (">" . $USERTYPE_CLIENTSIDE . "</option>
		</select><br />
		
		<label for=\"typename\">" . $USERTYPE_TYPENAME . "</label>
		<input type=\"text\" id=\"typename\" size=\"20\" class=\"input-box\" NAME=\"usertype\"><br />
		<label for=\"desc\">" . $USERTYPE_DESC . "</label>
		<input type=\"text\" id=\"desc\" size=\"45\" class=\"input-box\" NAME=\"type_desc\"><br />
		<label for=\"perms\">" . $USERTYPE_PERMS . "</label><br /><br />
		
		<table class=\"table\">");
		
		$query = "SELECT perm_id, section, ttcm_permfunctions.task, ttcm_permfunctions.function 
		FROM ttcm_permissions left outer join ttcm_permfunctions on ttcm_permissions.function_id = ttcm_permfunctions.function_id 
		WHERE ttcm_permissions.usertype = '" . $type . "' ORDER BY ttcm_permissions.section, ttcm_permfunctions.function, ttcm_permfunctions.task";
		
		$retid = $db_q($db, $query, $cid);
		
		$old_section = '';
		$old_function = '';
		
		while ($row = $db_f($retid)) {
			$perm_id = $row[ 'perm_id' ];
		
			if ($row[ 'section' ] != $old_section ) {
				echo("
				<tr class=\"title\">
				<td class=\"left\" colspan=\"2\">" . $row[ 'section' ] . "</td>
				</tr>");
			}
			if ($row[ 'function' ] != $old_function ) {
				echo("
				<tr>
				<td class=\"left\"><strong>" . $row[ 'function' ] . "</strong></td>
				<td class=\"left\">");
			}
			
			echo("<input type=\"checkbox\" name=\"perms[]\" value=\"" . $perm_id . "\"> " . $row[ 'task' ] . "&nbsp; ");
				
			$old_section = $row[ 'section' ];
			$old_function = $row[ 'function' ];
		}
		
		echo("</table>
        <input type=\"submit\" class=\"body\" value=\"" . $USERTYPE_ADDNEW . "\">
        </FORM>");
	break;
	
// FORMULÁRIO DE EDIÇÃO DE NÍVEL DE USUÁRIO
	case editusertype:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );
	
		$querynam = " SELECT name, description, permissions, type FROM ttcm_usertypes WHERE usertype_id = '" . $_GET['usertype_id'] . "'";
		$retid2 = $db_q($db, $querynam, $cid);
		$my_type = $db_f( $retid2 );
		$old_permissions = $my_type[ 'permissions' ];
		$getperm_vars = split(',', $old_permissions);
		
	if (isset($_GET['type'])) {
		$type = $_GET['type'];
	}
	else {
		$type = $my_type['type'];
	}
		
	echo ("<FORM NAME=\"edit\" ACTION=\"main.php?pg=editusertype\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"usertype_id\" value=\"" . $_GET['usertype_id'] . "\">
		<input type=\"hidden\" name=\"task\" value=\"editusertype\">
		
        <label for=\"type\">" . $USERTYPE_SIDE . " </label>");
		if ($type == '1') {
			echo ("<input type=\"text\" id=\"type\" size=\"15\" class=\"input-box\" value=\"" . $USERTYPE_ADMINSIDE . "\" disabled=\"true\">");
		}
		if ($type == '0') {
			echo ("<input type=\"text\" id=\"type\" size=\"15\" class=\"input-box\" value=\"" . $USERTYPE_CLIENTSIDE . "\" disabled=\"true\">");
		}
		
		echo("<br />
		<label for=\"typename\">" . $USERTYPE_TYPENAME . "</label>
		<input type=\"text\" id=\"typename\" size=\"20\" class=\"input-box\" NAME=\"usertype\" value=\"" . $my_type['name'] . "\"><br />
		<label for=\"desc\">" . $USERTYPE_DESC . "</label>
		<input type=\"text\" id=\"desc\" size=\"45\" class=\"input-box\" NAME=\"type_desc\" value=\"" . $my_type['description'] . "\"><br />
		<label for=\"perms\">" . $USERTYPE_PERMS . "</label><br /><br />
		
		<table class=\"table\">");
		
		$query = "SELECT perm_id, section, ttcm_permfunctions.task, ttcm_permfunctions.function 
		FROM ttcm_permissions left outer join ttcm_permfunctions on ttcm_permissions.function_id = ttcm_permfunctions.function_id 
		WHERE ttcm_permissions.usertype = '" . $type . "' ORDER BY ttcm_permissions.section, ttcm_permfunctions.function, ttcm_permfunctions.task";
		
		$retid = $db_q($db, $query, $cid);
		
		$old_section = '';
		$old_function = '';
		
		while ($row = $db_f($retid)) {
			$checked = '';
			$perm_id = $row[ 'perm_id' ];
		
			if ($row[ 'section' ] != $old_section ) {
				echo("
				<tr class=\"title\">
				<td class=\"left\" colspan=\"2\">" . $row[ 'section' ] . "</td>
				</tr>");
			}
			if ($row[ 'function' ] != $old_function ) {
				echo("
				<tr>
				<td class=\"left\"><strong>" . $row[ 'function' ] . "</strong></td>
				<td class=\"left\">");
			}
			
			if (in_array($row[ 'perm_id' ], $getperm_vars)) {
				$checked = "checked";
			}
			
			echo("<input type=\"checkbox\" name=\"perms[]\" value=\"" . $row[ 'perm_id' ] . "\" " . $checked . "> " . $row[ 'task' ] . " &nbsp; ");
				
			$old_section = $row[ 'section' ];
			$old_function = $row[ 'function' ];
		}
		
		echo("</table>
        <input type=\"submit\" class=\"body\" value=\"" . $USERTYPE_HEADER . "\">
        </FORM>");
	break;

// EDIT USER FORM
	case edituser:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$query = " SELECT name, client_id, email, type, username, aim, msn, yahoo, icq, skype, address1, address2, city, state, zip, country, phone, phone_alt, fax FROM ttcm_user WHERE id = '" . $_GET['uid'] . "'";
	$retid = $db_q($db, $query, $cid);	
	$my_client = $db_f( $retid );
	
	$query2 = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $query2, $cid);
								
		$client_string = "<option value=\"0\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

		while( $my_client2 = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"" . $my_client2[ 'client_id' ] . "\"";
			if ($my_client2[ 'client_id' ] == $my_client[ 'client_id' ]) {
				$client_string .= " selected"; }
			$client_string .= ">" . stripslashes($my_client2[ 'company' ]) . "</option>\n";
		} 

	echo ("<FORM NAME=\"edit\" ACTION=\"main.php?pg=edituser\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"uid\" value=\"" . $_GET['uid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"edituser\">
	
	<h3>" . $EDITUSER_USERTYPE . "</h3>
	<label for=\"type\">" . $EDITUSER_LOGINFOR . ":</label>
	<select name=\"type\" class=\"body\">
		<option value=\"0\"");
	if ($my_client[ 'type' ] == '0') {
		echo (" selected");
	}
	echo (">" . $EDITUSER_CLUSER . "</option>
		<option value=\"1\"");
	if ($my_client[ 'type' ] == '1') {
		echo (" selected");
	}
	echo (">" . $EDITUSER_AUSER . "</option></select>
	
	<h3>" . $EDITUSER_INFO . "</h3>
	<label for=\"client_id\">" . $COMMON_CLIENT . ": </label>
	<select name=\"client_id\" class=\"body\">" . $client_string . "</select>

	<h3>" . $COMMON_NAME . "</h3>
	<label for=\"name\">" . $COMMON_NAME . ": </label>
	<input type=\"text\" size=\"30\" id=\"name\" name=\"user_name\" value=\"" . stripslashes($my_client[ 'name' ]) . "\">
	<br />
	
	<h3>" . $COMMON_ADDRESS . "</h3>
	<label for=\"user_address1\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" size=\"35\" id=\"user_address1\" name=\"user_address1\" value=\"" . stripslashes($my_client[ 'address1' ]) . "\"><br />
	<label for=\"user_address2\"></label>
	<input type=\"text\" size=\"35\" id=\"user_address2\" name=\"user_address2\" value=\"" . stripslashes($my_client[ 'address2' ]) . "\"><br />
	<label for=\"user_city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"user_city\" name=\"user_city\" value=\"" . stripslashes($my_client[ 'city' ]) . "\"><br />
	<label for=\"user_state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_state\" name=\"user_state\" value=\"" . stripslashes($my_client[ 'state' ]) . "\"><br />
	<label for=\"user_zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"user_zip\" name=\"user_zip\" value=\"" . $my_client[ 'zip' ] . "\"><br />
	<label for=\"user_country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"user_country\" name=\"user_country\" value=\"" . stripslashes($my_client[ 'country' ]) . "\"><br />
	<br />
	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>
	<label for=\"user_phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_phone\" name=\"user_phone\" value=\"" . $my_client[ 'phone' ] . "\"><br />
	<label for=\"user_phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_phone_alt\" name=\"user_phone_alt\" value=\"" . $my_client[ 'phone_alt' ] . "\"><br />
	<label for=\"user_fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_fax\" name=\"user_fax\" value=\"" . $my_client[ 'fax' ] . "\"><br />
	<label for=\"admin_email\">" . $COMMON_EMAIL . ":</label>
	<input type=\"text\" size=\"35\" id=\"email\" name=\"email\" value=\"" . $my_client[ 'email' ] . "\"><br />
	
	<br />

	<h3>" . $COMMON_LOGIN . "</h3>
	<label for=\"username\">" . $COMMON_USERNAME . ":</label>
	<input type=\"text\" size=\"15\" id=\"username\" class=\"input-box\" name=\"new_username\" value=\"" . $my_client[ 'username' ] . "\"><br />
	<label for=\"password\">" . $COMMON_PASSWORD . ":<br />" . $EDITUSER_PWBLANK . "</label>
	<input type=\"password\" id=\"password\" size=\"15\" class=\"input-box\" name=\"newpassword\"><br />
	<br />

	<p><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITUSER_SAVEINFO . "\"></p>
	</FORM>");
	break;

// CHANGE PASSWORD
	case changepw:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	echo("<FORM NAME=\"edit\" ACTION=\"main.php?pg=changepw\" METHOD=\"POST\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<input type=\"hidden\" name=\"vid\" value=\"" . $_SESSION['valid_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"changepw\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $CHANGEPW_NEWPW . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $CHANGEPW_ENTERPW . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"password\" size=\"35\" class=\"input-box\" name=\"newpassword\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $CHANGEPW_SAVEPW . "\"></td>
	</tr>
	</table>
	</form>");
	break;

// EDIT TOPIC FORM
	case edittopic:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$SQL = " SELECT topic, description, cat_id FROM ttcm_topics WHERE topic_id = '" . $_GET['tid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);
	
	$cat_id = $row[ 'cat_id' ];

	echo ("<p>" . $EDITTOPIC_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=edittopic\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"tid\" value=\"" . $_GET['tid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"edittopic\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $EDITTOPIC_ANSWER . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_CATEGORY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br />
		<select name=\"cat_id\" class=\"body\">");
	$cat_string = help_topicmenu("$cat_id");
	echo ($cat_string);
	echo ("</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $EDITTOPIC_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"topic\" value=\"" . stripslashes($row[ 'topic' ]) . "\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $EDITTOPIC_DESC . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"15\" cols=\"50\" class=\"body\">" . stripslashes($row[ 'description' ]) . "</textarea></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITTOPIC_SAVE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// EDIT TASK FORM
	case edittask:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT title, description, start, status, finish, notes, milestone, assigned FROM ttcm_task WHERE task_id = '" . $_GET['tid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);
		
	$query = " SELECT name FROM ttcm_status WHERE type = 'tasks' ORDER BY name";
	$retid2 = $db_q($db, $query, $cid);

		while( $my_status = $db_f( $retid2 ) )
		{
			$status_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
			if ( $my_status[ 'name' ] == $row[ 'status' ] ) {
				$status_string .= " SELECTED"; }
			$status_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
		} 

	$query2 = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $query2, $cid);
							
		$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</OPTION>\n";

		while( $my_client = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
			$client_string .= " selected"; }
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}
	
	$query3 = " SELECT name, id FROM ttcm_user WHERE type = '1' ORDER BY name";
	$retid3 = $db_q($db, $query3, $cid);
							
		$tuser_string = "<option value=\"0\">" . $COMMON_NOASSIGN . "</option>\n";

		while( $my_user = $db_f( $retid3 ) )
		{
			$tuser_string .= "<option value=\"" . $my_user[ 'id' ] . "\"";
			if ($my_user[ 'id' ] == $row[ 'assigned' ]) {
			$tuser_string .= " selected"; }
			$tuser_string .= ">" . stripslashes($my_user[ 'name' ]) . "</option>\n";
		} 
		
	echo ("<p>" . $EDITTASK_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=edittask\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"tid\" value=\"" . $_GET['tid'] . "\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<input type=\"hidden\" name=\"oldstart\" value=\"" . $row[ 'start' ] . "\">
	<input type=\"hidden\" name=\"oldmilestone\" value=\"" . $row[ 'milestone' ] . "\">
	<input type=\"hidden\" name=\"oldfinish\" value=\"" . $row[ 'finish' ] . "\">
	<input type=\"hidden\" name=\"task\" value=\"edittask\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"clid\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $EDITTASK_TASKINFO . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"task_title\" value=\"" . stripslashes($row[ 'title' ]) . "\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"10\" cols=\"50\" class=\"body\">" . stripslashes($row[ 'description' ]) . "</textarea></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STARTDATE . ":</strong> " . $row[ 'start' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newstart', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_FINISHDATE . ":</strong> " . $row[ 'finish' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newfinish', false, 'MM/DD/YYYY')</script>");
	echo ("</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_MILESTONE . ":</strong> " . $row[ 'milestone' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newmilestone', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STATUS . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"status\" class=\"body\">" . $status_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_NOTES . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"notes\" rows=\"5\" cols=\"50\" class=\"body\">" . stripslashes($row[ 'notes' ]) . "</textarea></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $ADDTASK_ASSIGNUSER . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $ADDTASK_ASSIGNTO . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"tauid\" class=\"body\">" . $tuser_string . "</select></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITTASK_SAVE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// EDITAR OPÇÕES DE STATUS
	case editstatus:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT name, type FROM ttcm_status WHERE status_id = '" . $_GET['status_id'] . "' ";
	$retid2 = $db_q($db, $SQL, $cid);
	$row = $db_f($retid2);

	echo ("<p>" . $EDITSTATUS_MAINTEXT . "</p>
	<FORM NAME=\"edit\" ACTION=\"main.php?pg=statusoptions\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"status_id\" value=\"" . $_GET['status_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editstatus\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $EDITSTATUS_OPTION . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_TYPE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"type\" class=\"lrg\">
		<option value=\"account\"");
	if ( $row[ 'type' ] == 'account' ) {
		echo(" selected");
	}
	echo (">" . $COMMON_ACCOUNT . "</option>
		<option value=\"project\"");
	if ( $row[ 'type' ] == 'project' ) {
		echo (" selected");
	}
	echo (">" . $COMMON_PROJECT . "</option>
		<option value=\"tasks\"");
	if ( $row[ 'type' ] == 'tasks' ) {
		echo (" selected");
	}
	echo (">" . $COMMON_TASK . "</option>");
	if ($_SESSION["mod1_installed"] == '1') {
	
		echo ("<option value=\"invoice\"");
		if ( $row[ 'type' ] == 'invoice' ) {
			echo (" selected");
		}
	echo (">" . $COMMON_INVOICE . "</option>");
	}
	echo ("</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"name\" value=\"" . stripslashes($row[ 'name' ]) . "\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITSTATUS_SAVE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// EDIT PROJECT FORM
	case editproj:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT * FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);

	$query = " SELECT name, status_id FROM ttcm_status WHERE type = 'project' ORDER BY name";
	$retid = $db_q($db, $query, $cid);

		while( $my_status = $db_f( $retid ) )
		{
			$status_string .= "<option value=\"" . stripslashes($my_status[ 'name' ]) . "\"";
			if ($row[ 'status' ] == $my_status[ 'name' ]) {
				$status_string .= " selected"; }
			$status_string .= ">" . stripslashes($my_status[ 'name' ]) . "</option>\n";
		} 

	$query2 = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $query2, $cid);
							
		$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIEINT . " ...</OPTION>\n";

		while( $my_client = $db_f( $retid2 ) )
		{	
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
				$client_string .= " selected";
			}
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		} 

	echo ("<p>" . $EDITPROJECT_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=editproj\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<input type=\"hidden\" name=\"oldstart\" value=\"" . $row[ 'start' ] . "\">
	<input type=\"hidden\" name=\"oldmilestone\" value=\"" . $row[ 'milestone' ] . "\">
	<input type=\"hidden\" name=\"oldfinish\" value=\"" . $row[ 'finish' ] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editproject\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"clid\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"project_title\" value=\"" . stripslashes($row[ 'title' ]) . "\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"15\" cols=\"50\" class=\"body\">" . stripslashes($row[ 'description' ]) . "</textarea></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br><strong>" . $COMMON_STARTDATE . ":</strong> " . $row[ 'start' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newstart', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_FINISHDATE . ":</strong> " . $row[ 'finish' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newfinish', false, 'MM/DD/YYYY')</script>");
	echo ("</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_MILESTONE . ":</strong> " . $row[ 'milestone' ] . "</td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('newmilestone', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br><strong>" . $COMMON_QUOTE . ":</strong></td>
		<td valign=\"top\" class=\"input-box\"><br><input type=\"text\" size=\"15\" class=\"input-box\" name=\"cost\" value=\"" . $row[ 'cost' ] . "\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STATUS . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"status\" class=\"body\">" . $status_string . "</select></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITPROJECT_SAVE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// EDIT MESSAGE FORM
	case editmessage:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$SQL = " SELECT client_id, message_title, message FROM ttcm_messages WHERE message_id = '" . $_GET['mid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);

	$query2 = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $query2, $cid);
								
		$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";
		while( $my_client = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ($row[ 'client_id' ] == $my_client[ 'client_id' ]) {
				$client_string .= " selected"; }
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		} 
		
		$SQL2 = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $row[ 'client_id' ] . "'";
		$retid2 = $db_q($db, $SQL2, $cid);

			$project_string = "<option value=\"0\">" . $COMMON_NOPROJECT . "</option>\n";

			while( $my_clients = $db_f( $retid2 ) )
			{
				$project_string .= "<option value=\"" . $my_clients[ 'project_id' ] . "\"";
				if ($my_clients[ 'project_id' ] == $_GET['pid']) {
					$project_string .= " selected"; 
				}
				$project_string .= ">" . stripslashes($my_clients[ 'title' ]) . "</option>\n";

			}

	echo ("<FORM NAME=\"edit\" ACTION=\"main.php?pg=editmsg\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"mid\" value=\"" . $_GET['mid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editmessage\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"clid\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">");
		if (!$_GET['clid']) {
				echo ("<select name=\"pid\" class=\"body\"><option selected value=\"\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
			}
			else {
				echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
			}
		echo ("</td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $EDITMESSAGE_INFO . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"message_title\" value=\"" . stripslashes($row[ 'message_title' ]) . "\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $EDITMESSAGE_MESSAGE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"message\" rows=\"15\" cols=\"50\" class=\"body\">" . stripslashes($row[ 'message' ]) . "</textarea></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $EDITMESSAGE_SAVE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A USER
	case adduser:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$clid = $_GET['clid'];
	$client_string = client_pulldown("$clid");

	echo ("<p>Preencha o formul&aacute;rio abaixo para adicionar um acesso para usu&aacute;rio.</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;do=add\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"adduser\">
	<h3>" . $EDITUSER_USERTYPE . " <a href=\"main.php?pg=usertypes\">[ " . $COMMON_EDIT . " ]</a></h3>");
	
	$query = "SELECT usertype_id, name FROM ttcm_usertypes ORDER BY usertype_id";
	$retid = $db_q($db, $query, $cid);
																
	$user_string = "";

	while( $my_type = $db_f( $retid ) )
	{		
		$user_string .= "<option value=\"" . $my_type[ 'usertype_id' ] . "\"";
		$user_string .= ">" . stripslashes($my_type[ 'name' ]) . "</option>\n";
	}
		
	echo("<label for=\"type\">" . $EDITUSER_LOGINFOR . ":</label>
	<select name=\"type\" id=\"type\" class=\"select-box\">" . $user_string . "</select> 
	
	<h3>" . $EDITUSER_INFO . "</h3>
	<label for=\"client_id\">" . $COMMON_CLIENT . ": </label>
	<select name=\"client_id\" id=\"client_id\" class=\"select-box\">" . $client_string . "</select>

	<h3>" . $COMMON_NAME . "</h3>
	<label for=\"name\">" . $COMMON_NAME . ": </label>
	<input type=\"text\" size=\"30\" id=\"name\" name=\"name\">
	<br />
	
	<h3>" . $COMMON_ADDRESS . "</h3>
	<label for=\"user_address1\">" . $COMMON_ADDRESS . ":</label>
	<input type=\"text\" size=\"35\" id=\"user_address1\" name=\"user_address1\"><br />
	<label for=\"user_address2\"></label>
	<input type=\"text\" size=\"35\" id=\"user_address2\" name=\"user_address2\"><br />
	<label for=\"user_city\">" . $COMMON_CITY . ":</label>
	<input type=\"text\" size=\"30\" id=\"user_city\" name=\"user_city\"><br />
	<label for=\"user_state\">" . $COMMON_STATE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_state\" name=\"user_state\"><br />
	<label for=\"user_zip\">" . $COMMON_ZIP . ":</label>
	<input type=\"text\" size=\"15\" id=\"user_zip\" name=\"user_zip\"><br />
	<label for=\"user_country\">" . $COMMON_COUNTRY . ":</label>
	<input type=\"text\" size=\"25\" id=\"user_country\" name=\"user_country\"><br />
	<br />
	<h3>" . $EDITADMIN_CONTACTINFO . "</h3>
	<label for=\"user_phone\">" . $COMMON_MAINPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_phone\" name=\"user_phone\"><br />
	<label for=\"user_phone_alt\">" . $COMMON_ALTPHONE . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_phone_alt\" name=\"user_phone_alt\"><br />
	<label for=\"user_fax\">" . $COMMON_FAX . ":</label>
	<input type=\"text\" size=\"20\" id=\"user_fax\" name=\"user_fax\"><br />
	<label for=\"admin_email\">" . $COMMON_EMAIL . ":</label>
	<input type=\"text\" size=\"35\" id=\"email\" name=\"email\"><br />
	
	<br />

	<h3>" . $COMMON_LOGIN . "</h3>
	<label for=\"username\">" . $COMMON_USERNAME . ":</label>
	<input type=\"text\" size=\"15\" id=\"username\" class=\"input-box\" name=\"username\"><br />
	<label for=\"password\">" . $COMMON_PASSWORD . ":</label>
	<input type=\"password\" id=\"password\" size=\"15\" class=\"input-box\" name=\"password\"><br />
	
	<p><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDUSER_ADD . "\"></p>
	</FORM>");
	break;

// ADD A TOPIC
	case addtopic:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$cat_string = help_pulldown();

	echo ("<p>" . $ADDTOPIC_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addtopic\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addtopic\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $EDITTOPIC_ANSWER . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_CATEGORY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"cat_id\" class=\"body\">" . $cat_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"topic\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"15\" cols=\"50\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDTOPIC_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A TASK
	case addtask:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $SQL, $cid);
							
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

		while( $my_client = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"main.php?pg=addtask&amp;clid=" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
				$client_string .= " selected";
			}
			$client_string .= ">" . $my_client[ 'company' ] . "</option>\n";
		}
		
		$query3 = " SELECT name, id FROM ttcm_user WHERE type = '1' ORDER BY name";
		$retid3 = $db_q($db, $query3, $cid);
							
		$tuser_string = "<option value=\"0\">" . $COMMON_NOASSIGN . "</option>\n";

		while( $my_user = $db_f( $retid3 ) )
		{
			$tuser_string .= "<option value=\"" . $my_user[ 'id' ] . "\"";
			if ($_GET['tuid'] == $my_user[ 'id' ]) {
			$tuser_string .= " selected"; }
			$tuser_string .= ">" . stripslashes($my_user[ 'name' ]) . "</option>\n";
		}
		$default_addtask = $_SESSION['default_ata'];
		$status_string = cstatus_pulldown(tasks, "$default_addtask");
		$project_string = project_pulldown("$_GET[clid]","$_GET[pid]");
		
		$mo = date("m");
		$dy = date("d");
		$yr = date("Y");

	echo ("<p>" . $ADDTASK_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addtask\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addtask\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"client_id\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">");
		if (!$_GET['clid']) {
			echo ("<select name=\"pid\" class=\"body\"><option selected value=\"#\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
		}
		else {
			echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
		}
	echo ("</td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $EDITTASK_TASKINFO . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"input-box\"><input type=\"text\" size=\"30\" class=\"input-box\" name=\"task_title\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"10\" cols=\"50\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STARTDATE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('startdate', true, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_MILESTONE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('miledate', true, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_FINISHDATE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('findate', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STATUS . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"status\" class=\"body\">" . $status_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_NOTES . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><textarea name=\"notes\" rows=\"5\" cols=\"50\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $ADDTASK_ASSIGNUSER . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $ADDTASK_ASSIGNTO . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"tuid\" class=\"body\">" . $tuser_string . "</select></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDTASK_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;
	
// ADD A TO DO ITEM
		case addtodo:

		global $cid, $db_q, $db_c, $db_f, $db;
		
		$SQL = " SELECT company, client_id FROM ttcm_client ORDER BY company";
		$retid2 = $db_q($db, $SQL, $cid);
								
		$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

			while( $my_client = $db_f( $retid2 ) )
			{
				$client_string .= "<option value=\"main.php?pg=addtodo&amp;clid=" . $my_client[ 'client_id' ] . "\"";
				if ($_GET['clid'] == $my_client[ 'client_id' ]) {
					$client_string .= " selected";
				}
				$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
			}
			
			$status_string = status_pulldown(tasks);
			$project_string = project_pulldown("$_GET[clid]","$_GET[pid]");
			
			$mo = date("m");
			$dy = date("d");
			$yr = date("Y");

		echo ("<p>" . $ADDTODO_MAINTEXT . "</p>
		<FORM NAME=\"add\" ACTION=\"main.php?pg=addtodo\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"task\" value=\"addtodo\">
		<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
		<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
		<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
		<tr>
			<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
			<td valign=\"top\" class=\"body\"><select name=\"client_id\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"body\">" . $client_string . "</select></td>
		</tr>
		<tr>
			<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
			<td valign=\"top\" class=\"body\">");
			if (!$_GET['clid']) {
				echo ("<select name=\"pid\" class=\"body\"><option selected value=\"#\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
			}
			else {
				echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
			}
		echo ("</td>
		</tr>
		<tr>
			<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $ADDTODO_ITEM . "</td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
			<td valign=\"top\" class=\"body\"><textarea name=\"item\" rows=\"8\" cols=\"50\" class=\"body\"></textarea></td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_LINK . " " . $ADDTODO_INSTRUCT . ":</strong></td>
			<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"todo_link\" value=\"http://\"></td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_DUEDATE . ":</strong></td>
			<td valign=\"top\" class=\"body\"><br /><script>DateInput('duedate', true, 'MM/DD/YYYY')</script></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDTODO_ADDNEW . "\"></td>
		</tr>
		</table>
		</FORM>");
		break;

// ADD A PROJECT
	case addproject:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $SQL, $cid);
	
	$default_apr = $_SESSION['default_apr'];
																
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";

		while( $my_client = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ( $my_client[ 'client_id' ] == $_GET['clid'] ) {
				$client_string .= " SELECTED";
			}
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}
		
		$status_string = cstatus_pulldown(project,"$default_apr");
		
	echo ("<p>" . $ADDPROJECT_MAINTEXT . "</p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addproj\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addproject\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=top colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"client_id\" class=\"select-box\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"project_title\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"description\" rows=\"15\" cols=\"50\" class=\"input-box\"></textarea></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STARTDATE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><script>DateInput('startdate', true, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_MILESTONE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br><script>DateInput('miledate', true, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_FINISHDATE . ":</strong><br />" . $ADDPROJECT_LEAVEBLANK . "</td>
		<td valign=\"top\" class=\"body\"><br><script>DateInput('findate', false, 'MM/DD/YYYY')</script></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_QUOTE . ":</strong></td>
		<td valign=\"top\"><br><input type=\"text\" size=\"15\" class=\"input-box\" name=\"cost\" value=\"0.00\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_STATUS . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"status\" class=\"select-box\">" . $status_string . "</select></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDPROJECT_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A NOTE
	case addnotes:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$query = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
								
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";
		
		while( $my_client = $db_f( $retid ) )
		{
			$client_string .= "<option value=\"add_notes.php?clid=" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
				$client_string .= " selected"; 
			}
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}
		
	$SQL2 = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $_GET['clid'] . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
							
		$project_string = "<option value=\"0\">" . $COMMON_NOPROJECT . "</option>\n";

		while( $my_clients = $db_f( $retid2 ) )
		{
			$project_string .= "<option value=\"" . $my_clients[ 'project_id' ] . "\"";
			if ($my_clients[ 'project_id' ] == $_GET['pid']) {
				$project_string .= " selected"; 
			}
			$project_string .= ">" . stripslashes($my_clients[ 'title' ]) . "</option>\n";
			
		}

	echo ("<p>" . $ADDNOTE_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addnotes\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addnote\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"pid\" value=\"" . $_GET['pid'] . "\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"cli_id\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">");
		if (!$_GET['clid']) {
				echo ("<select name=\"pid\" class=\"body\"><option selected value=\"\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
			}
			else {
				echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
			}
		echo ("</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_NOTES . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><textarea name=\"note\" rows=\"15\" cols=\"50\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDNOTE_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A NEW MESSAGE
	case addmessage:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$query = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
								
	$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</option>\n";
		
		while( $my_client = $db_f( $retid ) )
		{
			$client_string .= "<option value=\"main.php?pg=addmsg&amp;clid=" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
				$client_string .= " selected"; 
			}
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}
		
	$SQL2 = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $_GET['clid'] . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
							
		$project_string = "<option value=\"0\">" . $COMMON_NOPROJECT . "</option>\n";

		while( $my_clients = $db_f( $retid2 ) )
		{
			$project_string .= "<option value=\"" . $my_clients[ 'project_id' ] . "\"";
			if ($my_clients[ 'project_id' ] == $_GET['pid']) {
				$project_string .= " selected"; 
			}
			$project_string .= ">" . stripslashes($my_clients[ 'title' ]) . "</option>\n";
			
		}

	echo ("<p>" . $ADDMESSAGE_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addmsg\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"post_by\" value=\"" . $_SESSION['admin_name'] . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"addmessage\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_MESSAGES . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $COMMON_CLIENT . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"cli_id\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">");
		if (!$_GET['clid']) {
				echo ("<select name=\"pid\" class=\"body\"><option selected value=\"\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
			}
			else {
				echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
			}
		echo ("</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"message_title\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_MESSAGES . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"message\" rows=\"15\" cols=\"50\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDMESSAGE_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;
	
// QUICK REPLY TO MESSAGE
	case quickreply:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$message_html .= "<br /><p class=\"message-date\">Resposta R&aacute;pida de " . stripslashes($_SESSION['admin_name']) . ":</p>\n";

	$message_html .= "<FORM NAME=\"add\" ACTION=\"main.php?pg=readmsg&amp;mid=" . $_GET['mid'] . "\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"post_by\" value=\"" . $_SESSION['admin_name'] . "\">
	<input type=\"hidden\" name=\"mid\" value=\"" . $_GET['mid'] . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"addquickreply\">
	<textarea name=\"comment\" rows=\"7\" cols=\"50\" class=\"input-box\"></textarea>
	<br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDMESSAGE_REPLY . "\"><p>
	</FORM>";

	$showform = '0';
	break;

// EDITAR MODELO DE E-MAIL
	case etemplates:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$query = " SELECT htmltext, subject, template FROM ttcm_templates WHERE template_id = '" . $_GET['tid'] . "'";
	$retid = $db_q($db, $query, $cid);
	$my_template = $db_f( $retid );

	echo ("&nbsp;<br /><FORM NAME=\"add\" ACTION=\"main.php?pg=templates\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"template_id\" value=\"" . $_GET['tid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"editetemplate\">
	<table>");
	
	if ($_GET['tid'] == 1) {
		echo ("<tr>
			<td class=\"left\"><h2>" . $COMMON_EDIT . " " . $my_template[ 'template' ] . "</h2></td>
		</tr>
		<tr>
			<td class=\"left\"><strong>" . $ETEMPLATE_CSS . "</strong><br />");
	}
	else {
		echo ("<tr>
			<td class=\"left\"><h2>" . $ETEMPLATE_EDITTEMP . ": " . $my_template[ 'template' ] . "</h2></td>
		</tr>
		<tr>
			<td class=\"left\"><strong>" . $ETEMPLATE_ESUBJECT . ":</strong><br />
			<input type=\"text\" size=\"50\" class=\"input-box\" name=\"email_subject\" value=\"" . stripslashes($my_template[ 'subject' ]) . "\"></td>
		</tr>
		<tr>
			<td class=\"left\"><strong>" . $ETEMPLATE_EBODY . "</strong><br />");
	}
	echo ("
		<textarea name=\"email_body\" rows=\"25\" cols=\"65\" class=\"input-box\">" . stripslashes($my_template[ 'htmltext' ]) . "</textarea></td>
	</tr>
	<tr>
		<td><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ETEMPLATE_EDITTEMPLATE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A LINK
	case addlink:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	$clid = $_GET['clid'];

	$client_string = client_pulldown("$clid");

	echo ("<p>" . $ADDLINK_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addlink\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addlink\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $ADDLINK_SHOWLINK . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"client_id\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_LINK . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"link_title\"></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_DESCRIPTION . ":</strong></td>
		<td valign=\"top\" class=\"body\"><textarea name=\"link_desc\" rows=\"5\" cols=\"40\" class=\"body\"></textarea></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $ADDLINK_ADDRESS . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"link\" value=\"www.\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDLINK_NEWLINK . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;
	
// ADD A WEBSITE
	case addwebsite:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$query = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid = $db_q($db, $query, $cid);
																
	$client_string = "<option value=\"0\">" . $COMMON_SELECTCLIENT . " ...</option>\n";
	$client_string .= "<option value=\"0\">" . $ADDWEBSITE_ADMIN . "</option>\n";

	while( $my_client = $db_f( $retid ) )
		{
			$client_id = $my_client[ 'client_id' ];
				
			$client_string .= "<option value=\"" . $my_client[ 'client_id' ] . "\"";
			if ($my_client[ 'client_id' ] == $_GET['clid']) {
				$client_string .= " SELECTED"; }
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}

	echo ("<p>" . $ADDWEBSITE_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addwebsite\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addwebsite\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $ADDWEBSITE_WEBFOR . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"client_id\" class=\"body\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_WEBSITE . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_LINK . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"website\" value=\"www.\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDWEBSITE_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A HELP CATEGORY
	case addhelpcat:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	echo ("<p>" . $ADDHELPCAT_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addhelpcat\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addhelpcat\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CATEGORY . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign\"top\"><br /><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><input type=\"text\" size=\"40\" class=\"input-box\" name=\"category\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDHELPCAT_ADDNEW . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD FILES
	case addfiles:
	
	global $cid, $db_q, $db_c, $db_f, $db;

	$SQL = " SELECT company, client_id FROM ttcm_client ORDER BY company";
	$retid2 = $db_q($db, $SQL, $cid);
							
		$client_string = "<option value=\"#\">" . $COMMON_SELECTCLIENT . " ...</OPTION>\n";
		
		while( $my_client = $db_f( $retid2 ) )
		{
			$client_string .= "<option value=\"main.php?pg=addfiles&amp;clid=" . $my_client[ 'client_id' ] . "\"";
			if ($_GET['clid'] == $my_client[ 'client_id' ]) {
				$client_string .= " selected"; 
			}
			$client_string .= ">" . stripslashes($my_client[ 'company' ]) . "</option>\n";
		}
		
	$SQL2 = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $_GET['clid'] . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
							
		$project_string = "<option value=\"0\">" . $COMMON_NOPROJECT . "</option>\n";

		while( $my_client = $db_f( $retid2 ) )
		{
			$project_string .= "<option value=\"" . $my_client[ 'project_id' ] . "\"";
			if ($my_client[ 'project_id' ] == $_GET['pid']) {
				$project_string .= " selected"; 
			}
			$project_string .= ">" . stripslashes($my_client[ 'title' ]) . "</option>\n";	
		}

	echo ("<FORM NAME=\"step1\" ACTION=\"main.php?pg=addfile\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"from\" value=\"step1\">	
	<input type=\"hidden\" name=\"clid\" value=\"" . $_GET['clid'] . "\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"cli_id\" onChange=\"MM_jumpMenu('parent',this,0)\" class=\"select-box\">" . $client_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_PROJECT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">");
		if (!$_GET['clid']) {
				echo ("<select name=\"pid\" class=\"body\"><option selected value=\"\">" . $ADDTASK_CLIENTFIRST . "</option></select>");
			}
			else {
				echo ("<select name=\"pid\" class=\"body\">" . $project_string . "</select>");
			}
		echo ("</td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\">");
		if ($_GET['clid'] != '') {
			echo ("<br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDFILES_CONT . "\">");
			}
		echo ("</td>
	</tr>
	</table>
	</FORM>");
	break;

// ADD A FILE
	case addfile:
	
	global $cid, $db_q, $db_c, $db_f, $db, $home_dir;

	$SQL = " SELECT company FROM ttcm_client WHERE client_id = '" . $_POST['clid'] . "'";
	$retid = $db_q($db, $SQL, $cid);
	$row = $db_f($retid);
	
	if ( $_POST['pid'] != '0' ) {
		$SQL2 = " SELECT title FROM ttcm_project WHERE project_id = '" . $_POST['pid'] . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$client_project = $row2[ 'title' ];
	}
	else { 
		$client_project = $COMMON_NOPROJECT; 
	}

	$SQL4 = " SELECT title, task_id FROM ttcm_task WHERE project_id = '" . $_POST['pid'] . "'";
	$retid4 = $db_q($db, $SQL4, $cid);
	
	$task_string = "<option value=\"0\">" . $COMMON_NOTASK . "</option>";

		while( $my_tasks = $db_f( $retid4 ) )
		{
			$task_string .= "<option value=\"" . $my_tasks[ 'task_id' ] . "\"";
			$task_string .= ">" . stripslashes($my_tasks[ 'title' ]) . "</option>\n";
		} 
		
	$SQL3 = " SELECT file_type, type_id FROM ttcm_filetype ORDER BY file_type";
	$retid3 = $db_q($db, $SQL3, $cid);

		while( $my_type = $db_f( $retid3 ) )
		{
			$type_string .= "<option value=\"" . $my_type[ 'type_id' ] . "\"";
			$type_string .= ">" . $my_type[ 'file_type' ] . "</option>\n";
		} 

	echo ("<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"main.php?pg=addfile\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"task\" value=\"addfile\">
	<input type=\"hidden\" name=\"client_id\" value=\"" . $_POST['clid'] . "\">
	<input type=\"hidden\" name=\"from\" value=\"step2\">
	<input type=\"hidden\" name=\"project_id\" value=\"" . $_POST['pid'] . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_POST['clid'] . "\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_CLIENT . ":</strong></td>
		<td valign=\"top\" class=\"body\">" . $row[ 'company' ] . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\">" . $client_project . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TASK . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"task_id\" class=\"body\">" . $task_string . "</select></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $EDITFILE_TYPEOFFILE . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $EDITFILE_TYPE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><br /><select name=\"type_id\" class=\"body\">" . $type_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $EDITFILE_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"input-box\" name=\"file_title\"></td>
	</tr>
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $ADDFILE_FILES . "</td>
	</tr>
	<tr>
		<td class=\"body\" valign=\"top\" colspan=\"2\"><br />" . $ADDFILE_INSTRUCT . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $ADDFILE_UPLOADFILE . "</strong></td>
		<td valign=\"top\" class=\"body\"><br /><input name=\"file\" type=\"file\" size=\"25\" class=\"lrg\"></td>
	</tr>
	<tr>
		<td class=\"body\" valign=\"top\" colspan=\"2\"><br /><strong>-- " . $ADDFILE_OR . " --</strong></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $ADDFILE_LINKFILE . "</strong></td>
		<td valign=\"top\" class=\"body\"><br /><input type=\"text\" size=\"40\" class=\"input-box\" name=\"input_link\"></td>
	</tr>
	<tr>
		<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"submit-button\" value=\"" . $ADDFILE_NEWFILE . "\"></td>
	</tr>
	</table>
	</FORM>");
	break;

	default:
		break;
}
?>