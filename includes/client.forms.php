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

// SWITCH FOR TASK
switch ($ftype) {

	case contact:
	
	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_contact.php" );
	
	$client_id = $_SESSION['client_id'];
	
	echo("<form action=\"main.php?pg=contact\" method=\"POST\">
   	<input type=\"hidden\" name=\"recipient\" value=\"" . $_SESSION['admin_email'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"contactform\">
	<h3>" . $COMMON_FULLNAME . "</h3>
	<p><input type=\"text\" size=30 name=\"realname\" class=\"input-box\" value=\"" . $_SESSION['client_name'] . "\"</p>
	<h3>" . $COMMON_EMAIL . "</h3>
	<p><input type=\"text\" size=30 name=\"email\" class=\"input-box\" value=\"" . $_SESSION['client_email'] . "\"></p>
	<h3>" . $CONTACT_FORPROJECT . "</h3>");
	
	$project_menu = project_pulldown($client_id);
    echo("<p>" . $project_menu . "</p>
	<h3>" . $CONTACT_SUBJECT . "</h3>
	<p><input type=\"text\" size=\"50\" name=\"contact_subject\" class=\"input-box\"></p>
	<h3>" . $CONTACT_MESSAGE . "</h3>
	<p><textarea name=\"contact_message\" rows=\"10\" cols=\"50\" class=\"input-box\"></textarea></p>
	<p align=\"center\"><input type=\"submit\" name=\"submit\" value=\"" . $CONTACT_SUBMIT . "\" class=\"submit-button\"></p>
  	</form>");
	break;
	
// QUICK REPLY TO MESSAGE
	case quickreply:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_contact.php" );
	
	$query2 = " SELECT name FROM ttcm_user WHERE id = '" . $_SESSION['valid_id'] . "'";
	$retid2 = $db_q($db, $query2, $cid);

	$row2 = $db_f($retid2);
	$client_name = $row2[ "name" ];
	$client_name = stripslashes($client_name);

	$message_html .= "<p class=\"message-date\">Resposta R&aacute;pida de " . $client_name . ":</p>\n";
	
	$message_html .= "<FORM NAME=\"add\" ACTION=\"main.php?pg=readmsg&amp;mid=" . $_GET['mid'] . "\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"post_by\" value=\"" . $client_name . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_SESSION['client_id'] . "\">
	<input type=\"hidden\" name=\"mid\" value=\"" . $_GET['mid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"addquickreply\">
	<textarea name=\"comment\" rows=\"7\" cols=\"50\" class=\"input-box\"></textarea>
	<br /><input type=\"submit\" class=\"submit-button\" value=\"" . $REPLY_ADDREPLY . "\"><p>
	</FORM>";
	
	$showform = '0';
	break;
	
// QUICK REPLY TO MESSAGE
	case extquickreply:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $lang . "/c_common.php" );
	include( "lang/" . $lang . "/c_contact.php" );
	
	$query2 = " SELECT name FROM ttcm_user WHERE id = '" . $_GET['id'] . "'";
	$retid2 = $db_q($db, $query2, $cid);

	$row2 = $db_f($retid2);
	$client_name = $row2[ "name" ];
	$client_name = stripslashes($client_name);

	$message_html .= "<p class=\"message-date\">Resposta R&aacute;pida de " . $client_name . ":</p>\n";
	
	$message_html .= "<FORM NAME=\"add\" ACTION=\"message.php?pg=readmsg&amp;mid=" . $_GET['mid'] . "&amp;id=" . $_GET['id'] . "&amp;vid=" . $_GET['vid'] . "\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"post_by\" value=\"" . $client_name . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_SESSION['client_id'] . "\">
	<input type=\"hidden\" name=\"mid\" value=\"" . $_GET['mid'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"addextquickreply\">
	<textarea name=\"comment\" rows=\"7\" cols=\"50\" class=\"input-box\"></textarea>
	<br /><input type=\"submit\" class=\"submit-button\" value=\"" . $REPLY_ADDREPLY . "\"><p>
	</FORM>";
	
	$showform = '0';
	break;
	
// ADD A NEW MESSAGE
	case addmessage:
	
	global $cid, $db_q, $db_c, $db_f, $db;
		
	$SQL2 = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $_SESSION['client_id'] . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
							
		$project_string = "<option value=\"0\">" . $COMMON_NOPROJECT . "</option>\n";

		while( $my_clients = $db_f( $retid2 ) )
		{
			$project_string .= "<option value=\"" . $my_clients[ 'project_id' ] . "\"";
			if ($my_clients[ 'project_id' ] == $_GET['pid']) {
				$project_string .= " selected"; 
			}
			$project_string .= ">" . $my_clients[ 'title' ] . "</option>\n";
			
		}

	echo ("<p>" . $ADDMESSAGE_MAINTEXT . "<p>
	<FORM NAME=\"add\" ACTION=\"main.php?pg=addmsg\" METHOD=\"POST\">
	<input type=\"hidden\" name=\"post_by\" value=\"" . $_SESSION['client_name'] . "\">
	<input type=\"hidden\" name=\"clid\" value=\"" . $_SESSION['client_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"addmessage\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
	<tr>
		<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_MESSAGES . "</td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_PROJECT . ":</strong></td>
		<td valign=\"top\" class=\"body\"><select name=\"pid\" class=\"body\">" . $project_string . "</select></td>
	</tr>
	<tr>
		<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_TITLE . ":</strong></td>
		<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"head\" name=\"message_title\"></td>
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

// MODIFY CLIENT INFORMATION
	case modifyc:
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
	
	$query = " SELECT company, country, address1, address2, city, state, zip, phone, phone_alt, fax FROM ttcm_client WHERE client_id = '" . $_SESSION['client_id'] . "' ";
	$retid = $db_q($db, $query, $cid);
	
	$row = $db_f($retid);
	$old_client_company = $row[ "company" ];
	$old_client_company = stripslashes($old_client_company);
	$old_country = $row[ "country" ];
	$old_country = stripslashes($old_country);
	$old_address1 = $row[ "address1" ];
	$old_address1 = stripslashes($old_address1);
	$old_address2 = $row[ "address2" ];
	$old_address2 = stripslashes($old_address2);
	$old_city = $row[ "city" ];
	$old_city = stripslashes($old_city);
	$old_state = $row[ "state" ];
	$old_state = stripslashes($old_state);
	$old_zip = $row[ "zip" ];
	$old_phone = $row[ "phone" ];
	$old_phone_alt = $row[ "phone_alt" ];
	$old_fax = $row[ "fax" ];

		echo("<FORM NAME=\"add\" ACTION=\"main.php?pg=clientmod\" METHOD=\"POST\">
		<input type=\"hidden\" name=\"clid\" value=\"" . $_SESSION['client_id'] . "\">
		<input type=\"hidden\" name=\"task\" value=\"savecinfo\">
		<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
			<tr>
				<td class=\"title\" valign=\"top\" colspan=\"2\">" . $COMMON_CLIENT . "</td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COMPANY . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"30\" class=\"head\" name=\"new_client_company\" value=\"" . $old_client_company . "\"></td>
			</tr>
			<tr>
				<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_LOCATION . "</td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_ADDRESS . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"head\" NAME=\"new_address1\" value=\"" . $old_address1 . "\"><p>
			<input type=\"text\" size=\"40\" class=\"head\" NAME=\"new_address2\" value=\"" . $old_address2 . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_CITY . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"30\" class=\"head\" NAME=\"new_city\" value=\"" . $old_city . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_STATE . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"20\" class=\"head\" name=\"new_state\" value=\"" . $old_state . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_ZIP . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"15\" class=\"head\" NAME=\"new_zip\" value=\"" . $old_zip . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_COUNTRY . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"25\" class=\"head\" NAME=\"new_country\" value=\"" . $old_country . "\"></td>
			</tr>
			<tr>
				<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $COMMON_CONTACTINFO . "</td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_MAINPHONE . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"20\" class=\"head\" name=\"new_phone\" value=\"" . $old_phone . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_ALTPHONE . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"20\" class=\"head\" name=\"new_phone_alt\" value=\"" . $old_phone_alt . "\"></td>
			</tr>
			<tr>
				<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $COMMON_FAX . ":</strong></td>
				<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"20\" class=\"head\" name=\"new_fax\" value=\"" . $old_fax . "\"></td>
			</tr>
			<tr>
				<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"lrg\" value=\"" . $COMMON_SAVE . "\"></td>
			</tr>
		</table>
	</FORM>");
	break;
	
	case modifyy:
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
	
		echo("<FORM NAME=\"change\" ACTION=\"main.php?pg=usermod\" METHOD=\"POST\">
            <input type=\"hidden\" name=\"vid\" value=\"" . $_SESSION['valid_id'] . "\">
			<input type=\"hidden\" name=\"old_email\" value=\"" . $_SESSION['client_email'] . "\">
			<input type=\"hidden\" name=\"task\" value=\"usermod\">
			<h3>" . $COMMON_FULLNAME . "</h3>
			<label for=\"name\">" . $COMMON_FULLNAME . ":</label>
			<input type=\"text\" size=\"30\" id=\"name\" name=\"new_name\" value=\"" . $_SESSION['client_name'] . "\">
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
			<h3>" . $COMMON_CONTACTINFO . "</h3>
			<label for=\"new_user_phone\">" . $COMMON_MAINPHONE . ":</label>
			<input type=\"text\" size=\"20\" id=\"new_user_phone\" name=\"new_user_phone\" value=\"" . $_SESSION[ 'user_phone' ] . "\"><br />
			<label for=\"new_user_phone_alt\">" . $COMMON_ALTPHONE . ":</label>
			<input type=\"text\" size=\"20\" id=\"new_user_phone_alt\" name=\"new_user_phone_alt\" value=\"" . $_SESSION[ 'user_phone_alt' ] . "\"><br />
			<label for=\"new_user_fax\">" . $COMMON_FAX . ":</label>
			<input type=\"text\" size=\"20\" id=\"new_user_fax\" name=\"new_user_fax\" value=\"" . $_SESSION[ 'user_fax' ] . "\"><br />
			<label for=\"new_admin_email\">" . $COMMON_EMAIL . ":</label>
			<input type=\"text\" size=\"35\" id=\"email\" name=\"new_email\" value=\"" . $_SESSION['client_email'] . "\"><br />
			
			<br />

			<br /><input type=\"submit\" class=\"lrg\" value=\"" . $COMMON_SAVE . "\">
			</FORM>");
		break;
	
	case changepw:
	
		include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
		include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );
	
		echo("<FORM NAME=\"edit\" ACTION=\"main.php?pg=changepw\" METHOD=\"POST\">
		<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
		<input type=\"hidden\" name=\"vid\" value=\"" . $_SESSION['valid_id'] . "\">
		<input type=\"hidden\" name=\"task\" value=\"changepw\">
		<tr>
			<td class=\"title\" valign=\"top\" colspan=\"2\">" . $USER_NEWPW . "</td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $USER_ENTERPW . ":</strong></td>
			<td valign=\"top\" class=\"body\"><input type=\"password\" size=\"35\" class=\"head\" name=\"newpassword\"></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"lrg\" value=\"" . $COMMON_SAVE . "\"></td>
		</tr>
	</table>
	</form>");
	break;
	
	case uploadc:
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_contact.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	
	$SQL = " SELECT title, project_id FROM ttcm_project WHERE client_id = '" . $_SESSION['client_id'] . "'";
	$retid2 = $db_q($db, $SQL, $cid);
									
	$project_string = "<option value=\"0\">" . $UPLOADS_NOPROJECT . "</option>\n";

	while( $my_client = $db_f( $retid2 ) )
	{
		$project_title = $my_client[ "title" ];
		$project_title = stripslashes($project_title);
		$project_id = $my_client[ "project_id" ];
				
		$project_string .= "<option value=\"" . $project_id . "\"";
		$project_string .= ">" . $project_title . "</option>\n";
	}

	echo("<form enctype=\"multipart/form-data\" action=\"main.php?pg=uploads\" method=\"POST\">
	<input type=\"hidden\" name=\"client_id\" value=\"" . $_SESSION['client_id'] . "\">
	<input type=\"hidden\" name=\"task\" value=\"uploadc\">
	<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $CONTACT_FORPROJECT . ":</strong></td>
			<td valign=\"top\" class=\"body\"><select name=\"pid\" class=\"body\">" . $project_string . "</select></td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><strong>" . $UPLOADS_FILETITLE . ":</strong></td>
			<td valign=\"top\" class=\"body\"><input type=\"text\" size=\"40\" class=\"head\" NAME=\"file_title\"></td>
		</tr>
		<tr>
			<td class=\"title\" valign=\"top\" colspan=\"2\"><br />" . $UPLOADS_THEFILE . "</td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $UPLOADS_CHOOSEFILE . "</strong></td>
			<td valign=\"top\" class=\"body\"><br /><input name=\"file\" type=\"file\" SIZE=\"25\" class=\"lrg\"></td>
		</tr>
		<tr>
			<td class=\"body\" valign=\"top\" colspan=\"2\"><br /><strong>-- " . $UPLOADS_OR . " --</strong></td>
		</tr>
		<tr>
			<td class=\"body\" align=\"right\" valign=\"top\"><br /><strong>" . $UPLOADS_LINKFILE . "</strong></td>
			<td valign=\"top\" class=\"body\"><br /><input type=\"text\" size=\"40\" class=\"input-box\" name=\"input_link\"></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><br /><input type=\"submit\" class=\"lrg\" value=\"" . $UPLOADS_ADDFILE . "\"></td>
		</tr>
	</table>
	</form>");
	break;

	default:
		break;
}
?>