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

// TEMPLATE CLASS
class Page
{
  var $page;

  function Page($template = "../templates/admin_template.tpl") {
    if (file_exists($template))
      $this->page = join("", file($template));
    else
      die("Template file $template not found.");
  }

  function parse($file) {
    ob_start();
    include($file);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }

  function replace_tags($tags = array()) {
    if (sizeof($tags) > 0)
      foreach ($tags as $tag => $data) {
        $data = (file_exists($data)) ? $this->parse($data) : $data;
        $this->page = eregi_replace("{" . $tag . "}", $data,
                      $this->page);
        }
    else
      die("No tags designated for replacement.");
  }

  function output() {
    echo $this->page;
  }
}

// CLIENT USERS
function client_users($clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_userinfo.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$cusers = "<h2>" . $ALLUSERS_THISCLIENT;
	// check if user has User permissions
	if (in_array("26", $user_perms)) {
		$cusers .= " <a href=\"main.php?pg=adduser&amp;clid=" . $clid . "\" title=\"Adicionar um Usuário\">[ " . $COMMON_ADD . " ]</a></td>\n";
	}
	$cusers .= "</h2>";
	$cusers .= "<table class=\"table\">\n";
   	$cusers .= "<tr class=\"title\">\n";
	$cusers .= "<td class=\"left\">" . $COL_USER . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=name&amp;cluser_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=name&amp;cluser_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
 	$cusers .= "<td class=\"left\">" . $COL_UNEMAIL . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=username&amp;cluser_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=username&amp;cluser_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$cusers .= "<td class=\"left\">" . $COL_LASTLOGIN . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=last_login&amp;cluser_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cluser_oby=last_login&amp;cluser_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$cusers .= "<td>" . $COL_MODIFY . "</td>\n";
   	$cusers .= "</tr>\n";

   	$SQL = " SELECT name, email, username, last_login, id FROM ttcm_user WHERE client_id = '" . $clid . "' ORDER BY " . $_SESSION['cluser_oby'] . " " . $_SESSION['cluser_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == 0) { 
		$cusers .= "<tr>\n";
      	$cusers .= "<td class=\"left\" colspan=\"4\">" . $ALLUSERS_NOUSERS . "</td>\n";
      	$cusers .= "</tr>\n";
   }
	else {
	
		while ( $row = $db_f($retid) ) {
			$last_login = $row['last_login'];
			
			$SQL2 = " SELECT DATE_FORMAT('$last_login','$_SESSION[date_format] as %l:%i %p') AS last_login2 FROM ttcm_user WHERE id = '" . $row[ 'id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$login_date = $row2[ "last_login2" ];
			$name = stripslashes($row[ 'name' ]);
			$username = stripslashes($row[ 'username' ]);
			
			if ($login_date == '0/0/0000 as 12:00 AM') {
				$login_date = "Not logged in yet";
			}
			
			$cusers .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n"; 
         	$cusers .= "<td class=\"left\">" . $name . "</td>\n";
         	$cusers .= "<td class=\"left\"><a href=\"mailto:" . $row[ 'email' ] . "\">" . $username . "</a></td>\n";
			$cusers .= "<td class=\"left\">" . $login_date . "</td>\n";
         	$cusers .= "<td>";

			// check if user has User permissions
			if (in_array("27", $user_perms)) {
				$cusers .= "<a href=\"main.php?pg=edituser&amp;uid=" . $row[ 'id' ] . "\" title=\"Editar " . $name . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			
			// check if user has User permissions
			if (in_array("28", $user_perms)) {
				$cusers .= "<a href=\"main.php?pg=deluser&amp;uid=" . $row[ 'id' ] . "\" title=\"Excluir " . $name . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			
			$cusers .= "</td>\n";
         	$cusers .= "</tr>\n";
		}
	}
	$cusers .= "</table>\n";
	
	return $cusers;

}

// Lista de Clientes
function client_list() {

	global $vid, $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$client_html = "<h2>" . $CLIENTS_HEADER;
	// check if user has Client permissions
	if (in_array("15", $user_perms)) {
		$client_html .= " <a href=\"main.php?pg=addclient\" title=\"Adicionar um Cliente\">[ " . $COMMON_ADD . " ]</a>";
	}
	$client_html .= "</h2>";
	$client_html .= "<table class=\"table\">\n";
   	$client_html .= "<tr class=\"title\">\n";
   	$client_html .= "<td class=\"left\">" . $COL_CLIENT . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clist_oby=company&amp;clist_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"". $_SERVER['REQUEST_URI'] . "&amp;clist_oby=company&amp;clist_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$client_html .= "<td class=\"left\">" . $COL_PROJECTS . "</td>\n";
   	$client_html .= "<td>" . $COL_ACCTSTATUS . "</td>\n";
   	$client_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$client_html .= "</tr>\n";
   
	$SQL = " SELECT client_id, company FROM ttcm_client ORDER BY " . $_SESSION['clist_oby'] . " " . $_SESSION['clist_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
		while ( $row = $db_f($retid) ) {
			
			$SQL3 = " SELECT status FROM ttcm_account WHERE client_id = '" . $row[ 'client_id' ] . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			
			$SQL2 = " SELECT * FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') ) AND client_id = '" . $row[ 'client_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$proj_number = $db_c( $retid2 );

			$client_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n"; 
         	$client_html .= "<td class=\"left\"><a href=\"main.php?pg=client&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row[ 'company' ]) . "\"><strong>" . stripslashes($row[ 'company' ]) . "</strong></a></td>\n";
         	$client_html .= "<td class=\"left\"><a href=\"main.php?pg=projects&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row[ 'company' ]) . " Projects\">" . $COMMON_VIEWPROJECTS . " (" . $proj_number . ")</a></td>\n";
         	$client_html .= "<td>" . $row3[ "status" ] . "</td>\n";
         	$client_html .= "<td>";
			
			// check if user has Client permissions
			if (in_array("16", $user_perms)) {
				$client_html .= "<a href=\"main.php?pg=editclient&amp;clid=" . $row[ 'client_id' ] ."\" title=\"Editar " . stripslashes($row[ 'company' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			
			// check if user has Client permissions
			if (in_array("17", $user_perms)) {
				$client_html .= "<a href=\"main.php?pg=delclient&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'company' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$client_html .= "</td>\n";
         	$client_html .= "</tr>\n";
		}
	$client_html .= "</table>\n";
	
	return $client_html;
}

// ALL PROJECTS
function all_projects($clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$allproj = "<h2>" . $ALLPROJECTS_ALLPROJ . "</h2>\n";
	$allproj .= "<table class=\"table\">\n";
   	$allproj .= "<tr class=\"title\">\n";
   	$allproj .= "<td class=\"left\">" . $COL_PROJTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=title&amp;allproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=title&amp;allproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$allproj .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=milestone&amp;allproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=milestone&amp;allproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$allproj .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=finish&amp;allproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=finish&amp;allproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$allproj .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=status&amp;allproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allproj_oby=status&amp;allproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$allproj .= "<td>" . $COL_MODIFY . "</td>\n";
   	$allproj .= "</tr>\n";

	if ( ( $clid != '' ) && ( $clid != '0' ) ) {

		$query = " SELECT company FROM ttcm_client WHERE client_id = '" . $clid . "' ";
		$retid = $db_q($db, $query, $cid);
		$row = $db_f($retid);
		$client_company = stripslashes($row[ 'company' ]);
		$add_where = " AND client_id = '" . $clid . "'";
	}
   
	$SQL = "SELECT milestone, updated, finish, client_id, project_id, title, status FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') )" . $add_where . " ORDER BY " . $_SESSION['allproj_oby'] . " " . $_SESSION['allproj_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	$count = 0;
	
	if ($number == 0) {
		$allproj .= "<tr>\n";
   		$allproj .= "<td class=\"left\" colspan=\"5\">" . $ALLPROJECTS_NOPASTPROJ . "</td>\n";
   		$allproj .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$milestone = $row[ "data limite" ];
			$updated = $row[ "updated" ];
			$finish = $row[ "finish" ];
			
			$SQL2 = " SELECT DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS updated2, DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestones2 FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$milestone2 = $row2[ "milestones2" ];
			$finished2 = $row2[ "finish2" ];
			$updated2 = $row2[ "updated2" ];

			$allproj .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$allproj .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Ver " . stripslashes($row[ 'title' ]) . "\">" . stripslashes($row[ 'title' ]) . "</a></td>\n";

			if ( $finish == '0000-00-00' ) {
				$today = date("Ymd");
				
				$first_year = substr($today,0,4);
				$first_month = substr($today,4,2);
				$first_day = substr($today,6,2);
				
				$second_year = substr($milestone,0,4);
				$second_month = substr($milestone,5,2);
				$second_day = substr($milestone,8,2);
				
				$first_unix = mktime(00,00,00,$first_month,$first_day,$first_year);
				$second_unix = mktime(00,00,00,$second_month,$second_day,$second_year);

				$timediff = $second_unix - $first_unix;  
				
				if ( $timediff < '0' ) {
					$allproj .= "<td class=\"maroon\">" . $milestone2 . "</td>\n";
					$allproj .= "<td>NA</td>\n";
				}
				else { 
					$allproj .= "<td>" . $milestone2 . "</td>\n";
					$allproj .= "<td>NA</td>\n";
				}
			}
			
			else {
				$allproj .= "<td>" . $milestone2 . "</td>\n";
				$allproj .= "<td>" . $finished2 . "</td>\n";
			}
			
         	$allproj .= "<td>" . $row[ 'status' ] . "</td>\n";
			$allproj .= "<td>";
			
			// check if user has Project permissions
			if (in_array("3", $user_perms)) {
				$allproj .= "<a href=\"main.php?pg=editproj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			
			// check if user has Project permissions
			if (in_array("4", $user_perms)) {
				$allproj .= "<a href=\"main.php?pg=delproj&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$allproj .= "</td>\n";
         	$allproj .= "</tr>\n";

		}
	}
   $allproj .= "</table>\n";

	return $allproj;
}

// ALL FILES BY TYPE
function allfiles_bytype($type_id) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$SQL2 = " SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $type_id . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
	$row2 = $db_f($retid2);

	$bytype = "<h2>" . $row2[ 'file_type' ];
	// check if user has File permissions
	if (in_array("22", $user_perms)) {
		$bytype .= " <a href=\"main.php?pg=addfiles\" title=\"Adicionar Documento\">[ " . $COMMON_ADD . " ]</a>";
	}
	$bytype .= "</h2>\n";
	$bytype = "<table class=\"table\">\n";
   	$bytype .= "<tr class=\"title\">\n";
   	$bytype .= "<td class=\"left\">" . $COL_CLIENT . "</td>\n";
   	$bytype .= "<td class=\"left\">" . $COL_FILETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;type_id=" . $_GET['type_id'] . "&amp;allftype_oby=name&amp;allftype_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;type_id=" . $_GET['type_id'] . "&amp;allftype_oby=name&amp;allftype_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$bytype .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;type_id=" . $_GET['type_id'] . "&amp;allftype_oby=added&amp;allftype_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;type_id=" . $_GET['type_id'] . "&amp;allftype_oby=added&amp;allftype_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$bytype .= "<td>" . $COL_MODIFY . "</td>\n";
   	$bytype .= "</tr>\n";

	$SQL = "SELECT added, file_id, client_id, link, name, project_id FROM ttcm_files WHERE type_id = '" . $type_id . "' ORDER BY " . $_SESSION['allftype_oby'] . " " . $_SESSION['allftype_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ($number == '0') {
		$bytype .= "<tr>\n";
      	$bytype .= "<td class=\"left\" colspan=\"4\">" . $ALLTYPE_NOFILES . "</td>\n";
      	$bytype .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$added = $row['added'];
			$project_id = $row[ 'project_id' ];
			$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
			
			if ($project_id != '0') {
				
				$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
				$retid4 = $db_q($db, $query4, $cid);
				$row4 = $db_f($retid4);
				$file_perms = $row4['permissions'];
			
				$user_id = $_SESSION['valid_id'];
				$file_vars = split(',', $file_perms);
			
				if (in_array($user_id, $file_vars)) {
			
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT company FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
				$retid3 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid3);

				$bytype .= "<tr bgcolor=\"$outcolor\" onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         		$bytype .= "<td class=\"left\">" . stripslashes($row3[ 'company' ]) . "</td>\n";
         		$bytype .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
         		$bytype .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         		$bytype .= "<td>";

				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$bytype .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has File permissions
				if (in_array("24", $user_perms)) {
					$bytype .= "<a href=\"main.php?pg=filesbytype&amp;type_id=" . $type_id . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$bytype .= "</td>\n";
         		$bytype .= "</tr>\n";
				}
			}
			else {
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT company FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
				$retid3 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid3);

				$bytype .= "<tr bgcolor=\"$outcolor\" onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         		$bytype .= "<td class=\"left\">" . stripslashes($row3[ 'company' ]) . "</td>\n";
         		$bytype .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
         		$bytype .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         		$bytype .= "<td>";

				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$bytype .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has File permissions
				if (in_array("24", $user_perms)) {
					$bytype .= "<a href=\"main.php?pg=filesbytype&amp;type_id=" . $type_id . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$bytype .= "</td>\n";
         		$bytype .= "</tr>\n";
			}
		}
	}

   $bytype .= "</table>\n";

	return $bytype;
}

// ALL MESSAGES
function all_messages() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$message_html = "<p>" . $ALLMESSAGES_MAINTEXT . "</p>\n";
	$message_html .= "<h2>" . $ALLMESSAGES_PREVIOUS;
	
	// check if user has Messages permissions
	if (in_array("10", $user_perms)) {
		$message_html .= " <a href=\"main.php?pg=addmsg\" title=\"Escrever Mensagem\">[ " . $COMMON_ADD . " ]</a>";
	}
	$message_html .= "</h2>\n";
	$message_html .= "<table class=\"table\">\n";
  	$message_html .= "<tr class=\"title\">\n";
   	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$message_html .= "<td class=\"left\">" . $COL_POSTDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=posted&amp;allmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"" . $_SERVER['REQUEST_URI']. "&amp;allmessages_oby=posted&amp;allmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$message_html .= "<td class=\"left\">" . $COL_POSTBY . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
	$message_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$message_html .= "</tr>\n";
				
	$SQL = " SELECT posted, message_id, message_title, post_by, client_id, project_id FROM ttcm_messages ORDER BY " . $_SESSION['allmessages_oby'] . " " . $_SESSION['allmessages_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$message_html .= "<tr>\n";
      	$message_html .= "<td class=\"left\" colspan=\"5\">" . $ALLMESSAGES_NOPREVIOUS . "</td>\n";
    	$message_html .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$posted = $row[ 'posted' ];
			
			$SQL2 = " SELECT DATE_FORMAT('$posted','$_SESSION[date_format] as %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $row[ 'message_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$SQL3 = " SELECT * FROM ttcm_comments WHERE message_id = '" . $row[ 'message_id' ] ."'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$repnum = $db_c( $retid3 );

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] ."\" title=\"Ver Mensagem\">" . stripslashes($row[ 'message_title' ]) . "</a></td>\n";
         	$message_html .= "<td class=\"left\">" . $row2[ "posted2" ] ."</td>\n";
         	$message_html .= "<td class=\"left\">" . $row[ 'post_by' ] . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
			$message_html .= "<td>";
			// check if user has Message permissions
			if (in_array("12", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=editmsg&amp;mid=" . $row[ 'message_id' ] ."&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Editar Mensagem\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has Messages permissions
			if (in_array("13", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=allmsg&amp;mid=" . $row[ 'message_id' ] ."&amp;task=delmessage\" title=\"Excluir Mensagem\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$message_html .= "</td>\n";
         	$message_html .= "</tr>\n";
		}
	}
	$message_html .= "</table>\n";
	
	return $message_html;
}

// ALL USERS
function all_users() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_userinfo.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$all_html = "<h2>" . $ALLUSERS_USERLIST . "</h2>\n";
   	$all_html .= "<table class=\"table\">\n";
   	$all_html .= "<tr class=\"title\">\n";
   	$all_html .= "<td class=\"left\">" . $COL_NAME . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=name&amp;allusers_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=name&amp;allusers_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$all_html .= "<td class=\"left\">" . $COL_CLIENT . "</td>\n";
   	$all_html .= "<td class=\"left\">" . $COL_USERNAME . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=username&amp;allusers_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=username&amp;allusers_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$all_html .= "<td class=\"left\">" . $COL_LASTLOGIN . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=last_login&amp;allusers_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allusers_oby=last_login&amp;allusers_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$all_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$all_html .= "</tr>\n";
	
	$SQL = " SELECT username, id, client_id, name, last_login, permissions FROM ttcm_user ORDER BY " . $_SESSION['allusers_oby'] . " " . $_SESSION['allusers_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
		while ( $row = $db_f($retid) ) {
			$last_login = $row[ "last_login" ];
			
			$SQL3 = " SELECT DATE_FORMAT('$last_login','$_SESSION[date_format] as %l:%i %p') AS last_login2 FROM ttcm_user WHERE id = '" . $row['id'] . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			
			$SQL2 = " SELECT company FROM ttcm_client WHERE client_id = '" . $row['client_id'] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
	
			$all_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
      		$all_html .= "<td class=\"left\"><strong>" . stripslashes($row['name']) . "</strong></td>\n";
      		$all_html .= "<td class=\"left\">";

			if ($row2[ 'company' ] != '') {
				$all_html .= "<a href=\"main.php?pg=client&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row2[ 'company' ]) . "\">" . stripslashes($row2[ 'company' ]) . "</a>";
			} 
			else {
				$all_html .= $COMMON_ADMIN;
			}
		
			$all_html .= "</td>\n";
      		$all_html .= "<td class=\"left\">" . $row[ 'username' ] . "</td>\n";
			$all_html .= "<td class=\"left\">" . $row3[ 'last_login2' ] . "</td>\n";
      		$all_html .= "<td>";
			// check if user has User permissions
			if (in_array("27", $user_perms)) {
				$all_html .= "<a href=\"main.php?pg=edituser&amp;uid=" . $row[ 'id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("28", $user_perms)) {
				$all_html .= "<a href=\"main.php?pg=deluser&amp;uid=" . $row[ 'id' ] . "\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$all_html .= "</td>\n";
      		$all_html .= "</tr>\n";
			
		}
	$all_html .= "</table>\n";
	return $all_html;
}

// SHOW ACCOUNT OPTIONS
function show_options($type, $title) {

	global $db, $db_q, $cid, $db_f;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$option_html = "<h2>" . $title . " " . $COMMON_OPTIONS . "</h2>\n";
   	$option_html .= "<table class=\"table\">\n";
   	$option_html .= "<tr class=\"title\">\n";
   	$option_html .= "<td class=\"left\">" . $COL_OPTIONTITLE . "</td>\n";
   	$option_html .= "<td>" . $COL_EDIT . "</td>\n";
   	$option_html .= "<td>" . $COL_DELETE . "</td>\n";
   	$option_html .= "</tr>\n";

	$SQL = " SELECT status_id, name FROM ttcm_status WHERE type = '" . $type . "'";
	$retid = $db_q($db, $SQL, $cid);
	
	while ( $row = $db_f($retid) ) {
		$status_id = $row[ "status_id" ];
		$name = stripslashes($row[ 'name' ]);
		
		$option_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
      	$option_html .= "<td class=\"left\">" . $name . "</td>\n";
      	$option_html .= "<td>";
		// check if user has Status permissions
		if (in_array("56", $user_perms)) {
			$option_html .= "<a href=\"main.php?pg=statusoptions&amp;status_id=" . $row[ 'status_id' ] . "\" title=\"Editar " . $name . "\"><img src=\"../images/edit.gif\" border=\"0\"></a>";
		}
		$option_html .= "</td>\n";
      	$option_html .= "<td align=\"center\" class=\"body\">";
		// check if user has Status permissions
		if (in_array("58", $user_perms)) {
			$option_html .= "<a href=\"main.php?pg=status&amp;task=delstat&amp;status_id=" . $row[ 'status_id' ] . "\" title=\"Excluir " . $name . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
		}
		$option_html .= "</td>\n";
      	$option_html .= "</tr>\n";
	}
	$option_html .= "</table>\n";
	
	return $option_html;
}

// PROJECT SEARCH
function project_search($search) {
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$psearch_html = '';
	
	$SQL = " SELECT client_id, project_id, title, start, finish, status FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') ) AND title LIKE '%" . $search . "%' ORDER BY " . $_SESSION['projsearch_oby'] . " " . $_SESSION['projsearch_lby'];
	$retid = $db_q($db, $SQL, $cid);
			 
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$psearch_html .= "<h1>" . $SEARCH_NOPROJ . "</h2>\n";
		$psearch_html .= "<p>" . $SEARCH_TRYAGAIN . "</p>\n";
	} 
	else {
        $psearch_html .= "<h2>" . $PROJECTS_PROJECTS . "</h2>\n";
        $psearch_html .= "<table class=\"table\">\n";
        $psearch_html .= "<tr class=\"title\">\n";
        $psearch_html .= "<td class=\"left\">" . $COL_PROJTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=title&amp;projsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=title&amp;projsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
        $psearch_html .= "<td>" . $COL_STARTDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=start&amp;projsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=start&amp;projsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
        $psearch_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=status&amp;projsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=status&amp;projsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
        $psearch_html .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=finish&amp;projsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=project&projsearch_oby=finish&amp;projsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$psearch_html .= "<td>" . $COL_MODIFY . "</td>\n";
        $psearch_html .= "</tr>\n";
        
        while ( $row = $db_f($retid) ) {
			$finish = $row[ 'finish' ];
			$start = $row[ 'start' ];
			
			$SQL2 = " SELECT DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_project WHERE project_id = '" . $row['project_id'] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$psearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $psearch_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Ver " . stripslashes($row[ 'title' ]) . "\">" . stripslashes($row[ 'title' ]) . "</a></td>\n";
            $psearch_html .= "<td>" . $row2[ 'start2' ] . "</td>\n";
            $psearch_html .= "<td>" . $row[ 'status' ] . "</td>\n";
            $psearch_html .= "<td>\n";
            if ( $finish == '0000-00-00' ) { 
            	$psearch_html .= "NA";
            } else { 
            	$psearch_html .= $row2[ 'finish2' ];
            }
            $psearch_html .= "</td>\n";
			$psearch_html .= "<td>";
				// check if user has Project permissions
				if (in_array("3", $user_perms)) {
					$psearch_html .= "<a href=\"main.php?pg=editproj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has Project permissions
				if (in_array("4", $user_perms)) {
					$psearch_html .= "<a href=\"main.php?pg=delproj&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$psearch_html .= "</td>\n";
				$psearch_html .= "</tr>\n";
		}
		$psearch_html .= "</table>\n";
	}
	
	return $psearch_html;
}

// DOWNLOADS SEARCH
function download_search($search) {
	
	global $cid, $db_q, $db_c, $db_f, $db, $web_path;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$dsearch_html = '';
	
	$SQL = " SELECT file_id, type_id, project_id, file, name, link, added FROM ttcm_files WHERE ( (file LIKE '%" . $search . "%') OR (name LIKE '%" . $search . "%') ) ORDER BY " . $_SESSION['dlsearch_oby'] . " " . $_SESSION['dlsearch_lby'];
	$retid = $db_q($db, $SQL, $cid);
			 
	$number = $db_c( $retid );
	if ( $number == '0' ) {
		$dsearch_html .= "<h1>" . $SEARCH_NODL . "</h1>\n";
		$dsearch_html .= "<p>" . $SEARCH_TRYAGAIN . "</p>\n";
	} 
	else {
    	$dsearch_html .= "<h2>" . $FILES_PROJECTFILES . "</h2>\n";
    	$dsearch_html .= "<table class=\"table\">\n";
    	$dsearch_html .= "<tr class=\"title\">\n";
    	$dsearch_html .= "<td class=\"left\">" . $COL_FILETYPE . "</td>\n";
    	$dsearch_html .= "<td class=\"left\">" . $COL_FILETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=name&amp;dlsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=name&amp;dlsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    	$dsearch_html .= "<td>" . $COL_PROJTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=project_id&amp;dlsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=project_id&amp;dlsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    	$dsearch_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=added&amp;dlsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=download&dlsearch_oby=added&amp;dlsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$dsearch_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$dsearch_html .= "</tr>\n";
    
    	while ( $row = $db_f($retid) ) {
			$added = $row[ 'added' ];
			$project_id = $row[ 'project_id' ];
			
			$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
			
			if ($project_id != '0') {
				
				$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
				$retid4 = $db_q($db, $query4, $cid);
				$row4 = $db_f($retid4);
				$file_perms = $row4['permissions'];
			
				$user_id = $_SESSION['valid_id'];
				$file_vars = split(',', $file_perms);
			
				if (in_array($user_id, $file_vars)) {
			
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$SQL3 = " SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $row[ 'type_id' ] . "'";
				$retid3 = $db_q($db, $SQL3, $cid);
				$row3 = $db_f($retid3);
			
				if ( $row[ 'project_id' ] == '0' ) {
					$project_title = "Nenhum Processo Especificado";
				}
				else {
					$SQL4 = " SELECT * FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
					$retid4 = $db_q($db, $SQL4, $cid);
					$row4 = $db_f($retid4);
					$project_title = stripslashes($row4[ 'title' ]);
				}
			
				$dsearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            	$dsearch_html .= "<td class=\"left\">" . stripslashes($row3[ 'file_type' ]) . "</td>\n";
            	$dsearch_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\" title=\"Ver " . stripslashes($row[ 'name' ]) . "\">" . stripslashes($row[ 'name' ]) . "</td>\n";
            	$dsearch_html .= "<td>" . $project_title . "</td>\n";
            	$dsearch_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
				$dsearch_html .= "<td>";
				
				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$dsearch_html .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a>";
				}
				$dsearch_html .= "</td>\n";
            	$dsearch_html .= "</tr>\n";
				}
			}
			else {
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$SQL3 = " SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $row[ 'type_id' ] . "'";
				$retid3 = $db_q($db, $SQL3, $cid);
				$row3 = $db_f($retid3);
			
				if ( $row[ 'project_id' ] == '0' ) {
					$project_title = "Nenhum Processo Especificado";
				}
				else {
					$SQL4 = " SELECT * FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
					$retid4 = $db_q($db, $SQL4, $cid);
					$row4 = $db_f($retid4);
					$project_title = stripslashes($row4[ 'title' ]);
				}
			
				$dsearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            	$dsearch_html .= "<td class=\"left\">" . stripslashes($row3[ 'file_type' ]) . "</td>\n";
            	$dsearch_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\" title=\"Ver " . stripslashes($row[ 'name' ]) . "\">" . stripslashes($row[ 'name' ]) . "</td>\n";
            	$dsearch_html .= "<td>" . $project_title . "</td>\n";
            	$dsearch_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
				$dsearch_html .= "<td>";
				
				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$dsearch_html .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a>";
				}
				$dsearch_html .= "</td>\n";
            	$dsearch_html .= "</tr>\n";
			}
		}
		$dsearch_html .= "</table>\n";
	} 
	
	return $dsearch_html;
}

// CLIENT SEARCH
function client_search($search) {
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$csearch_html = '';
	
	$SQL = " SELECT client_id, company FROM ttcm_client WHERE company LIKE '%" . $search . "%' ORDER BY " . $_SESSION['clsearch_oby'] . " " . $_SESSION['clsearch_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	if ( $number == '0' ) {
		$csearch_html .= "<h1>" . $SEARCH_NOCLIENTS . "</h1>\n";
		$csearch_html .= "<p>" . $SEARCH_TRYAGAIN . "</p>\n";
	} 
	else {
        $csearch_html .= "<h2>" . $CLIENTS_HEADER . "</h2>\n";
        $csearch_html .= "<table class=\"table\">\n";
        $csearch_html .= "<tr class=\"title\">\n";
        $csearch_html .= "<td class=\"left\">" . $COL_CLIENT . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=client&clsearch_oby=company&amp;clsearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=client&clsearch_oby=company&amp;clsearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
        $csearch_html .= "<td class=\"left\">" . $COL_PROJECTS . "</td>\n";
        $csearch_html .= "<td>" . $COL_ACCTSTATUS . "</td>\n";
        $csearch_html .= "<td>" . $COL_MODIFY . "</td>\n";
        $csearch_html .= "</tr>";

        while ( $row = $db_f($retid) ) {
			
			$SQL2 = " SELECT * FROM ttcm_account WHERE client_id = '" . $row[ 'client_id' ] . "' ";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$csearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $csearch_html .= "<td class=\"left\"><a href=\"main.php?pg=client&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row[ 'company' ]) . "\"><strong>" . stripslashes($row[ 'company' ]) . "</strong></a></td>\n";
            $csearch_html .= "<td class=\"left\"><a href=\"main.php?pg=projects&amp;clid=" . $row[ 'client_id' ] . "\" title=\"" . stripslashes($row[ 'company' ]) . " Projects\">View Projects</a></td>\n";
            $csearch_html .= "<td>" . $row2[ "status" ] . "</td>\n";
            $csearch_html .= "<td>";
				// check if user has Edit Client permissions
				if (in_array("16", $user_perms)) {
					$csearch_html .= "<a href=\"main.php?pg=editclient&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'company' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a>";
				}
				// check if user has Delete Client permissions
				if (in_array("17", $user_perms)) {
					$csearch_html .= "<a href=\"main.php?pg=delclient&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'company' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
			$csearch_html .= "</td>\n";
            $csearch_html .= "</tr>\n";
		}
		$csearch_html .= "</table>\n";
	}
	
	return $csearch_html;
}

// USER SEARCH
function user_search($search) {
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_userinfo.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$usearch_html = '';
	
	$SQL = " SELECT name, client_id, username, email, type, id, last_login FROM ttcm_user WHERE name LIKE '%" . $search . "%' OR username LIKE '%" . $search . "%' ORDER BY " . $_SESSION['usearch_oby'] . " " . $_SESSION['usearch_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	if ( $number == '0' ) {
		$usearch_html .= "<h1>" . $SEARCH_NOUSERS . "</h1>\n";
		$usearch_html .= "<p>" . $SEARCH_TRYAGAIN . "</p>\n";
	} 
	else {
        $usearch_html .= "<h2>" . $ALLUSERS_USERLIST . "</h2>\n";
        $usearch_html .= "<table class=\"table\">\n";
        $usearch_html .= "<tr class=\"title\">\n";
        $usearch_html .= "<td class=\"left\">" . $COL_USER . " <a href=\"main.php?pg=" . $_GET['pg'] . "search=" . $search . "&for=user&usearch_oby=name&amp;usearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "search=" . $search . "&for=user&usearch_oby=name&amp;usearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$usearch_html .= "<td class=\"left\">" . $COL_CLIENT . "</td>\n";
        $usearch_html .= "<td class=\"left\">" . $COL_UNEMAIL . " <a href=\"main.php?pg=" . $_GET['pg'] . "search=" . $search . "&for=user&usearch_oby=username&amp;usearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;search=" . $search . "&for=user&usearch_oby=username&amp;usearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$usearch_html .= "<td class=\"left\">" . $COL_LASTLOGIN . " <a href=\"main.php?pg=" . $_GET['pg'] . "search=" . $search . "&for=user&usearch_oby=last_login&amp;usearch_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "search=" . $search . "&for=user&usearch_oby=last_login&amp;usearch_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
        $usearch_html .= "<td>" . $COL_MODIFY . "</td>\n";
        $usearch_html .= "</tr>";

        while ( $row = $db_f($retid) ) {
		$last_login = $row[ 'last_login' ];
			
			$SQL2 = " SELECT DATE_FORMAT('$last_login','$_SESSION[date_format] as %l:%i %p') AS last_login2 FROM ttcm_user WHERE id = '" . $row[ 'id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$SQL2 = " SELECT * FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$usearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$usearch_html .= "<td class=\"left\"><strong>" . $row[ 'name' ] . "</strong></td>\n";
			$usearch_html .= "<td class=\"left\"><a href=\"main.php?pg=client&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row2[ 'company' ]) . "\">" . stripslashes($row2[ 'company' ]) . "</a></td>\n";
         	$usearch_html .= "<td class=\"left\"><a href=\"mailto:" . $row[ 'email' ] . "\" title=\"E-Mail " . stripslashes($row[ 'name' ]) . "\">" . $row[ 'username' ] . "</a></td>\n";
			$usearch_html .= "<td class=\"left\">" . $row2[ "last_login2" ] . "</td>\n";
         	$usearch_html .= "<td>\n";

			// check if user has User permissions
			if (in_array("27", $user_perms)) {
				$usearch_html .= "<a href=\"main.php?pg=edituser&amp;uid=" . $row[ 'id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("28", $user_perms)) {
				$usearch_html .= "<a href=\"main.php?pg=deluser&amp;uid=" . $row[ 'id' ] . "\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>\n";
			}
			$usearch_html .= "</td>\n";
			$usearch_html .= "</tr>\n";
		}
		$usearch_html .= "</table>\n";
	}
	
	return $usearch_html;
}

// GET CLIENT NOTES
function client_notes($clid, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$cnotes = "<h2>" . $ADDNOTE_CLIENTNOTES;
	// check if user has Note permissions
	if (in_array("19", $user_perms)) {
		$cnotes .= " <a href=\"main.php?pg=addnotes&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" title=\"Adicionar Anotação\">[ " . $COMMON_ADD . " ]</a>";
	}
	$cnotes .= "</h2>";
	$cnotes .= "<table class=\"table\">\n";

   	if ( ( $pid != '' ) && ( $pid != '0' ) ) {
   		$SQL = "SELECT note, note_id FROM ttcm_notes WHERE client_id = '" . $clid . "' AND project_id = '" . $pid . "'";
   	}
   	else {
		$SQL = "SELECT note, note_id FROM ttcm_notes WHERE client_id = '" . $clid . "' AND project_id = '0'";
	}      
	$retid2 = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid2 );
	
	if ($number == '0') {
		$cnotes .= "<tr>\n";
		$cnotes .= "<td class=\"left\">" . $ADDNOTE_NONOTES . "</td>\n";
		$cnotes .= "</tr>\n";
	}
	else {
	
		while ( $row2 = $db_f($retid2) ) {
		$note = stripslashes($row2[ 'note' ]);
		$notes = nl2br($note);
		
		$cnotes .= "<tr>\n";
		$cnotes .= "<td class=\"left\"><p>";
		// check if user has Note permissions
		if (in_array("20", $user_perms)) {
			$cnotes .= "<a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;nid=" . $row2[ "note_id" ] . "&amp;task=delnote\" title=\"Excluir Anotação\"><img src=\"../images/delete.gif\" border=\"0\"></a> ";
		}
		$cnotes .= $notes . "</p></td>\n";
		$cnotes .= "</tr>\n";
		}
	}
	$cnotes .= "</table>\n";
	
	return $cnotes;
}

// FILES FOR CLIENT
function client_files($clid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$cfiles = "<h2>" . $CLIENTS_FILES;
	// check if user has File permissions
	if (in_array("22", $user_perms)) {
		$cfiles .= " <a href=\"main.php?pg=addfiles&amp;clid=" . $clid . "\" title=\"Adicionar Documento\">[ " . $COMMON_ADD . " ]</a>";
	}
   	$cfiles .= "</h2><table class=\"table\">\n";
   	$cfiles .= "<tr class=\"title\">\n";
   	$cfiles .= "<td class=\"left\">" . $COL_FILETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=name&amp;cfiles_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=name&amp;cfiles_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$cfiles .= "<td class=\"left\">" . $COL_PROJECTS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=project_id&amp;cfiles_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=project_id&amp;cfiles_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$cfiles .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=added&amp;cfiles_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;cfiles_oby=added&amp;cfiles_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$cfiles .= "<td>" . $COL_MODIFY . "</td>\n";
   	$cfiles .= "</tr>\n";
   
	$SQL = " SELECT file_id, project_id, file, name, link, added FROM ttcm_files WHERE client_id = '" . $clid . "' ORDER BY " . $_SESSION['cfiles_oby'] . " " . $_SESSION['cfiles_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$cfiles .= "<tr>\n";
		$cfiles .= "<td class=\"left\" colspan=\"4\">" . $ALLTYPE_NOFILES . "</td>\n";
		$cfiles .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$added = $row[ 'added' ];
			$project_id = $row[ 'project_id' ];
			$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
			
			if ($project_id != '0') {
				
				$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
				$retid4 = $db_q($db, $query4, $cid);
				$row4 = $db_f($retid4);
				$file_perms = $row4['permissions'];
				
				$user_id = $_SESSION['valid_id'];
				$file_vars = split(',', $file_perms);
			
				if (in_array($user_id, $file_vars)) {
			
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT title FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "' ";
				$retid3 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid3);

				$cfiles .= "<tr bgcolor=\"" . $_SESSION['outcolor'] . "\" onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         		$cfiles .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\" title=\"Ver " . stripslashes($row[ 'name' ]) . "\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
         		$cfiles .= "<td class=\"left\">" . stripslashes($row3[ 'title' ]) . "</td>\n";
         		$cfiles .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         		$cfiles .= "<td>";
				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$cfiles .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has File permissions
				if (in_array("24", $user_perms)) {
					$cfiles .= "<a href=\"main.php?pg=client&amp;clid=" . $clid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$cfiles .= "</td>\n";
         		$cfiles .= "</tr>\n";
				}
			}
			else {
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT title FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "' ";
				$retid3 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid3);

				$cfiles .= "<tr bgcolor=\"" . $_SESSION['outcolor'] . "\" onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         		$cfiles .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\" title=\"Ver " . stripslashes($row[ 'name' ]) . "\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
         		$cfiles .= "<td class=\"left\">" . stripslashes($row3[ 'title' ]) . "</td>\n";
         		$cfiles .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         		$cfiles .= "<td>";
				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$cfiles .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has File permissions
				if (in_array("24", $user_perms)) {
					$cfiles .= "<a href=\"main.php?pg=client&amp;clid=" . $clid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$cfiles .= "</td>\n";
         		$cfiles .= "</tr>\n";
			}
		}
	}

   $cfiles .= "</table>\n";
	
	return $cfiles;
}

// GET ACTIVE PROJECTS
function active_projects($clid) {

	global $vid, $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$active_html = "<h2>" . $PROJECTS_ACTIVE;
	// check if user has Project permissions
	if (in_array("2", $user_perms)) {
		$active_html .= " <a href=\"main.php?pg=addproj&amp;clid=" . $clid . "\" title=\"Adicionar Processo\">[ " . $COMMON_ADD . " ]</a>";
	}
	$active_html .= " <a href=\"main.php?pg=allproj&amp;clid=" . $clid . "\" title=\"Ver todos os Processos\">[ " . $COMMON_VIEWALL . " ]</a></h2>";
   	$active_html .= "<table class=\"table\">\n";
   	$active_html .= "<tr class=\"title\">\n";
   	$active_html .= "<td class=\"left\">" . $COL_PROJECTS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=title&amp;aproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=title&amp;aproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> / " . $COL_CLIENT . "</td>\n";
   	$active_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=milestone&amp;aproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=milestone&amp;aproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$active_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=status&amp;aproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=status&amp;aproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$active_html .= "<td>" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=updated&amp;aproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;aproj_oby=updated&amp;aproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$active_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$active_html .= "</tr>\n";

	// IF CLIENT IS SET
	if ( isset( $clid ) && ( $clid != 0 ) )
	{
		$add_where .= " AND client_id = " . $clid;
	}
						
	$SQL = " SELECT project_id, client_id, title, milestone, updated, finish, status FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') ) AND finish = '0000-00-00' " . $add_where . " ORDER BY " . $_SESSION['aproj_oby'] . " " . $_SESSION['aproj_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ($number == 0)
	{
		$active_html .= "<tr>\n";
      	$active_html .= "<td class=\"left\" colspan=\"5\">" . $PROJECTS_NOPROJ . "</td>\n";
      	$active_html .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$milestone = $row[ "data limite" ];
			$updated = $row[ "updated" ];
			$finish = $row[ "finish" ];
			
			$SQL2 = " SELECT DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS updated2, DATE_FORMAT('$finish','$_SESSION[date_format] as %l:%i %p') AS finish2, DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestone2 FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$query = " SELECT * FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "' ";
			$retid3 = $db_q($db, $query, $cid);
			$row3 = $db_f($retid3);

			$active_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$active_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Ver " . stripslashes($row[ 'title' ]) . "\">" . stripslashes($row[ 'title' ]) . "</a>\n";
			$active_html .= "<br /><em>" . stripslashes($row3[ 'company' ]) . "</em></td>\n";
			
			if ( $finish == '0000-00-00' ) {
				$today = date("Ymd");
				
				$first_year = substr($today,0,4);
				$first_month = substr($today,4,2);
				$first_day = substr($today,6,2);
				
				$second_year = substr($milestone,0,4);
				$second_month = substr($milestone,5,2);
				$second_day = substr($milestone,8,2);
				
				$first_unix = mktime(00,00,00,$first_month,$first_day,$first_year);
				$second_unix = mktime(00,00,00,$second_month,$second_day,$second_year);

				$timediff = $second_unix - $first_unix;  
				
				if ( $timediff < '0' ) {
					$active_html .= "<td class=\"pastdue\">" . $row2[ 'milestone2' ] . "</td>\n";
				}
				else { 
					$active_html .= "<td>" . $row2[ 'milestone2' ] . "</td>\n";
				}
			}
			
			else {
				$active_html .= "<td>" . $row2[ 'milestone2' ] . "</td>\n";
			}
			
			$active_html .= "<td>" . $row[ 'status' ] . "</td>\n";
			$active_html .= "<td>" . $row2[ 'updated2' ] . "</td>\n";
			$active_html .= "<td>";
			// check if user has Project permissions
			if (in_array("3", $user_perms)) {
				$active_html .= "<a href=\"main.php?pg=editproj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\" alt=\"" . $COMMON_EDIT . "\"></a> ";
			}
			// check if user has Project permissions
			if (in_array("4", $user_perms)) {
				$active_html .= "<a href=\"main.php?pg=delproj&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"" . $COMMON_DELETE . "\"></a>";
			}
			$active_html .= "</td>\n";
         	$active_html .= "</tr>\n";
		}
	}
	$active_html .= "</table>\n";
	
	return $active_html;
}

// GET PAST DUE PROJECTS
function pastdue_projects() {

	global $vid, $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$due_html = "<h2>" . $PROJECTS_PASTDUE . "</h2>\n";
   	$due_html .= "<table class=\"table\">\n";
   	$due_html .= "<tr class=\"title\">\n";
   	$due_html .= "<td class=\"left\">" . $COL_PROJTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=title&amp;pdproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=title&amp;pdproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$due_html .= "<td class=\"left\">" . $COL_CLIENT . "</td>\n";
   	$due_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=milestone&amp;pdproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=milestone&amp;pdproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$due_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=status&amp;pdproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pdproj_oby=status&amp;pdproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$due_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$due_html .= "</tr>\n";
   
	$today = date("Y-m-d");
                    
   	$SQL = " SELECT project_id, client_id, title, milestone, updated, status FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') ) AND finish = '0000-00-00' AND milestone < '" . $today . "' ORDER BY " . $_SESSION['pdproj_oby'] . " " . $_SESSION['pdproj_lby'];
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == '0') {
	
		$due_html .= "<tr>\n";
      	$due_html .= "<td colspan=\"5\">" . $PROJECTS_NOPROJ . "</td>\n";
      	$due_html .= "</tr>\n";
	}
	else {
		
		while ( $row = $db_f($retid) ) {
			$milestone = $row[ 'milestone' ];
			
			$SQL3 = " SELECT company FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			
			$SQL2 = " SELECT DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestone2 FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$due_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$due_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Ver " . stripslashes($row[ 'title' ]) . "\">" . stripslashes($row[ 'title' ]) . "</a></td>\n";
         	$due_html .= "<td class=\"left\">" . stripslashes($row3[ 'company' ]) . "</td>\n";
         	$due_html .= "<td>";
			
			if ( $milestone == '0000-00-00' ) {
				$due_html .= "NA";
			} 
			else { 
				$due_html .= "<span class=\"pastdue\"><strong>" . $row2[ 'milestone2' ] . "</strong></span>";
			}
			
			$due_html .= "</td>\n";
         	$due_html .= "<td>" . $row[ 'status' ] . "</td>\n";
			$due_html .= "<td>";
			// check if user has Project permissions
			if (in_array("3", $user_perms)) {
				$due_html .= "<a href=\"main.php?pg=editproj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\" alt=\"" . $COMMON_EDIT . "\"></a> ";
			}
			// check if user has Project permissions
			if (in_array("4", $user_perms)) {
				$due_html .= "<a href=\"main.php?pg=delproj&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"" . $COMMON_DELETE . "\"></a>";
			}
			$due_html .= "</td>\n";
         	$due_html .= "</tr>\n";
		}
	}

   $due_html .= "</table>\n";

	return $due_html;
}

// GET LAST 10 PROJECTS
function ten_projects($clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$ten_html = "<h2>" . $PROJECTS_LAST10;
	if ( $clid != '' ) {
		$ten_html .= " <a href=\"main.php?pg=allproj&amp;clid=" . $clid . "\" title=\"Ver todos os Processos\">[ " . $COMMON_VIEWALL . " ]</a>\n";
	}
	else {
		$ten_html .= " <a href=\"main.php?pg=allproj\" title=\"Ver todos os Processos\">[ " . $COMMON_VIEWALL . " ]</a>\n";
	}
	$ten_html .= "</h2><table class=\"table\">";
   	$ten_html .= "<tr class=\"title\">\n";
   	$ten_html .= "<td class=\"left\">" . $COL_PROJECTS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=title&amp;tenproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=title&amp;tenproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> / " . $COL_CLIENT . "</td>\n";
   	$ten_html .= "<td>" . $COL_STARTDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=start&amp;tenproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=start&amp;tenproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$ten_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=status&amp;tenproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=status&amp;tenproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$ten_html .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=finish&amp;tenproj_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tenproj_oby=finish&amp;tenproj_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$ten_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$ten_html .= "</tr>\n";
   
	// IF CLIENT IS SET
	if ( isset( $clid ) && ( $clid != 0 ) )
	{
		$add_where .= " AND client_id = " . $clid;
	}
	
	$SQL = " SELECT project_id, client_id, title, start, updated, finish, status FROM ttcm_project WHERE ( (permissions = '" . $_SESSION['valid_id'] . "') OR (permissions LIKE '%," . $_SESSION['valid_id'] . "%') OR (permissions LIKE '%" . $_SESSION['valid_id'] . ",%') OR (permissions LIKE '%," . $_SESSION['valid_id'] . ",%') ) AND finish != '0000-00-00' " . $add_where . " ORDER BY " . $_SESSION['tenproj_oby'] . " " . $_SESSION['tenproj_lby'] . " LIMIT 10";
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$ten_html .= "<tr>\n";
      	$ten_html .= "<td class=\"left\" colspan=\"5\">" . $PROJECTS_NOPROJ . "</td>\n";
      	$ten_html .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$start = $row[ "start" ];
			$finish = $row[ "finish" ];
			
			$SQL2 = "SELECT DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_project WHERE project_id = '" . $row[ 'project_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$query = "SELECT company FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
			$retid3 = $db_q($db, $query, $cid);
			$row3 = $db_f($retid3);

			$ten_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$ten_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Ver " . stripslashes($row[ 'title' ]) . "\">" . stripslashes($row[ 'title' ]) . "</a>\n";
			$ten_html .= "<br /><em>" . stripslashes($row3[ 'company' ]) . "</em></td>\n";
         	$ten_html .= "<td>" . $row2[ 'start2' ] . "</td>\n";
         	$ten_html .= "<td>" . $row[ 'status' ] . "</td>\n";
         	$ten_html .= "<td>" . $row2[ 'finish2' ] . "</td>\n";
			$ten_html .= "<td>";
			// check if user has Project permissions
			if (in_array("3", $user_perms)) {
				$ten_html .= "<a href=\"main.php?pg=editproj&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has Project permissions
			if (in_array("4", $user_perms)) {
				$ten_html .= "<a href=\"main.php?pg=delproj&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$ten_html .= "</td>\n";
         	$ten_html .= "</tr>\n";
		}
	}

	$ten_html .= "</table>\n";

	return $ten_html;
}

// GET MAIN PROJECT DETAILS
function project_main($pid, $clid, $client_company) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$SQL = " SELECT title, description FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	
	$row = $db_f($retid);
	$description = stripslashes($row[ 'description' ]);
	$description_html = nl2br($description);
			
	$project_html = "<h1>" . stripslashes($row[ 'title' ]);
   	$project_html .= " (<a href=\"main.php?pg=client&amp;clid=" . $clid . "\" title=\"Ver " . stripslashes($client_company) . "\">" . stripslashes($client_company) . "</a>)\n";
	// check if user has Project permissions
	if (in_array("3", $user_perms)) {
		$project_html .= " <a href=\"main.php?pg=editproj&amp;pid=" . $pid . "&amp;clid=" . $clid . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a>\n";
	}
    $project_html .= "</h1>\n";       
   	$project_html .= "<p>" . $description_html . "</p>";

	return $project_html;
}

// GET PROJECT TASKS
function tasks_main($pid, $clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$tasks_html = "<h2>" . $TASKS_TASKS;;
	// check if user has Tasks permissions
	if (in_array("69", $user_perms)) {
		$tasks_html .= " <a href=\"main.php?pg=addtask&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "\" title=\"Adicionar Tarefa\">[ " . $COMMON_ADD . " ]</a> ";
	}
	$tasks_html .= "<a href=\"main.php?pg=alltasks\" title=\"Ver todos os Processos\">[ " . $TASKS_VIEWOTHER . " ]</a></h2>\n";
   	$tasks_html .= "<table class=\"table\">\n";
   	$tasks_html .= "<tr class=\"title\">\n";
   	$tasks_html .= "<td class=\"left\">" . $COL_TASKTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=title&amp;tasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=title&amp;tasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=status&amp;tasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=status&amp;tasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=milestone&amp;tasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=milestone&amp;tasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=finish&amp;tasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=finish&amp;tasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$tasks_html .= "<td>" . $COL_ASSIGNED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=assigned&amp;tasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=assigned&amp;tasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$tasks_html .= "</tr>\n";
				
	$SQL = " SELECT task_id, title, finish, status, assigned, milestone FROM ttcm_task WHERE project_id = '" . $pid . "' ORDER BY " . $_SESSION['tasks_oby'] . " " . $_SESSION['tasks_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$tasks_html .= "<tr>\n";
      	$tasks_html .= "<td class=\"left\" colspan=\"6\">" . $TASKS_NOTASKS . "</td>\n";
      	$tasks_html .= "</tr>\n";
	} 
	else {
    
		while ( $row = $db_f($retid) ) {
			$task_finish = $row[ "finish" ];
			$task_milestone = $row[ "data limite" ];
			
			$SQL3 = " SELECT name FROM ttcm_user WHERE id = '" . $row[ 'assigned' ] . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			
			$SQL2 = " SELECT DATE_FORMAT('$task_finish','$_SESSION[date_format]') AS task_finish2, DATE_FORMAT('$task_milestone','$_SESSION[date_format]') AS task_milestone2 FROM ttcm_task WHERE task_id = '" . $row[ 'task_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$tasks_html .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "\" METHOD=\"POST\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"vari\" value=\"" . $row[ 'task_id' ] . "\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"task\" value=\"projtask\">\n";
			$tasks_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$tasks_html .= "<td class=\"left\">" . stripslashes($row[ 'title' ]) . "</td>\n";
         	$tasks_html .= "<td>" . $row[ 'status' ] . "</td>\n";
         	$tasks_html .= "<td>" . $row2[ 'task_milestone2' ] . "</td>\n";
         	$tasks_html .= "<td>";
			
			if ($task_finish == '0000-00-00') {
				$tasks_html .= "<input type=\"submit\" class=\"body\" value=\"" . $COMMON_DONE . "\">";
			} 
			else {
				$tasks_html .= $row2[ 'task_finish2' ];
			}
			$tasks_html .= "</td>\n";
			$tasks_html .= "<td>";
			if ( $row[ 'assigned' ] == '0' ) {
				$tasks_html .= $COMMON_NOBODY;
			} 
			else {
				$tasks_html .= $row3[ 'name' ];
			}
			$tasks_html .= "</td>\n";
			$tasks_html .= "<td>";
			// check if user has Task permissions
			if (in_array("51", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=edittask&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tid=" . $row[ 'task_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has Task permissions
			if (in_array("52", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=proj&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;tid=" . $row[ 'task_id' ] . "&amp;task=deltask\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$tasks_html .= "</td>\n";
         	$tasks_html .= "</tr>\n";
         	$tasks_html .= "</FORM>\n";
		}
	} 
	$tasks_html .= "</table>\n";
	
	return $tasks_html;
}

// GET ACTIVE TASKS
function active_tasks($clid, $tuid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$tasks_html = "<h2>" . $TASKS_ACTIVE;
	// check if user has Task permissions
	if (in_array("50", $user_perms)) {
		$tasks_html .= " <a href=\"main.php?pg=addtask&amp;clid=" . $clid . "\" title=\"Adicionar Tarefa\">[ " . $COMMON_ADD . " ]</a>";
	}
	$tasks_html .= "</h2>";
   	$tasks_html .= "<table class=\"table\">\n";
   	$tasks_html .= "<tr class=\"title\">\n";
   	$tasks_html .= "<td class=\"left\">" . $COL_TASKTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=title&amp;atasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=title&amp;atasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=status&amp;atasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=status&amp;atasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=milestone&amp;atasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=milestone&amp;atasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=finish&amp;atasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;atasks_oby=finish&amp;atasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$tasks_html .= "</tr>\n";
	
	if ($clid != '') {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, status, milestone FROM ttcm_task WHERE client_id = '" . $clid . "' AND finish = '0000-00-00' ORDER BY " . $_SESSION['atasks_oby'] . " " . $_SESSION['atasks_lby'];
		$retid = $db_q($db, $SQL, $cid);
	}
	else if ($tuid != '') {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, status, milestone FROM ttcm_task WHERE assigned = '" . $tuid . "' AND finish = '0000-00-00' ORDER BY " . $_SESSION['atasks_oby'] . " " . $_SESSION['atasks_lby'];
		$retid = $db_q($db, $SQL, $cid);
	}
	else {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, status, milestone FROM ttcm_task WHERE finish = '0000-00-00' ORDER BY " . $_SESSION['atasks_oby'] . " " . $_SESSION['atasks_lby'];
		$retid = $db_q($db, $SQL, $cid);
	}

	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$tasks_html .= "<tr>\n";
      	$tasks_html .= "<td class=\"left\" colspan=\"5\">" . $TASKS_NOTASKS . "</td>\n";
      	$tasks_html .= "</tr>\n";
	} 
	else {
    
		while ( $row = $db_f($retid) ) {
			$task_finish = $row[ "finish" ];
			$task_milestone = $row[ "data limite" ];
			
			$SQL2 = " SELECT DATE_FORMAT('$task_finish','$_SESSION[date_format]') AS task_finish2, DATE_FORMAT('$task_milestone','$_SESSION[date_format]') AS task_milestone2 FROM ttcm_task WHERE task_id = '" . $row[ 'task_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$tasks_html .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=tasks&amp;clid=" . $row[ 'client_id' ] . "\" METHOD=\"POST\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"vari\" value=\"" . $row[ 'task_id' ] . "\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"task\" value=\"projtask\">\n";
			$tasks_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$tasks_html .= "<td class=\"left\">" . stripslashes($row[ 'title' ]) . "</td>\n";
         	$tasks_html .= "<td>" . $row[ 'status' ] . "</td>\n";
         	$tasks_html .= "<td>" . $row2[ 'task_milestone2' ] . "</td>\n";
         	$tasks_html .= "<td>";
			
			if ($task_finish == '0000-00-00') {
				$tasks_html .= "<input type=\"submit\" class=\"body\" value=\"" . $COMMON_DONE . "\">";
			} 
			else {
				$tasks_html .= $row2[ 'task_finish2' ];
			}
			$tasks_html .= "</td>\n";
			$tasks_html .= "<td>";
			// check if user has Task permissions
			if (in_array("51", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=edittask&amp;pid=" . $row[ 'project_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "&amp;tid=" . $row[ 'task_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has Task permissions
			if (in_array("52", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=tasks&amp;tid=" . $row[ 'task_id' ] . "&amp;task=deltask\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$tasks_html .= "</td>\n";
         	$tasks_html .= "</tr>\n";
         	$tasks_html .= "</FORM>\n";
		}
	} 
	$tasks_html .= "</table>\n";
	
	return $tasks_html;
}

// GET PAST PROJECT TASKS
function tasks_all($clid, $tuid, $lim) {

	global $cid, $db_q, $db_c, $db_f, $db;
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$tasks_html = "<h2>" . $TASKS_PAST . " <a href=\"main.php?pg=alltasks\" title=\"Ver todas as Tarefas\">[ " . $COMMON_VIEWALL . " ]</a></h2>\n";
   	$tasks_html .= "<table class=\"table\">\n";
   	$tasks_html .= "<tr class=\"title\">\n";
   	$tasks_html .= "<td class=\"left\">" . $COL_TASKTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=title&amp;alltasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=title&amp;alltasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=status&amp;alltasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=status&amp;alltasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=milestone&amp;alltasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=milestone&amp;alltasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_FINISHDATE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=finish&amp;alltasks_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;alltasks_oby=finish&amp;alltasks_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$tasks_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$tasks_html .= "</tr>\n";

	
	if ($_POST['clid'] != '') {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, milestone, status FROM ttcm_task WHERE client_id = '" . $_POST['clid'] . "' ORDER BY " . $_SESSION['alltasks_oby'] . " " . $_SESSION['alltasks_lby'] . " LIMIT " . $lim;
		$retid = $db_q($db, $SQL, $cid);
	}
	else if ($_POST['tuid'] != '') {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, milestone, status FROM ttcm_task WHERE assigned = '" . $_POST['tuid'] . "' ORDER BY " . $_SESSION['alltasks_oby'] . " " . $_SESSION['alltasks_lby'] . " LIMIT " . $lim;
		$retid = $db_q($db, $SQL, $cid);
	}
	else {
		$SQL = " SELECT task_id, client_id, project_id, title, finish, milestone, status FROM ttcm_task ORDER BY " . $_SESSION['alltasks_oby'] . " " . $_SESSION['alltasks_lby'] . " LIMIT " . $lim;
		$retid = $db_q($db, $SQL, $cid);
	}

	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$tasks_html .= "<tr>\n";
      	$tasks_html .= "<td class=\"left\" colspan=\"5\">" . $TASKS_NOTASKS . "</td>\n";
      	$tasks_html .= "</tr>\n";
	} 
	else {
    
		while ( $row = $db_f($retid) ) {
			$task_finish = $row[ "finish" ];
			$task_milestone = $row[ "data limite" ];
			
			$SQL2 = " SELECT DATE_FORMAT('$task_finish','$_SESSION[date_format]') AS task_finish2, DATE_FORMAT('$task_milestone','$_SESSION[date_format]') AS task_milestone2 FROM ttcm_task WHERE task_id = '" . $row[ 'task_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$tasks_html .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=tasks&amp;clid=" . $row[ 'client_id' ] . "\" METHOD=\"POST\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"vari\" value=\"" . $row[ 'task_id' ] . "\">\n";
			$tasks_html .= "<input type=\"hidden\" name=\"task\" value=\"projtask\">\n";
			$tasks_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$tasks_html .= "<td class=\"left\">" . stripslashes($row[ 'title' ]) . "</td>\n";
         	$tasks_html .= "<td>" . $row[ 'status' ] . "</td>\n";
         	$tasks_html .= "<td>" . $row2[ 'task_milestone2' ] . "</td>\n";
         	$tasks_html .= "<td>";
			
			if ($task_finish == '0000-00-00') {
				$tasks_html .= "<input type=\"submit\" class=\"body\" value=\"" . $COMMON_DONE . "\">";
			} 
			else {
				$tasks_html .= $row2[ 'task_finish2' ];
			}
			$tasks_html .= "</td>\n";
			$tasks_html .= "<td>";
			// check if user has Task permissions
			if (in_array("51", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=edittask&amp;clid=" . $row[ 'client_id' ] . "&amp;tid=" . $row[ 'task_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Editar " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("52", $user_perms)) {
				$tasks_html .= "<a href=\"main.php?pg=" . $_GET['pg'] . "&amp;tid=" . $row[ 'task_id' ] . "&amp;task=deltask\" title=\"Excluir " . stripslashes($row[ 'title' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$tasks_html .= "</td>\n";
         	$tasks_html .= "</tr>\n";
         	$tasks_html .= "</FORM>\n";
		}
	} 
	$tasks_html .= "</table>\n";
	
	return $tasks_html;
}

// GET PROJECT FILES
function files_main($pid, $clid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$files_html = "<h2>" . $FILES_PROJECTFILES;
	// check if user has File permissions
	if (in_array("22", $user_perms)) {
		$files_html .= " <a href=\"main.php?pg=addfiles&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "\" title=\"Adicionar Documento\">[ " . $COMMON_ADD . " ]</a>";
	}
	$files_html .= "</h2>\n";
   	$files_html .= "<table class=\"table\">\n";
   	$files_html .= "<tr class=\"title\">\n";
   	$files_html .= "<td class=\"left\">" . $COL_FILETITLE . " / " . $COL_VIEW . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=name&amp;files_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=name&amp;files_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td class=\"left\">" . $COL_FILETYPE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=type_id&amp;files_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=type_id&amp;files_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td>" . $COL_PROJECTS . "</td>\n";
   	$files_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=added&amp;files_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=added&amp;files_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$files_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$files_html .= "</tr>\n";
            
   	$SQL = " SELECT file_id, type_id, name, link, added FROM ttcm_files WHERE project_id = '" . $_GET['pid'] . "' ORDER BY " . $_SESSION['files_oby'] . " " . $_SESSION['files_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$files_html .= "<tr>\n";
      	$files_html .= "<td class=\"left\" colspan=\"5\">" . $PROJECTS_NOPROJ . "</td>\n";
      	$files_html .= "</tr>\n";
   }
	else {
		while ( $row = $db_f($retid) ) {
		$added = $row[ "added" ];
		$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
			
			$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "'";
			$retid4 = $db_q($db, $query4, $cid);
			$row4 = $db_f($retid4);
			$file_perms = $row4['permissions'];
			
			$user_id = $_SESSION['valid_id'];
			$file_vars = split(',', $file_perms);
			
			if (in_array($user_id, $file_vars)) {
			
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$SQL3 = " SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $row[ 'type_id' ] . "' ";
				$retid3 = $db_q($db, $SQL3, $cid);
				$row3 = $db_f($retid3);
			
				$SQL4 = " SELECT title FROM ttcm_project WHERE project_id = '" . $_GET[ 'pid' ] . "' ";
				$retid4 = $db_q($db, $SQL4, $cid);
				$row4 = $db_f($retid4);

				$files_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
      			$files_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
      			$files_html .= "<td class=\"left\">" . stripslashes($row3[ 'file_type' ]) . "</td>\n";
      			$files_html .= "<td>" . stripslashes($row4[ 'title' ]) . "</td>\n";
      			$files_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
				$files_html .= "<td>";
				// check if user has File permissions
				if (in_array("23", $user_perms)) {
					$files_html .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
				}
				// check if user has File permissions
				if (in_array("24", $user_perms)) {
					$files_html .= "<a href=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
				}
				$files_html .= "</td>\n";
      			$files_html .= "</tr>\n";
			}
		}
	}
	$files_html .= "</table>\n";
	
	return $files_html;
}

// GET CLIENT UPLOADED FILES
function cfiles_main($pid, $clid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$cfiles_html = "<h2>" . $CLIENT_UPLOADEDFILES . "</h2>\n";
   	$cfiles_html .= "<table class=\"table\">\n";
   	$cfiles_html .= "<tr class=\"title\">\n";
   	$cfiles_html .= "<td class=\"left\">" . $COL_FILETITLE . " / " . $COL_VIEW . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;cfiles_oby=name&amp;cfiles_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;cfiles_oby=name&amp;cfiles_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$cfiles_html .= "<td>" . $COL_PROJECTS . "</td>\n";
   	$cfiles_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;cfiles_oby=added&amp;cfiles_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;cfiles_oby=added&amp;cfiles_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$cfiles_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$cfiles_html .= "</tr>\n";
            
   	$SQL = " SELECT file_id, name, link, added FROM ttcm_cfiles WHERE client_id = '" . $clid . "' AND project_id = '" . $pid . "' ORDER BY " . $_SESSION['cfiles_oby'] . " " . $_SESSION['cfiles_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$cfiles_html .= "<tr>\n";
      	$cfiles_html .= "<td class=\"left\" colspan=\"4\">" . $CLIENT_NOULFILES . "</td>\n";
      	$cfiles_html .= "</tr>\n";
   }
	else {
		while ( $row = $db_f($retid) ) {
		$added = $row[ "added" ];
		$project_id = $pid;
		$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
		if ($project_id != '0') {
			
			$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
			$retid4 = $db_q($db, $query4, $cid);
			$row4 = $db_f($retid4);
			$file_perms = $row4['permissions'];
			
			$user_id = $_SESSION['valid_id'];
			$file_vars = split(',', $file_perms);
			
			if (in_array($user_id, $file_vars)) {
			
			$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_cfiles WHERE file_id = '" . $row[ 'file_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$SQL4 = " SELECT * FROM ttcm_project WHERE project_id = '" . $pid . "' ";
			$retid4 = $db_q($db, $SQL4, $cid);
			$row4 = $db_f($retid4);

			$cfiles_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
      		$cfiles_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
      		$cfiles_html .= "<td>" . stripslashes($row4[ 'title' ]) . "</td>\n";
      		$cfiles_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
			$cfiles_html .= "<td>";
			// check if user has Client File permissions
			if (in_array("40", $user_perms)) {
				$cfiles_html .= "<a href=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delcfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$cfiles_html .= "</td>\n";
      		$cfiles_html .= "</tr>\n";
			}
		}
		else {
			$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_cfiles WHERE file_id = '" . $row[ 'file_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$SQL4 = " SELECT * FROM ttcm_project WHERE project_id = '" . $pid . "' ";
			$retid4 = $db_q($db, $SQL4, $cid);
			$row4 = $db_f($retid4);

			$cfiles_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
      		$cfiles_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a></td>\n";
      		$cfiles_html .= "<td>" . stripslashes($row4[ 'title' ]) . "</td>\n";
      		$cfiles_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
			$cfiles_html .= "<td>";
			// check if user has Client File permissions
			if (in_array("40", $user_perms)) {
				$cfiles_html .= "<a href=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delcfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$cfiles_html .= "</td>\n";
      		$cfiles_html .= "</tr>\n";
		}
		}
	}
	$cfiles_html .= "</table>\n";
	
	return $cfiles_html;
}

// PROJECT DETAILS
function project_details($pid, $clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$pdetails = "<h3>" . $PROJECT_STATUS . " <a href=\"main.php?pg=status\" title=\"Editarar Opções de Status\">[ " . $COMMON_EDITOPTIONS . " ]</a></h3>\n";

	$SQL = " SELECT title, description, start, finish, status, updated, cost, milestone FROM ttcm_project WHERE project_id = '" . $pid . "' ";
   	$retid = $db_q($db, $SQL, $cid);
                      	
   	$row = $db_f($retid);
   	$start = $row[ "start" ];
   	$finish = $row[ "finish" ];
   	$updated = $row[ "updated" ];
   	$milestone = $row[ "data limite" ];
	$description = $row[ "description" ];
	$status = $row[ "status" ];
   	$description_html = nl2br($description);
                      			
   	$SQL2 = " SELECT DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestone2, DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS update2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_project WHERE project_id = '$pid'";
  	$retid2 = $db_q($db, $SQL2, $cid);
   	$row2 = $db_f($retid2);
   	$started2 = $row2[ "start2" ];
   	$finished2 = $row2[ "finish2" ];
   	$milestones2 = $row2[ "milestone2" ];
  	$updated2 = $row2[ "update2" ];

	$status_string = project_statusmenu("$status");

	$pdetails .= "<p><FORM NAME=\"done\" ACTION=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" METHOD=\"POST\">\n";
	$pdetails .= "<input type=\"hidden\" name=\"pid\" value=\"" . $pid . "\">\n";
	$pdetails .= "<input type=\"hidden\" name=\"task\" value=\"projstat\">\n";
	$pdetails .= "<select name=\"vari\" class=\"body\">" . $status_string . "</select> <INPUT TYPE=\"submit\" class=\"body\" VALUE=\"" . $COMMON_EDIT . "\">\n";
	$pdetails .= "</FORM></p>\n";
   	$pdetails .= "<h3>" . $COMMON_QUOTE . "</h3>\n";
   	$pdetails .= "<p>" . $row[ 'cost' ] . " " . $_SESSION['currency'] . "</p>\n";
   	$pdetails .= "<h3>" . $COMMON_STARTDATE . "</h3>\n";
   	$pdetails .= "<p>" . $row2[ 'start2' ] . "</p>\n";
   	$pdetails .= "<h3>" . $COMMON_LASTUPDATED . "</h3>\n";
   	$pdetails .= "<p>" . $row2[ 'update2' ] . "</p>\n";
   	$pdetails .= "<h3>" . $COMMON_MILESTONE . "</h3>\n";
   	$pdetails .= "<p>" . $row2[ 'milestone2' ] . "</p>\n";
   	$pdetails .= "<h3>" . $COMMON_FINISHDATE . "</h3>\n";
   	$pdetails .= "<p>";
	// check if user has Project permissions
		
   if ( $row[ "finish" ] == '0000-00-00' ) {
	
		if (in_array("3", $user_perms)) {
   			$pdetails .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" METHOD=\"POST\">\n";
			$pdetails .= "<input type=\"hidden\" name=\"pid\" value=\"" . $pid . "\">\n";
			$pdetails .= "<input type=\"hidden\" name=\"task\" value=\"projdone\">\n";
			$pdetails .= "<input type=\"submit\" class=\"body\" VALUE=\"" . $COMMON_DONE . "\">\n";
			$pdetails .= "</FORM>\n";
		}
		else {
			$pdetails .= "NA";
		}
	}
	else {
		
		if (in_array("3", $user_perms)) {
   			$pdetails .= "<FORM NAME=\"notdone\" ACTION=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" METHOD=\"POST\">\n";
			$pdetails .= "<input type=\"hidden\" name=\"pid\" value=\"" . $pid . "\">\n";
			$pdetails .= "<input type=\"hidden\" name=\"task\" value=\"projnotdone\">\n";
			$pdetails .= $row2[ 'finish2' ]; 
			$pdetails .= " <input type=\"submit\" class=\"body\" VALUE=\"" . $COMMON_NOTDONE . "\">\n";
			$pdetails .= "</FORM>\n";
		}
		else {
			$pdetails .= $row2[ 'finish2' ];
		}
	}
	$pdetails .= "</p>\n";

	return $pdetails;
}

// GET CLIENT MESSAGES
function get_messages($clid, $limit) {

	global $cid, $db_q, $db_c, $db_f, $db;

	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    	$message_html = "<h2>" . $ALLMESSAGES_PREVIOUS . " <a href=\"main.php?pg=allmsg\" title=\"Ver todas as Mensagens\">[ " . $COMMON_VIEWALL . " ]</a></h2>\n";
    	$message_html .= "<table class=\"table\">\n";
    	$message_html .= "<tr class=\"title\">\n";
    	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;messages_oby=message_title&amp;messages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;messages_oby=message_title&amp;messages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    	$message_html .= "<td class=\"left\">" . $COL_CLIENT . "</td>\n";
    	$message_html .= "<td>" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;messages_oby=updated&amp;messages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;messages_oby=updated&amp;messages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
		$message_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$message_html .= "</tr>\n";

		$add_where = '';
    
		if ( isset( $_POST['clid'] ) && ( $_POST['clid'] != 0 ) )
		{
			$add_where .= " WHERE client_id = " . $_POST['clid'];
		}
		
    	$SQL = "SELECT message_id, message_title, updated, client_id, project_id FROM ttcm_messages" . $add_where . " ORDER BY " . $_SESSION['messages_oby'] . " " . $_SESSION['messages_lby'] . " LIMIT " . $limit;
		$retid = $db_q($db, $SQL, $cid);
		$number = $db_c( $retid );
	
		if ($number == '0') {
			$message_html .= "<tr>\n";
      		$message_html .= "<td class=\"left\" colspan=\"5\">" . $MESSAGES_NOMESSAGE . "</td>\n";
    		$message_html .= "</tr>\n";
		}
		else {
	
		while ( $row = $db_f($retid) ) {
			$updated = $row[ "updated" ];
			
			$SQL4 = " SELECT * FROM ttcm_comments WHERE message_id = '" . $row[ 'message_id' ] . "'";
		  	$retid4 = $db_q($db, $SQL4, $cid);
		  	$repnum = $db_c( $retid4 );
			
			$SQL3 = " SELECT * FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			
			$SQL2 = " SELECT DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS updated2 FROM ttcm_messages WHERE message_id = '" . $row[ 'message_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$updated2 = $row2[ "updated2" ];
			
			if ($updated == "0000-00-00 00:00:00") {
				$updated2 = "NA";
			}

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "\">" . stripslashes($row[ 'message_title' ]) . "</a></td>\n";
         	$message_html .= "<td class=\"left\">" . stripslashes($row3[ 'company' ]) . "</td>\n";
         	$message_html .= "<td>" . $updated2 . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
			$message_html .= "<td>";
			// check if user has Message permissions
			if (in_array("12", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=editmsg&amp;mid=" . $row[ 'message_id' ] . "&amp;clid=" . $row[ 'client_id' ] . "&amp;pid=" . $row[ 'project_id' ] . "\" title=\"Editar Mensagem\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("13", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=msg&amp;mid=" . $row[ 'message_id' ] . "&amp;task=delmessage\" title=\"Excluir Mensagem\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$message_html .= "</td>\n";
         	$message_html .= "</tr>\n";
		}
		}
		
	$message_html .= "</table>\n";
	
	return $message_html;
}

// OBTER MODELOS DE E-MAILS
function show_templates() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    	$template_html = "<h2>Folha de Estilos para E-mail</h2>\n";
		$template_html .= "<table class=\"table\">\n";
    	$template_html .= "<tr class=\"title\">\n";
    	$template_html .= "<td class=\"left\">Folha de Estilos CSS</td>\n";
		$template_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$template_html .= "</tr>\n";
		
    	$SQL = " SELECT template_id, template FROM ttcm_templates WHERE type = '1' ORDER BY template ";
		$retid = $db_q($db, $SQL, $cid);
	
		while ( $row = $db_f($retid) ) {

			$template_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$template_html .= "<td class=\"left\">" . stripslashes($row[ 'template' ]) . "</td>\n";
			$template_html .= "<td>";
			// check if user has Setting permissions
			if (in_array("8", $user_perms)) {
				$template_html .= "<a href=\"main.php?pg=templates&tid=" . $row[ 'template_id' ] . "\" title=\"Editar Modelo\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			$template_html .= "</td>\n";
         	$template_html .= "</tr>\n";
			$template_html .= "</table>\n";
		}
		
		$template_html .= "<h2>Modelos de Mensagens para E-mail em HTML</h2>\n";
    	$template_html .= "<table class=\"table\">\n";
    	$template_html .= "<tr class=\"title\">\n";
    	$template_html .= "<td class=\"left\">Modelos de E-mail</td>\n";
		$template_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$template_html .= "</tr>\n";
		
    	$SQL = " SELECT template_id, template FROM ttcm_templates WHERE type = '0' ORDER BY template ";
		$retid = $db_q($db, $SQL, $cid);
	
		while ( $row = $db_f($retid) ) {

			$template_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$template_html .= "<td class=\"left\">" . stripslashes($row[ 'template' ]) . "</td>\n";
			$template_html .= "<td>";
			// check if user has Setting permissions
			if (in_array("8", $user_perms)) {
				$template_html .= "<a href=\"main.php?pg=templates&tid=" . $row[ 'template_id' ] . "\" title=\"Editar Modelo\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			$template_html .= "</td>\n";
         	$template_html .= "</tr>\n";
		}
		
	$template_html .= "</table>\n";
	
	return $template_html;
}

// GET PROJECT MESSAGES
function get_projmessages($clid, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    	$message_html = "<h2>" . $COMMON_MESSAGES . " <a href=\"main.php?pg=addmsg&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "\" title=\"Escrever Mensagem\">[ " . $COMMON_ADD . " ]</a></h2>\n";
    	$message_html .= "<table class=\"table\">\n";
    	$message_html .= "<tr class=\"title\">\n";
    	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;pmessages_oby=message_title&amp;pmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;pmessages_oby=message_title&amp;pmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    	$message_html .= "<td class=\"left\">" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;pmessages_oby=updated&amp;pmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;pmessages_oby=updated&amp;pmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
		$message_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$message_html .= "</tr>\n";
		
    	$SQL = " SELECT message_id, message_title, updated FROM ttcm_messages WHERE client_id = " . $_GET['clid'] . " AND project_id = " . $_GET['pid'] . " ORDER BY " . $_SESSION['pmessages_oby'] . " " . $_SESSION['pmessages_lby'];
		$retid = $db_q($db, $SQL, $cid);
	
		$number = $db_c( $retid );
	
		if ($number == '0') {
			$message_html .= "<tr>\n";
      		$message_html .= "<td class=\"left\" colspan=\"4\">" . $MESSAGES_NOMESSAGE . "</td>\n";
    		$message_html .= "</tr>\n";
		}
		else {
	
		while ( $row = $db_f($retid) ) {
			$updated = $row[ "updated" ];
			
			$SQL4 = " SELECT * FROM ttcm_comments WHERE message_id = '" . $row[ 'message_id' ] . "'";
		  	$retid4 = $db_q($db, $SQL4, $cid);
		  	$repnum = $db_c( $retid4 );
			
			$SQL2 = " SELECT DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS updated2 FROM ttcm_messages WHERE message_id = '" . $row[ 'message_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$updated2 = $row2[ "updated2" ];

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] . "\" title=\"Ler Mensagem\">" . stripslashes($row[ 'message_title' ]) . "</a></td>\n";
         	$message_html .= "<td class=\"left\">" . $row2[ 'updated2' ] . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
			$message_html .= "<td>";
			// check if user has Message permissions
			if (in_array("12", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=editmsg&amp;mid=" . $row[ 'message_id' ] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" title=\"Editar Mensagem\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("13", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=msg&amp;mid=" . $row[ 'message_id' ] . "&amp;task=delmessage\" title=\"Excluir Mensagem\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$message_html .= "</td>\n";
         	$message_html .= "</tr>\n";
		}
		}
		
	$message_html .= "</table>\n";
	
	return $message_html;
}

// GET PROJECT MESSAGES
function get_clmessages($clid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    	$message_html = "<h2>" . $COMMON_MESSAGES . " <a href=\"main.php?pg=addmsg&amp;clid=" . $_GET['clid'] . "\" title=\"Escrever Mensagem\">[ " . $COMMON_ADD . " ]</a> <a href=\"messages.php?clid=" . $clid . "\" title=\"Todas as Mensagens\">[ " . $COMMON_VIEWALL . " ]</a></h2>\n";
    	$message_html .= "<table class=\"table\">\n";
    	$message_html .= "<tr class=\"title\">\n";
    	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;clmessages_oby=message_title&amp;clmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;clmessages_oby=message_title&amp;clmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    	$message_html .= "<td class=\"left\">" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;clmessages_oby=updated&amp;clmessages_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;clmessages_oby=updated&amp;clmessages_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
		$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
		$message_html .= "<td>" . $COL_MODIFY . "</td>\n";
    	$message_html .= "</tr>\n";
		
    	$SQL = " SELECT message_id, message_title, updated FROM ttcm_messages WHERE client_id = '" . $clid . "' ORDER BY " . $_SESSION['clmessages_oby'] . " " . $_SESSION['clmessages_lby'] . " LIMIT 5";
		$retid = $db_q($db, $SQL, $cid);
	
		$number = $db_c( $retid );
	
		if ($number == '0') {
			$message_html .= "<tr>\n";
      		$message_html .= "<td class=\"left\" colspan=\"4\">" . $MESSAGES_NOMESSAGE . "</td>\n";
    		$message_html .= "</tr>\n";
		}
		else {
	
		while ( $row = $db_f($retid) ) {
			$updated = $row[ "updated" ];
			
			$SQL4 = " SELECT * FROM ttcm_comments WHERE message_id = '" . $row[ 'message_id' ] . "'";
		  	$retid4 = $db_q($db, $SQL4, $cid);
		  	$repnum = $db_c( $retid4 );
			
			$SQL2 = " SELECT DATE_FORMAT('$updated','$_SESSION[date_format] as %l:%i %p') AS updated2 FROM ttcm_messages WHERE message_id = '" . $row[ 'message_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         	$message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $row[ 'message_id' ] . "\" title=\"Ler Mensagem\">" . stripslashes($row[ 'message_title' ]) . "</a></td>\n";
         	$message_html .= "<td class=\"left\">" . $row2[ 'updated2' ] . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
			$message_html .= "<td>";
			// check if user has Message permissions
			if (in_array("12", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=editmsg&amp;mid=" . $row[ 'message_id' ] . "&amp;clid=" . $clid . "\" title=\"Editar Mensagem\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("13", $user_perms)) {
				$message_html .= "<a href=\"main.php?pg=msg&amp;mid=" . $row[ 'message_id' ] . "&amp;task=delmessage\" title=\"Excluir Mensagem\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
			}
			$message_html .= "</td>\n";
         	$message_html .= "</tr>\n";
		}
		}
		
	$message_html .= "</table>\n";
	
	return $message_html;
}
	
// READ MESSAGE
function view_message($client_id, $mid) {

	global $cid, $db_q, $db_c, $db_f, $db;
    
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    $SQL = " SELECT message_title, message, posted, post_by, replies FROM ttcm_messages WHERE message_id = '" . $_GET['mid'] . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$message_html .= " <br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\">   " . $MESSAGES_INVALID . "</div>\n";
	} 
	else {
	
	$message_html = '';
	
		$row = $db_f($retid);
		$posted = $row[ "posted" ];
		$message = stripslashes($row[ 'message' ]);
		$message_br = nl2br($message);
			
		$SQL2 = " SELECT DATE_FORMAT('$posted','%W, %M %D, %Y as %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $_GET['mid'] . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);

        $message_html .= "<p class=\"message-title\">" . stripslashes($row[ 'message_title' ]) . "</p>\n";
		$message_html .= "<p class=\"message-date\">" . $row2[ 'posted2' ] . "</p>\n";
		$message_html .= "<p class=\"message-by\"><em>" . $MESSAGES_POSTBY . " : " . stripslashes($row[ 'post_by' ]) . "</em></p>\n";
        $message_html .= "<p class=\"message-box\">" . $message_br . "</p>\n";
     	
		$SQL4 = " SELECT comment_id, comment, posted, post_by FROM ttcm_comments WHERE message_id = '" . $_GET['mid'] . "' ORDER BY posted ASC";
		$retid4 = $db_q($db, $SQL4, $cid);
		$number4 = $db_c( $retid4 );
		$shade = '0';
		
		  if ($number4 == 0) {
         	$message_html .= "<p class=\"message-date\">" . $MESSAGE_REPLIES . "</p>\n";
			$message_html .= "<p>" . $MESSAGE_NOREPLIES . "</p>";
		  } 
		  else {
		
		  while ( $row4 = $db_f($retid4) ) {
			$cposted = $row4[ "posted" ];
			$comment = stripslashes($row4[ 'comment' ]);
			$comment_br = nl2br($comment);
			
			$SQL5 = " SELECT DATE_FORMAT('$cposted','%W, %M %D, %Y as %l:%i %p') AS cposted2 FROM ttcm_comments WHERE message_id = '" . $_GET['mid'] . "'";
			$retid5 = $db_q($db, $SQL5, $cid);
			$row5 = $db_f($retid5);
			
			if ( $shade == '0' ) { 
				$mbox = "reply-box-shaded"; 
			}
			else { 
				$mbox = "reply-box"; 
			}

			$message_html .= "<p class=\"reply-date\">" . $row5[ 'cposted2' ] . "</p>\n";
			$message_html .= "<p class=\"reply-by\"><em>" . $MESSAGES_POSTBY . " : " . stripslashes($row4[ 'post_by' ]) . "</em></p>\n";
	        $message_html .= "<p class=\"" . $mbox . "\">" . $comment_br . "</p>\n";
			
			if ( $shade == '0' ) { 
				$shade++; 
			}
			else { 
				$shade = 0; 
			}
		  }
		}
		
		// check if user has Message permissions
		if (in_array("11", $user_perms)) {
			$ftype = "quickreply";
			include( "includes/forms.php" );
		}
		
	}
		
	return $message_html;
}

// SHOW HELP TOPICS
function help_topics() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$help_html = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">\n";
	$help_html .= "<tr>\n";
   	$help_html .= "<td valign=\"top\" class=\"body\">\n";
   	$help_html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";

	$query = " SELECT category, cat_id FROM ttcm_helpcat ORDER BY category ";
	$retid = $db_q($db, $query, $cid);
	$number = $db_c( $retid );
	
	$count = 0;
	$half = ( $number / 2 );
	
	for ( $count=0; $count<$half; $count++ ) {

		$row = $db_f($retid);
		$cat_id = $row[ "cat_id" ];
			
		$help_html .= "<tr><td class=\"title\" valign=\"top\">" . $row[ 'category' ] . "</td></tr>\n";

		$query2 = " SELECT topic, topic_id FROM ttcm_topics WHERE cat_id = '" . $row[ 'cat_id' ] . "' ORDER BY topic ";
		$retid2 = $db_q($db, $query2, $cid);
		$number2 = $db_c( $retid2 );
	
		$help_html .= "<tr><td class=\"body\" valign=\"top\">\n";
	
		while ( $row2 = $db_f($retid2) ) {
			
			// check if user has Help permissions
			if (in_array("68", $user_perms)) {
				$help_html .= "<a href=\"main.php?pg=help&amp;tid=" . $row2[ 'topic_id' ] . "&amp;task=deltopic\"><img src=\"../images/delete.gif\" border=\"0\"></a> ";
			}
			// check if user has User permissions
			if (in_array("67", $user_perms)) {
				$help_html .= "<a href=\"main.php?pg=edittopic&amp;tid=" . $row2[ 'topic_id' ] . "\">" . stripslashes($row2[ 'topic' ]) . "</a><br>\n";
			}
			else {
				$help_html .= stripslashes($row2[ 'topic' ]) . "<br>\n";
			}
		}
		
		$help_html .= "</td></tr>\n";
	}

	$help_html .= "</table>\n";
	$help_html .= "</td>\n";
	$help_html .= "<td valign=\"top\" class=\"body\">\n";
	$help_html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";

   for ( $count2=$count; ( $count2>=$half && $count2<$number); $count2++ ) {
		$row = $db_f($retid);

		$help_html .= "<tr><td class=\"title\" valign=\"top\">" . stripslashes($row[ 'category' ]) . "</td></tr>\n";

		$query2 = " SELECT * FROM ttcm_topics WHERE cat_id = '" . $row[ 'cat_id' ] . "' ORDER BY topic ";
		$retid2 = $db_q($db, $query2, $cid);
		$number2 = $db_c( $retid2 );

		$help_html .= "<tr><td class=\"body\" valign=\"top\">\n";
	
		while ( $row2 = $db_f($retid2) ) {
			
			// check if user has Help permissions
			if (in_array("68", $user_perms)) {
				$help_html .= "<a href=\"main.php?pg=help&amp;tid=" . $row2[ 'topic_id' ] . "&amp;task=deltopic\"><img src=\"../images/delete.gif\" border=\"0\"></a> ";
			}
			// check if user has Help permissions
			if (in_array("67", $user_perms)) {
				$help_html .= "<a href=\"main.php?pg=edittopic&amp;tid=" . $row2[ 'topic_id' ] . "\">" . stripslashes($row2[ 'topic' ]) . "</a><br>\n";
			}
			else {
				$help_html .= stripslashes($row2[ 'topic' ]) . "<br>\n";
			}
		}
		$help_html .= "</td></tr>\n";
	} 	
	$help_html .= "</table>\n";
   	$help_html .= "</td></tr>\n";
   	$help_html .= "</table>\n";

	return $help_html;
}

// SHOW TO DO LIST
function todo_list($clid, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$todo_html .= "<h2>" . $TODO_CLIENT;
	// check if user has To Do permissions
	if (in_array("47", $user_perms)) {
		$todo_html .= " <a href=\"main.php?pg=addtodo&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" title=\"Adicionar Atribui&ccedil;&atilde;o\">[ " . $COMMON_ADD . " ]</a>";
	}
	$todo_html .= "</h2>\n";
   	$todo_html .= "<table class=\"table\">\n";
	$todo_html .= "<tr class=\"title\">\n";
	$todo_html .= "<td width=\"60\" class=\"left\">feito <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=done&amp;todo_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=done&amp;todo_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "<td class=\"left\">atribui&ccedil;&atilde;o <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=item&amp;todo_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=item&amp;todo_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "<td width=\"75\">at&eacute; dia <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=deadline&amp;todo_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo_oby=deadline&amp;todo_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "<td>" . $COL_MODIFY . "</td>\n";
	$todo_html .= "</tr>\n";

	$query = " SELECT todo_id, item, deadline, done, link FROM ttcm_todo WHERE client_id = '" . $clid . "' AND project_id = '" . $pid . "' ORDER BY " . $_SESSION['todo_oby'] . " " . $_SESSION['todo_lby'];
	$retid = $db_q($db, $query, $cid);
	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$todo_html .= "<tr><td colspan=\"4\" class=\"left\">" . $TODO_NOITEMS . "</td></tr>\n";
	}
	else {

		while ( $row = $db_f($retid)) {
			$deadline = $row[ "deadline" ];
		
			$SQL2 = " SELECT DATE_FORMAT('$deadline','$_SESSION[date_format]') AS deadlines FROM ttcm_todo WHERE todo_id = '" . $row[ 'todo_id' ] . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			
			$todo_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
			$todo_html .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "\" METHOD=\"POST\">\n";
			$todo_html .= "<input type=\"hidden\" name=\"todo\" value=\"" . $row[ 'todo_id' ] . "\">\n";
			$todo_html .= "<input type=\"hidden\" name=\"task\" value=\"todo\">\n";
			if ($row[ 'done' ] == 1) {
				$todo_html .= "<td><input type=\"checkbox\" onClick=\"location.href='" . $web_path;
				$todo_html .= "admin/main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo=" . $row[ 'todo_id' ] . "&amp;task=ndtodo'\" name=\"done\" CHECKED";
			}
			else {
				$todo_html .= "<td><input type=\"checkbox\" onClick=\"location.href='" . $web_path;
				$todo_html .= "admin/main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;todo=" . $row[ 'todo_id' ] . "&amp;task=dtodo'\" name=\"done\"";
			}
			$todo_html .= "></td>";
			if ($row[ 'link' ] != '') {
				$todo_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $row[ 'link' ] . "');\" title=\"Abrir Link\">" . stripslashes($row[ 'item' ]) . "</a></td>\n";
			}
			else {
				$todo_html .= "<td class=\"left\">" . stripslashes($row[ 'item' ]) . "</td>\n";
			}
			$todo_html .= "<td>" . $row2[ 'deadlines' ] . "</td>\n";
			$todo_html .= "<td>";
			// check if user has To Do permissions
			if (in_array("48", $user_perms)) {
				$todo_html .= "<a href=\"main.php?pg=proj&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;tdid=" . $row[ 'todo_id' ] . "&amp;task=deltodo\" title=\"Excluir\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a>";
			}
			$todo_html .= "</td>\n";
			$todo_html .= "</tr>\n";
			$todo_html .= "</FORM>\n";
		}
	}

	$todo_html .= "</table>\n";

	return $todo_html;
}

// SHOW FILE TYPES
function file_types() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$types_html = "<h2>" . $FILETYPES_HEADER . "</h2>\n";
   	$types_html .= "<table class=\"table\">\n";
   	$types_html .= "<tr class=\"title\">\n";
   	$types_html .= "<td class=\"left\">" . $COL_FILETYPE . "</td>\n";
   	$types_html .= "<td>" . $COL_NUMFILES . "</td>\n";
   	$types_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$types_html .= "</tr>\n";

	$SQL = " SELECT type_id, file_type FROM ttcm_filetype ORDER BY file_type ";
	$retid = $db_q($db, $SQL, $cid);
	
	while ( $row = $db_f($retid) ) {
			
		$query2 = " SELECT * FROM ttcm_files WHERE type_id = '" . $row[ 'type_id' ] . "' ";
		$retid2 = $db_q($db, $query2, $cid);
		$number_files = $db_c( $retid2 );
		
		$types_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n"; 
      	$types_html .= "<td class=\"left\">" . stripslashes($row[ 'file_type' ]) . "</td>\n";
      	$types_html .= "<td><a href=\"main.php?pg=filebytype&amp;type_id=" . $row[ 'type_id' ] . "\" title=\"Ver Documentos\">" . $number_files . " " . $COMMON_FILES . "</a></td>\n";
      	$types_html .= "<td>";
		// check if user has File permissions
		if (in_array("61", $user_perms)) {
			$types_html .= "<a href=\"main.php?pg=filetypes&amp;task=deltype&amp;type_id=" . $row[ 'type_id' ] . "\" title=\"Excluir " . $file_type . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a>";
		}
		$types_html .= "</td>\n";
    	$types_html .= "</tr>\n";
	}
	$types_html .= "</table>\n";
	
	return $types_html;
}

// EXIBIR NÍVEIS DE USUÁRIO
function user_types() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
   	$types_html = "<h2>" . $USERTYPE_HEADER . " <a href=\"main.php?pg=addusertype\">[ " . $COMMON_ADD . " ]</a></h2>\n";
   	$types_html .= "<table class=\"table\">\n";
   	$types_html .= "<tr class=\"title\">\n";
   	$types_html .= "<td class=\"left\">" . $COL_USERTYPE . "</td>\n";
	$types_html .= "<td class=\"left\">" . $COL_USERTYPEDESC . "</td>\n";
   	$types_html .= "<td>" . $COL_NUMUSERS . "</td>\n";
   	$types_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$types_html .= "</tr>\n";

	$SQL = " SELECT usertype_id, name, description FROM ttcm_usertypes ORDER BY name ";
	$retid = $db_q($db, $SQL, $cid);
	
	while ( $row = $db_f($retid) ) {
			
		$query2 = " SELECT * FROM ttcm_user WHERE type = '" . $row[ 'usertype_id' ] . "' ";
		$retid2 = $db_q($db, $query2, $cid);
		$number_users = $db_c( $retid2 );
		
		$types_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n"; 
      	$types_html .= "<td class=\"left\">" . stripslashes($row[ 'name' ]) . "</td>\n";
		$types_html .= "<td class=\"left\">" . stripslashes($row[ 'description' ]) . "</td>\n";
      	$types_html .= "<td>" . $number_users . "</td>\n";
      	$types_html .= "<td>";
		// check if user has File permissions
		if (in_array("8", $user_perms)) {
			if ($row['usertype_id'] != '1') {
				$types_html .= "<a href=\"main.php?pg=editusertype&amp;usertype_id=" . $row[ 'usertype_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> 
				<a href=\"main.php?pg=usertypes&amp;task=delusertype&amp;usertype_id=" . $row[ 'usertype_id' ] . "&amp;users=" . $number_users . "\" title=\"Excluir " . stripslashes($row['name']) . "\"><img src=\"../images/delete.gif\" border=\"0\" alt=\"delete\"></a>";
			}
		}
		$types_html .= "</td>\n";
    	$types_html .= "</tr>\n";
	}
	$types_html .= "</table>\n";
	
	return $types_html;
}

// SHOW FILES BY TYPE
function files_bytype() {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$bytype_html = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";
   	$bytype_html .= "<tr><td valign=\"top\" class=\"body\">\n";
   	$bytype_html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";

	$query = " SELECT file_type, type_id FROM ttcm_filetype ORDER BY file_type ";
	$retid = $db_q($db, $query, $cid);
	
	$number = $db_c( $retid );
	$count = 0;
	$half = ( $number / 2 );
	
	for ( $count=0; $count<$half; $count++ ) {
		$row = $db_f($retid);

		$bytype_html .= "<tr><td class=\"title\" valign=\"top\">" . stripslashes($row[ 'file_type' ]) . " <a href=\"main.php?pg=filebytype&amp;type_id=" . $row[ 'type_id' ] . "\">[ " . $COMMON_VIEWALL . " ]</a></td></tr>\n";

		$query2 = " SELECT name, file_id, project_id FROM ttcm_files WHERE type_id = '" . $row[ 'type_id' ] . "' ORDER BY added DESC limit 5 ";
		$retid2 = $db_q($db, $query2, $cid);
		$number2 = $db_c( $retid2 );
	
		if ($number2 == 0) { 
			$bytype_html .= "<tr><td class=\"body\" valign=\"top\">" . $ALLTYPE_NOFILES . "</td></tr>\n";
		}
		else
		{
			$bytype_html .= "<tr><td class=\"body\" valign=\"top\">\n";
	
			while ( $row2 = $db_f($retid2) ) {
				$project_id = $row2[ 'project_id' ];
				
				if ($project_id != '0') {
			
					$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
					$retid4 = $db_q($db, $query4, $cid);
					$row4 = $db_f($retid4);
					$file_perms = $row4['permissions'];
			
					$user_id = $_SESSION['valid_id'];
					$file_vars = split(',', $file_perms);
			
					if (in_array($user_id, $file_vars)) {
				
						// check if user has File permissions
						if (in_array("23", $user_perms)) {
							$bytype_html .= "- <a href=\"main.php?pg=editfile&amp;file_id=" . $row2[ 'file_id' ] . "\">" . stripslashes($row2[ 'name' ]) . "</a><br>\n";
						}
						else {
							$bytype_html .= "- " . stripslashes($row2[ 'name' ]) . "<br>\n";
						}
					}
				}
				else {
					$bytype_html .= "- <a href=\"main.php?pg=editfile&amp;file_id=" . $row2[ 'file_id' ] . "\">" . stripslashes($row2[ 'name' ]) . "</a><br>\n";
				}
			}
		}
	}
	$bytype_html .= "</td></tr></table>\n";
	$bytype_html .= "</td>\n";
	$bytype_html .= "<td valign=\"top\" class=\"body\">\n";
	$bytype_html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";

	for ( $count2=$count; ( $count2>=$half && $count2<$number); $count2++ ) {
		$row = $db_f($retid);

		$bytype_html .= "<tr><td class=\"title\" valign=\"top\">" . $row[ 'file_type' ] . " <a href=\"main.php?pg=filebytype&amp;type_id=" . $row[ 'type_id' ] . "\">[ " . $COMMON_VIEWALL . " ]</a></td></tr>\n";

		$query2 = " SELECT name, file_id FROM ttcm_files WHERE type_id = '" . $row[ 'type_id' ] . "' ORDER BY added DESC limit 5 ";
		$retid2 = $db_q($db, $query2, $cid);
		$number2 = $db_c( $retid2 );
	
		if ($number2 == 0) { 
			$bytype_html .= "<tr><td class=\"body\" valign=\"top\">" . $ALLTYPE_NOFILES . "</td></tr>\n";
		}
		else
		{
			$bytype_html .= "<tr><td class=\"body\" valign=\"top\">\n";
	
			while ( $row2 = $db_f($retid2) ) {
				$project_id = $row2[ 'project_id' ];
			
				if ($project_id != '0') {
			
					$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
					$retid4 = $db_q($db, $query4, $cid);
					$row4 = $db_f($retid4);
					$file_perms = $row4['permissions'];
			
					$user_id = $_SESSION['valid_id'];
					$file_vars = split(',', $file_perms);
			
					if (in_array($user_id, $file_vars)) {
				
						// check if user has File permissions
						if (in_array("23", $user_perms)) {
							$bytype_html .= "- <a href=\"main.php?pg=editfile&amp;file_id=" . $row2[ 'file_id' ] . "\">" . stripslashes($row2[ 'name' ]) . "</a><br>\n";
						}
						else {
							$bytype_html .= "- " . stripslashes($row2[ 'name' ]) . "<br>\n";
						}
					}
				}
				else {
					$bytype_html .= "- <a href=\"main.php?pg=editfile&amp;file_id=" . $row2[ 'file_id' ] . "\">" . stripslashes($row2[ 'name' ]) . "</a><br>\n";
				}
			}
		}
	}
	$bytype_html .= "</td></tr>\n";

	$bytype_html .= "</table>\n";
	$bytype_html .= "</td>\n</tr>\n</table>\n";

	return $bytype_html;
}

// SHOW CLIENT FILES
function show_files($clid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path, $home_dir;
	
	include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );
	include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$files_html = '';
   	if ( isset( $clid ) && ( $clid != 0 ) ) {
      	$files_html .= "<h2>" . $CLIENTS_FILES;

		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			$files_html .= " <a href=\"main.php?pg=addfiles&amp;clid=" . $clid . "\" title=\"" . $COMMON_ADD . "\">[ " . $COMMON_ADD . " ]</a>";
		}
		$files_html .= "</h2>\n";
  	} 
	else {
    	$files_html .= "<h2>" . $CLIENTS_LASTULFILES;

		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			$files_html .= " <a href=\"main.php?pg=addfiles\" title=\"" . $COMMON_ADD . "\">[ " . $COMMON_ADD . " ]</a>";
		}
		$files_html .= "</h2>\n";
   }
	$files_html .= "<table class=\"table\">";
   	$files_html .= "<tr class=\"title\">\n";
   	$files_html .= "<td width=\"54\"> </td>\n";
	$files_html .= "<td class=\"left\">" . $COL_FILETITLE . " / " . $COL_CLIENT . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=name&amp;files_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=name&amp;files_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $_GET['clid'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=added&amp;files_lby=ASC\"><img src=\"../images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=added&amp;files_lby=DESC\"><img src=\"../images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$files_html .= "<td>" . $COL_MODIFY . "</td>\n";
   	$files_html .= "</tr>\n";

	if ( isset( $clid ) && ( $clid != 0 ) )
	{
		$add_where .= " WHERE client_id = " . $clid;
	}
						
	$SQL = " SELECT file_id, client_id, file, name, link, added, project_id FROM ttcm_files " . $add_where . " ORDER BY " . $_SESSION['files_oby'] . " " . $_SESSION['files_lby'] . " limit 10";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$files_html .= "<tr>\n";
      	$files_html .= "<td colspan=\"4\" class=\"left\">" . $ALLTYPE_NOFILES . "</td>\n";
      	$files_html .= "</tr>\n";
	}
	else {
	
		while ( $row = $db_f($retid) ) {
			$added = $row[ 'added' ];
			$project_id = $row[ 'project_id' ];
			$link = $row[ 'link' ];
			
			$check_link = substr($link,0,3);
			if ($check_link == 'www') {
				$file_link = "http://" . $link;
			}
			else if ($check_link == 'htt') {
				$file_link = $link;
			}
			else {
				$file_link = $web_path . $row[ 'link' ];
			}
			
			if ($project_id != '0') {
			
			$query4 = " SELECT permissions FROM ttcm_project WHERE project_id = '" . $project_id . "'";
			$retid4 = $db_q($db, $query4, $cid);
			$row4 = $db_f($retid4);
			$file_perms = $row4['permissions'];
			
			$user_id = $_SESSION['valid_id'];
			$file_vars = split(',', $file_perms);
			
			if (in_array($user_id, $file_vars)) {
			
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT * FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "' ";
				$retid2 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid2);
			
				// check file format
				$extension_array = explode (".", $row["file"]);
				$extension_count = (count($extension_array) - 1);
				$extension_raw = $extension_array[$extension_count];
				$extension = strtolower($extension_raw);
			
				$checkpath = $home_dir . "images/fileicons/" . $extension . ".gif";
			
				if ($row["file"] != '') {
					if ( is_file( $checkpath ) ) {
						$file_icon = $web_path . "images/fileicons/" . $extension . ".gif";
					}
					else {
						$file_icon = $web_path . "images/fileicons/gen.gif";
						}
					}
					else {
						$file_icon = $web_path . "images/fileicons/web.gif";
					}

					$files_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         			$files_html .= "<td class=\"left\" width=\"54\"><a href=\"javascript:newWin('" . $file_link . "');\"><img src=\"" . $file_icon . "\" width=\"54\" height=\"54\" border=\"0\" alt=\"" . $row[ 'name' ] . "\"></a></td>\n";
         			$files_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a><br />" . stripslashes($row3[ 'company' ]) . "</td>\n";
         			$files_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         			$files_html .= "<td>";
					// check if user has Project permissions
					if (in_array("23", $user_perms)) {
						$files_html .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
					}
					// check if user has Project permissions
					if (in_array("24", $user_perms)) {
						$files_html .= "<a href=\"main.php?pg=files&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
					}
					$files_html .= "</td>\n";
         			$files_html .= "</tr>\n";
				}
			}
			else {
				$SQL2 = " SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $row[ 'file_id' ] . "'";
				$retid2 = $db_q($db, $SQL2, $cid);
				$row2 = $db_f($retid2);
			
				$query = " SELECT * FROM ttcm_client WHERE client_id = '" . $row[ 'client_id' ] . "' ";
				$retid2 = $db_q($db, $query, $cid);
				$row3 = $db_f($retid2);
			
				// check file format
				$extension_array = explode (".", $row["file"]);
				$extension_count = (count($extension_array) - 1);
				$extension_raw = $extension_array[$extension_count];
				$extension = strtolower($extension_raw);
			
				$checkpath = $home_dir . "images/fileicons/" . $extension . ".gif";
			
				if ($row["file"] != '') {
					if ( is_file( $checkpath ) ) {
						$file_icon = $web_path . "images/fileicons/" . $extension . ".gif";
					}
					else {
						$file_icon = $web_path . "images/fileicons/gen.gif";
						}
					}
					else {
						$file_icon = $web_path . "images/fileicons/web.gif";
					}

					$files_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
         			$files_html .= "<td class=\"left\" width=\"54\"><a href=\"javascript:newWin('" . $file_link . "');\"><img src=\"" . $file_icon . "\" width=\"54\" height=\"54\" border=\"0\" alt=\"" . $row[ 'name' ] . "\"></a></td>\n";
         			$files_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . stripslashes($row[ 'name' ]) . "</a><br />" . stripslashes($row3[ 'company' ]) . "</td>\n";
         			$files_html .= "<td>" . $row2[ 'added2' ] . "</td>\n";
         			$files_html .= "<td>";
					// check if user has Project permissions
					if (in_array("23", $user_perms)) {
						$files_html .= "<a href=\"main.php?pg=editfile&amp;file_id=" . $row[ 'file_id' ] . "\" title=\"Editar " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/edit.gif\" border=\"0\"></a> ";
					}
					// check if user has Project permissions
					if (in_array("24", $user_perms)) {
						$files_html .= "<a href=\"main.php?pg=files&amp;fid=" . $row[ 'file_id' ] . "&amp;task=delfile\" title=\"Excluir " . stripslashes($row[ 'name' ]) . "\"><img src=\"../images/delete.gif\" border=\"0\"></a>";
					}
					$files_html .= "</td>\n";
         			$files_html .= "</tr>\n";
				}
		}
	}
	$files_html .= "</table>\n";

	return $files_html;
}
?>