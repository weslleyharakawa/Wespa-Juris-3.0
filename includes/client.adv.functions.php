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

  function Page($template = "templates/client_template.tpl") {
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

// PULL PROJECTS FROM DATABASE
function get_projects($client_id, $active='') {

	global $cid, $db_q, $db_f, $db;

	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$project_html = '';
	
	if ($active == '1') {
		$SQL = "SELECT project_id, milestone, updated, finish, title, status FROM ttcm_project WHERE client_id = '" . $client_id . "' AND finish = '0000-00-00' ORDER BY " . $_SESSION['aproj_oby'] . " " . $_SESSION['aproj_lby'];
		$retid = $db_q($db, $SQL, $cid);
		$proj_where = "client_id = '" . $client_id . "' AND finish = '0000-00-00'";
		
		$project_html .= "<h2>" . $PROJECTS_ACTIVEHEAD . " <a href=\"main.php?pg=allproj\" title=\"" . $PROJECTS_VIEWALL . "\">[ " . $PROJECTS_VIEWALL . " ]</a></h2>\n";
	}
	
	else {
		$SQL = "SELECT project_id, milestone, updated, finish, title, status FROM ttcm_project WHERE client_id = '" . $client_id . "' ORDER BY " . $_SESSION['aproj_oby'] . " " . $_SESSION['aproj_lby'];
		$retid = $db_q($db, $SQL, $cid);
		$proj_where = "client_id = '" . $client_id . "'";
		
		$project_html .= "<h2>" . $PROJECTS_ALLPROJ . "</h2>\n";
	}
	
	$project_html .= "<table class=\"table\">\n";
	$project_html .= "<tr class=\"title\">\n";
	$project_html .= "<td class=\"left\">" . $COL_PROJTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=title&amp;aproj_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=title&amp;aproj_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> / " . $COL_CLIENT . "</td>\n";
   	$project_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=milestone&amp;aproj_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=milestone&amp;aproj_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$project_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=status&amp;aproj_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=status&amp;aproj_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$project_html .= "<td>" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=updated&amp;aproj_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;aproj_oby=updated&amp;aproj_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    $project_html .= "</tr>";
    
    $ap_number = count_number(ttcm_project, "$proj_where");
                    
    if ($ap_number == '0') {
    	$project_html .= "<tr>\n";
    	$project_html .= "<td class=\"left\">" . $PROJECTS_NOPROJ . "</td>\n";
    	$project_html .= "</tr>\n";
    }
    
    else {
	
		while ( $row = $db_f($retid) ) {
		$proj_id = $row[ "project_id" ];
		$milestone = $row[ "data limite" ];
		$updated = $row[ "updated" ];
		$finished = $row[ "finish" ];
		$proj_title = $row[ "title" ];
		$proj_title = stripslashes($proj_title);
		$status = $row[ "status" ];
			
		$SQL2 = "SELECT DATE_FORMAT('$updated','$_SESSION[date_format] at %l:%i %p') AS updated2, DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestone2 FROM ttcm_project WHERE project_id = '" . $proj_id . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$milestones2 = $row2[ "milestone2" ];
		$updates2 = $row2[ "updated2" ];
	
		$project_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n"; 
    	$project_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&pid=" . $proj_id . "\">" . $proj_title . "</a></td>\n";
		
		if ( $finished == '0000-00-00' ) {
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
				$project_html .= "<td class=\"pastdue\">" . $milestones2 . "</td>\n";
			}
			else { 
				$project_html .= "<td>" . $milestones2 . "</td>\n";
			}
		}
		else { 
			$project_html .= "<td>" . $milestones2 . "</td>\n";
		}

    	$project_html .= "<td>" . $status . "</td>\n";
    	$project_html .= "<td>" . $updates2 . "</td>\n";
    	$project_html .= "</tr>\n";
    	}
    }
	$project_html .= "</table>\n";
	
	return $project_html;
}

// SHOW TO DO LIST
function todo_list($clid, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;

	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_dashboard.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$todo_html = "<h2>" . $TODO_HEADER . "</h2>\n";
	$todo_html .= "<table class=\"table\">\n";
	$todo_html .= "<tr class=\"title\">\n";
	$todo_html .= "<td width=\"60\" class=\"left\">feito <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=done&amp;todo_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=done&amp;todo_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "<td class=\"left\">atribui&ccedil;&atilde;o <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=item&amp;todo_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=item&amp;todo_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "<td>processo</td>\n";
	$todo_html .= "<td width=\"75\">at&eacute; dia <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=deadline&amp;todo_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $pid . "&amp;todo_oby=deadline&amp;todo_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
	$todo_html .= "</tr>\n";

	if ( ( $pid != '' ) OR ( $pid != '0' ) ) {
		$query = "SELECT todo_id, project_id, item, deadline, done, link FROM ttcm_todo WHERE client_id = '" . $clid . "' AND project_id = '" . $pid . "' ORDER BY " . $_SESSION['todo_oby'] . " " . $_SESSION['todo_lby'];
	}
	else {
		$query = "SELECT todo_id, project_id, item, deadline, done, link FROM ttcm_todo WHERE client_id = '" . $clid . "' ORDER BY " . $_SESSION['todo_oby'] . " " . $_SESSION['todo_lby'];
	}
	$retid = $db_q($db, $query, $cid);
	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$todo_html .= "<tr>\n<td class=\"left\">" . $TODO_NOTODO . "</td>\n</tr>\n";
	}
	else {

	while($row = $db_f($retid)) {
		$todo_id = $row[ "todo_id" ];
		$pid = $row[ "project_id" ];
		$item = $row[ "item" ];
		$item = stripslashes($item);
		$deadline = $row[ "deadline" ];
		$done = $row[ "done" ];
		$todo_link = $row[ "link" ];
		
		$SQL3 = "SELECT title FROM ttcm_project WHERE project_id = '" . $pid . "'";
		$retid3 = $db_q($db, $SQL3, $cid);
		$proj = $db_f( $retid3 );
		$project_title = stripslashes($proj[ "title" ]);
		
		$SQL2 = "SELECT DATE_FORMAT('$deadline','$_SESSION[date_format]') AS deadlines FROM ttcm_todo WHERE todo_id = '" . $todo_id . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$deadline2 = $row2[ "deadlines" ];
			
		if (in_array('90', $user_perms)) {
			$todo_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
			$todo_html .= "<FORM NAME=\"done\" ACTION=\"main.php?pg=proj&amp;pid=" . $pid . "\" METHOD=\"POST\">\n";
			$todo_html .= "<input type=\"hidden\" name=\"todo\" value=\"" . $todo_id . "\">\n";
			$todo_html .= "<input type=\"hidden\" name=\"task\" value=\"todo\">\n";
			
			if ($done == 1) {
				$todo_html .= "<td><input type=\"checkbox\" onClick=\"location.href='" . $web_path;
				$todo_html .= "main.php?pg=proj&amp;pid=" . $pid . "&amp;todo=" . $todo_id . "&amp;task=ndtodo'\" name=\"done\" CHECKED";
			}
			else {
				$todo_html .= "<td><input type=\"checkbox\" onClick=\"location.href='" . $web_path;
				$todo_html .= "main.php?pg=proj&amp;pid=" . $pid . "&amp;todo=" . $todo_id . "&amp;task=dtodo'\" name=\"done\"";
			}
			$todo_html .= "></td>";
		}
		else {
			if ($done == 1) {
				$todo_html .= "<td><input type=\"checkbox\" name=\"done\" CHECKED";
			}
			else {
				$todo_html .= "<td><input type=\"checkbox\" name=\"done\"";
			}
			$todo_html .= " disabled=\"true\"></td>";
		}
		
		if ($todo_link != '') {
			$todo_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $todo_link . "');\">" . $item . "</a></td>\n";
		}
		else {
			$todo_html .= "<td class=\"left\">" . $item . "</td>\n";
		}
		$todo_html .= "<td>" . $project_title . "</td>\n";
		$todo_html .= "<td>" . $deadline2 . "</td>\n";
		$todo_html .= "</tr>\n";
		$todo_html .= "</FORM>";
	}

	}
	$todo_html .= "</table>\n";

	return $todo_html;
}

// SHOW SIDE ACTIVE PROJECTS
function active_projects($client_id) {

	global $cid, $db_q, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );

	$activep_html = "<h2>" . $PROJECTS_ACTIVEHEAD . "</h2>\n";
    
    $ap_number = count_number(ttcm_project, "client_id = '" . $client_id . "' AND finish = '0000-00-00'");
	
	if ( $ap_number == '0' ) {
		$activep_html .= "<tr>\n<td class=\"left\">" . $PROJECTS_NOACTIVE . "</td>\n</tr>\n";
	} 
	else {

		$SQL = "SELECT project_id, title, status FROM ttcm_project WHERE client_id = '" . $client_id . "' AND finish = '0000-00-00' ORDER BY milestone DESC";
		$retid = $db_q($db, $SQL, $cid);
    	
		while ( $row = $db_f($retid) ) {
    		$project_id = $row[ "project_id" ];
    		$project_title = $row[ "title" ];
			$project_title = stripslashes($project_title);
    		$project_status = $row[ "status" ];

			$activep_html .= "<p><strong><a href=\"main.php?pg=proj&amp;pid=" . $project_id . "\">" . $project_title . "</a></strong><br />\n";
    		$activep_html .= $project_status . "</p>\n";
		}
	}

	return $activep_html;
}

// PROJECT SEARCH
function project_search($search, $client_id) {
	
	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_search.php" );
	
	$psearch_html = '';
	
	$SQL = "SELECT project_id, title, start, finish, status FROM ttcm_project WHERE title LIKE '%" . $search . "%' AND client_id = '" . $client_id . "'";
	$retid = $db_q($db, $SQL, $cid);
			 
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$psearch_html .= "<h2>" . $SEARCH_NONEFOUND . "</h2>\n";
		$psearch_html .= "<p>" . $SEARCH_NORESULTS . "</p>\n";
	} 
	else {
        $psearch_html .= "<h2>" . $PROJECTS_HEADER . "</h2>\n";
        $psearch_html .= "<table class=\"table\">\n";
        $psearch_html .= "<tr class=\"title\">\n";
        $psearch_html .= "<td class=\"left\">" . $PROJECTS_PROJTITLE . "</td>\n";
        $psearch_html .= "<td>" . $COMMON_STARTDATE . "</td>\n";
        $psearch_html .= "<td>" . $COMMON_STATUS . "</td>\n";
        $psearch_html .= "<td>" . $COMMON_FINISHDATE . "</td>\n";
        $psearch_html .= "</tr>\n";
        
        while ( $row = $db_f($retid) ) {
			$project_id = $row[ "project_id" ];
			$proj_title = $row[ "title" ];
			$proj_title = stripslashes($proj_title);
			$start = $row[ "start" ];
			$finish = $row[ "finish" ];
			$status = $row[ "status" ];
			
			$SQL2 = "SELECT DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_project WHERE project_id = '" . $project_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$started2 = $row2[ "start2" ];
			$finished2 = $row2[ "finish2" ];

			$psearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $psearch_html .= "<td class=\"left\"><a href=\"main.php?pg=proj&amp;pid=" . $project_id . "\">" . $proj_title . "</a></td>\n";
            $psearch_html .= "<td>" . $started2 . "</td>\n";
            $psearch_html .= "<td>" . $status . "</td>\n";
            $psearch_html .= "<td>\n";
            if ( $finish == '0000-00-00' ) { 
            	$psearch_html .= "NA";
            } else { 
            	$psearch_html .= $finished2;
            }
            $psearch_html .= "</td>\n";
			$psearch_html .= "</tr>\n";
		}
		$psearch_html .= "</table>\n";
	}
	return $psearch_html;
}

// DOWNLOADS SEARCH
function download_search($search, $client_id) {
	
	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_search.php" );

	$dl_type = $_POST['type'];
	if ($dl_type != '0') {
		$add_where = " AND type_id = '" . $dl_type . "'";
	}
	
	$dsearch_html = '';
	
	$SQL = "SELECT file_id, type_id, project_id, file, name, link, added FROM ttcm_files WHERE name LIKE '%" . $search . "%'" . $add_where . " AND client_id = '" . $client_id . "' ORDER BY added DESC";
	$retid = $db_q($db, $SQL, $cid);
			 
	$number = $db_c( $retid );
	if ( $number == '0' ) {
		$dsearch_html .= "<h2>" . $SEARCH_NONEFOUND . "</h2>\n";
		$dsearch_html .= "<p>" . $SEARCH_NORESULTS . "</p>\n";
	} 
	else {
    	$dsearch_html .= "<h2>" . $DOWNLOADS_PROJFILES . "</h2>\n";
    	$dsearch_html .= "<table class=\"table\">\n";
    	$dsearch_html .= "<tr class=\"title\">\n";
    	$dsearch_html .= "<td class=\"left\">" . $COMMON_FILETYPE . "</td>\n";
    	$dsearch_html .= "<td class=\"left\">" . $COMMON_FILETITLE . "</td>\n";
    	$dsearch_html .= "<td>" . $COL_PROJTITLE . "</td>\n";
    	$dsearch_html .= "<td>" . $COMMON_DATEADDED . "</td>\n";
    	$dsearch_html .= "</tr>\n";
    
    	while ( $row = $db_f($retid) ) {
			$file_id = $row[ "file_id" ];
			$type_id = $row[ "type_id" ];
			$project_id = $row[ "project_id" ];
			$file = $row[ "file" ];
			$file_name = $row[ "name" ];
			$file_name = stripslashes($file_name);
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
			
			$SQL2 = "SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $file_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$added2 = $row2[ "added2" ];
			
			$SQL3 = "SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $type_id . "'";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			$file_type = $row3[ "file_type" ];
			
			$SQL4 = "SELECT title FROM ttcm_project WHERE project_id = '" . $project_id . "'";
			$retid4 = $db_q($db, $SQL4, $cid);
			$row4 = $db_f($retid4);
			$project_title = $row4[ "title" ];
			$project_title = stripslashes($project_title);

			$dsearch_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $dsearch_html .= "<td class=\"left\"><strong>" . $file_type . "</strong></td>\n";
            $dsearch_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . $file_name . "</td>\n";
            $dsearch_html .= "<td>" . $project_title . "</td>\n";
            $dsearch_html .= "<td>" . $added2 . "</td>\n";
            $dsearch_html .= "</tr>\n";
		}
		$dsearch_html .= "</table>\n";
	} 
	return $dsearch_html;
}

// HELP CATEGORIES & TOPICS
function get_helpct() {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_helpsection.php" );
	
	$helpct_html = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"8\">\n";
    $helpct_html .= "<tr>\n";
    $helpct_html .= "<td valign=\"top\" class=\"body\">\n";
    $helpct_html .= "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">\n";

	$SQL = "SELECT category, cat_id FROM ttcm_helpcat ORDER BY category ";
	$retid = $db_q($db, $SQL, $cid);

	$lnumber = $db_c( $retid );
	$lcount = 0;
	$half = ( $lnumber / 2 );
	
	// LEFT SIDE CATEGORIES
	
	for ( $lcount=0; $lcount<$half; $lcount++ ) {

		$row = $db_f($retid);
		$category = $row[ "category" ];
		$category = stripslashes($category);
		$cat_id = $row[ "cat_id" ];
		
		$helpct_html .= "<tr><td class=\"title\" valign=\"top\">" . $category . "</td></tr>";

		// PULL TOPICS FOR CATEGORY
		
		$SQL2 = "SELECT topic, topic_id FROM ttcm_topics WHERE cat_id = '" . $cat_id . "' ORDER BY topic ";
		$retid2 = $db_q($db, $SQL2, $cid);
	
		while ( $row2 = $db_f($retid2) ) {

			$topic = $row2[ "topic" ];
			$topic = stripslashes($topic);
			$tid = $row2[ "topic_id" ];
			
			$helpct_html .= "<tr><td class=\"body\" valign=\"top\">- <a href=\"main.php?pg=topic&amp;tid=" . $tid . "\">" . $topic . "</a></td></tr>\n";
		}
	}
	$helpct_html .= "</table>\n";
    $helpct_html .= "</td>\n";
    $helpct_html .= "<td valign=\"top\" class=\"body\">\n";
    $helpct_html .= "<table width=\"100%\" cellspacing=\"5\" cellpadding=\"0\" border=\"0\">\n";
    
    // RIGHT SIDE CATEGORIES
    for ( $rcount=$lcount; ( $rcount>=$half && $rcount<$lnumber); $rcount++ ) {

		$row = $db_f($retid);
		$category = $row[ "category" ];
		$category = stripslashes($category);
		$cat_id = $row[ "cat_id" ];

		$helpct_html .= "<tr><td class=\"title\" valign=\"top\">" . $category . "</td></tr>\n";

		// PULL TOPICS FOR CATEGORY
		
		$SQL2 = "SELECT topic, topic_id FROM ttcm_topics WHERE cat_id = '" . $cat_id . "' ORDER BY topic ";
		$retid2 = $db_q($db, $SQL2, $cid);
	
		while ( $row2 = $db_f($retid2) ) {

			$topic = $row2[ "topic" ];
			$topic = stripslashes($topic);
			$tid = $row2[ "topic_id" ];
		
			$helpct_html .= "<tr><td class=\"body\" valign=\"top\">- <a href=\"main.php?pg=topic&amp;tid=" . $tid . "\">" . $topic . "</a></td></tr>\n";
		}
	}
	$helpct_html .= "</table>\n";
    $helpct_html .= "</td></tr>\n";
    $helpct_html .= "</table>\n";
    
    return $helpct_html;
}

// GET PROJECT FILES
function project_files($client_id) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );

    $files_html = "<h2>" . $DOWNLOADS_PROJFILES . "</h2>\n";
    $files_html .= "<table class=\"table\">\n";
    $files_html .= "<tr class=\"title\">\n";
   	$files_html .= "<td class=\"left\">" . $COL_FILETYPE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=type_id&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=type_id&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    $files_html .= "<td class=\"left\">" . $COL_FILETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=name&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=name&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td>" . $COL_PROJTITLE . "</td>\n";
   	$files_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=added&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;files_oby=added&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    $files_html .= "</tr>\n";
            
    $SQL = "SELECT file_id, type_id, project_id, name, link, added FROM ttcm_files WHERE client_id = '" . $client_id . "' ORDER BY " . $_SESSION['files_oby'] . " " . $_SESSION['files_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$files_html .= "<tr>\n";
        $files_html .= "<td colspan=\"4\">" . $DOWNLOADS_NOFILES . "</td>\n";
        $files_html .= "</tr>\n";
    } 
	else {
	
		while ( $row = $db_f($retid) ) {
			$file_id = $row[ "file_id" ];
			$type_id = $row[ "type_id" ];
			$project_id = $row[ "project_id" ];
			$file = $row[ "name" ];
			$file = stripslashes($file);
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
			
			$SQL2 = "SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $file_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$added2 = $row2[ "added2" ];
			
			$SQL3 = "SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $type_id . "' ";

			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			$file_type = $row3[ "file_type" ];
			
			$SQL4 = "SELECT title FROM ttcm_project WHERE project_id = '" . $project_id . "' ";

			$retid4 = $db_q($db, $SQL4, $cid);
			$row4 = $db_f($retid4);
			$project_title = $row4[ "title" ];
			$project_title = stripslashes($project_title);

			$files_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $files_html .= "<td class=\"left\"><strong>" . $file_type . "</strong></td>\n";
            $files_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . $file . "</td>\n";
            $files_html .= "<td>" . $project_title . "</td>\n";
            $files_html .= "<td>" . $added2 . "</td>\n";
            $files_html .= "</tr>\n";
		}
	}
    $files_html .= "</table>\n";
    
    return $files_html;
}

// LIST CLIENT FILES
function client_files($client_id) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

    $files_html = "<h2>" . $UPLOADS_UPLOADED . "</h2>\n";
    $files_html .= "<table class=\"table\">\n";
            
    $SQL = "SELECT project_id, file_id, name, link FROM ttcm_cfiles WHERE client_id = '" . $client_id . "' ORDER BY 'name'";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$files_html .= "<tr>\n";
        $files_html .= "<td class=\"left\">" . $UPLOADS_NOUPLOADS . "</td>\n";
        $files_html .= "</tr>\n";
    } 
	else {
	
		while ( $row = $db_f($retid) ) {
			$project_id = $row[ "project_id" ];
			$fid = $row[ "file_id" ];
			$file = $row[ "name" ];
			$file =  stripslashes($file);
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
			
			$SQL2 = "SELECT title FROM ttcm_project WHERE project_id = '" . $project_id . "' ";

			$retid4 = $db_q($db, $SQL2, $cid);
			$row4 = $db_f($retid4);
			$project_title = $row4[ "title" ];
			$project_title = stripslashes($project_title);
			
			if ($project_title == '') {
				$project_title = $UPLOADS_NOPROJECT;
			}

			$files_html .= "<tr>\n";
            $files_html .= "<td class=\"body\">";

			// check if user has Upload permissions
		  	if (in_array("86", $user_perms)) {
				$files_html .= "<a href=\"main.php?pg=uploads&amp;fid=" . $fid . "&amp;task=delcfile\"><img src=\"images/delete.gif\" border=\"0\"></a> ";
			}
			// check if user has Upload permissions
		  	if (in_array("91", $user_perms)) {
				$files_html .= "<strong><a href=\"javascript:newWin('" . $file_link . "');\">" . $file . "</a></strong><br />\n";
			}
			else {
				$files_html .= "<strong>" . $file . "</strong><br />\n";
			}
				
            $files_html .= "<em>" . $project_title . "</em>\n";
            $files_html .= "</td>\n";
			$files_html .= "</tr>\n";
		}
	}
    $files_html .= "</table>\n";
    
    return $files_html;
}

// GET LINKS
function get_links($client_id) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_bookmarks.php" );

	$links_html = "<h3>$LINKS_LINKS</h3>\n";

	$SQL = "SELECT link_title, link_desc, link FROM ttcm_links WHERE client_id = '" . $client_id . "' ORDER BY link_title";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$links_html .= $LINKS_NOLINKS;
	} 
	else {
	
		while ( $row = $db_f($retid) ) {
			$link_title = $row[ "link_title" ];
			$link_title = stripslashes($link_title);
			$link_desc = $row[ "link_desc" ];
			$link_desc = stripslashes($link_desc);
			$link = $row[ "link" ];
			$link_desc_html = nl2br($link_desc);

			$links_html .= "<strong><a href=\"javascript:newWin('http://" . $link . "');\">" . $link_title . "</a></strong><br />\n";
			if ($link_desc != '') {
				$links_html .= $link_desc_html . "<br />\n";
			}
		}
	}
	
	return $links_html;          
}

// GET MESSAGES
function get_messages($client_id, $limit) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );
	
	$client_id = $_SESSION['client_id'];
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
		$message_html = "<h2>" . $MESSAGES_PREVIOUS . " <a href=\"main.php?pg=addmsg\">[ " . $COMMON_ADD . " ]</a> <a href=\"main.php?pg=allmsg\">[ " . $COMMON_VIEWALL . " ]</a></h2>\n";
    	$message_html .= "<table class=\"table\">\n";
    	$message_html .= "<tr class=\"title\">\n";
    	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   		$message_html .= "<td class=\"left\">" . $COL_POSTBY . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   		$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
		$message_html .= "<td>" . $COL_POSTBY . "</td>\n";

    	$message_html .= "</tr>\n";
    
    	$SQL = "SELECT message_id, message_title, posted, post_by FROM ttcm_messages WHERE client_id = '" . $client_id . "' ORDER BY " . $_SESSION['allmessages_oby'] . " " . $_SESSION['allmessages_lby'] . " LIMIT " . $limit;
		$retid = $db_q($db, $SQL, $cid);
		$number = $db_c( $retid );
	
		if ($number == 0) {
	
			$message_html .= "<tr>\n";
      		$message_html .= "<td class=\"left\" colspan=\"4\">" . $MESSAGES_NOPREV . "</td>\n";
    		$message_html .= "</tr>\n";
		}
		else {
	
		while ( $row = $db_f($retid) ) {
			$message_id = $row[ "message_id" ];
			$message_title = $row[ "message_title" ];
			$message_title = stripslashes($message_title);
			$posted = $row[ "posted" ];
			$post_by = $row[ "post_by" ];
			
			$SQL2 = "SELECT DATE_FORMAT('$posted','$_SESSION[date_format] at %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $message_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$posted2 = $row2[ "posted2" ];
			
			$SQL4 = "SELECT * FROM ttcm_comments WHERE message_id = '" . $message_id . "'";
		  	$retid4 = $db_q($db, $SQL4, $cid);

		  	$repnum = $db_c( $retid4 );

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $message_id . "\">" . $message_title . "</a></td>\n";
            $message_html .= "<td>" . $posted2 . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
            $message_html .= "<td>" . $post_by . "</td>\n";
            $message_html .= "</tr>\n";
			}
		}
	$message_html .= "</table>\n";
	
	return $message_html;
}

// GET PROJECT MESSAGES
function get_projmessages($client_id, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
		$message_html = "<h2>" . $MESSAGES_PREVIOUS . " <a href=\"main.php?pg=allmsg\">[ " . $COMMON_VIEWALL . " ]</a></h2>\n";
    	$message_html .= "<table class=\"table\">\n";
    	$message_html .= "<tr class=\"title\">\n";
    	$message_html .= "<td class=\"left\">" . $COL_MESSAGETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;allmessages_oby=message_title&amp;allmessages_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   		$message_html .= "<td class=\"left\">" . $COL_POSTBY . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;allmessages_oby=post_by&amp;allmessages_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   		$message_html .= "<td>" . $COL_REPLIES . "</td>\n";
		$message_html .= "<td>" . $COL_POSTBY . "</td>\n";
    	$message_html .= "</tr>\n";
    
    	$SQL = "SELECT message_id, message_title, posted, post_by FROM ttcm_messages WHERE project_id = '" . $pid . "' AND client_id = '" . $client_id . "' ORDER BY " . $_SESSION['pmessages_oby'] . " " . $_SESSION['pmessages_lby'];
		$retid = $db_q($db, $SQL, $cid);
	
		$number = $db_c( $retid );
	
		if ($number == 0) {
			$message_html .= "<tr>\n";
			$message_html .= "<td class=\"left\" colspan=\"4\">" . $MESSAGES_NOPREV . "</td>\n";
    		$message_html .= "</tr>\n";
		}
		else {
	
		while ( $row = $db_f($retid) ) {
			$message_id = $row[ "message_id" ];
			$message_title = $row[ "message_title" ];
			$message_title = stripslashes($message_title);
			$posted = $row[ "posted" ];
			$post_by = $row[ "post_by" ];
			
			$SQL2 = "SELECT DATE_FORMAT('$posted','$_SESSION[date_format] at %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $message_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$posted2 = $row2[ "posted2" ];
			
			$SQL4 = "SELECT * FROM ttcm_comments WHERE message_id = '" . $message_id . "'";
		  	$retid4 = $db_q($db, $SQL4, $cid);
		  	$repnum = $db_c( $retid4 );

			$message_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $message_html .= "<td class=\"left\"><a href=\"main.php?pg=readmsg&amp;mid=" . $message_id . "\">" . $message_title . "</a></td>\n";
            $message_html .= "<td class=\"left\">" . $posted2 . "</td>\n";
			$message_html .= "<td>" . $repnum . "</td>\n";
            $message_html .= "<td>" . $post_by . "</td>\n";
            $message_html .= "</tr>\n";
			}
		}
		$message_html .= "</table>\n";
	
	return $message_html;
}

// READ MESSAGE
function view_message($client_id, $mid) {

	global $cid, $db_q, $db_c, $db_f, $db;
    
    include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
    $SQL = "SELECT message_title, message, posted, post_by, replies FROM ttcm_messages WHERE message_id = '" . $mid . "' AND client_id = '" . $client_id . "' ";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	$message_html = '';
	
	if ($number == 0) {
		$message_html .= " <br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\">   " . $MESSAGES_INVALID . "</div>\n";
	} 
	else {
	
		$row = $db_f($retid);
		$message_title = $row[ "message_title" ];
		$message_title = stripslashes($message_title);
		$message = $row[ "message" ];
		$message = stripslashes($message);
		$posted = $row[ "posted" ];
		$post_by = $row[ "post_by" ];
		$replies = $row[ "replies" ];
		$message_br = nl2br($message);
			
		$SQL2 = "SELECT DATE_FORMAT('$posted','%W, %M %D, %Y at %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $mid . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$posted2 = $row2[ "posted2" ];

        $message_html .= "<p class=\"message-title\">" . $message_title . "</p>\n";
		$message_html .= "<p class=\"message-date\">" . $posted2 . "</p>\n";
		$message_html .= "<p class=\"message-by\"><em>" . $MESSAGES_POSTBY . " : " . $post_by . "</em></p>\n";
        $message_html .= "<p class=\"message-box\">" . $message_br . "</p>\n";
     	
		$SQL4 = "SELECT comment_id, comment, posted, post_by FROM ttcm_comments WHERE message_id = '" . $mid . "' ORDER BY posted ASC";
		$retid4 = $db_q($db, $SQL4, $cid);
		
		$number4 = $db_c( $retid4 );
		$shade = '0';
		
		if ($number4 == 0) {
        	$message_html .= "<p class=\"message-date\">" . $MESSAGE_REPLIES . "</p>\n";
			$message_html .= "<p>" . $MESSAGE_NOREPLIES . "</p>";
		} 
		else {
		
			while ( $row4 = $db_f($retid4) ) {
				$comment_id = $row4[ "comment_id" ];
				$comment = $row4[ "comment" ];
				$comment = stripslashes($comment);
				$cposted = $row4[ "posted" ];
				$cpost_by = $row4[ "post_by" ];
				$comment_br = nl2br($comment);
			
				$SQL5 = "SELECT DATE_FORMAT('$cposted','%W, %M %D, %Y at %l:%i %p') AS cposted2 FROM ttcm_comments WHERE message_id = '" . $mid . "'";
				$retid5 = $db_q($db, $SQL5, $cid);
				$row5 = $db_f($retid5);
				$cposted2 = $row5[ "cposted2" ];
			
				if ( $shade == '0' ) { 
					$mbox = "message-box-shaded"; 
				}
				else { 
					$mbox = "message-box"; 
				}

				$message_html .= "<p class=\"message-date\">" . $cposted2 . "</p>\n";
				$message_html .= "<p class=\"message-by\"><em>" . $MESSAGES_POSTBY . " : " . $cpost_by . "</em></p>\n";
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
		if (in_array("80", $user_perms)) {
			$ftype = "quickreply";
			include( "includes/forms.php" );
		}
	}
	return $message_html;
}

// READ MESSAGE OUTSIDE LOGIN
function read_message($mid, $id, $vid, $lang, $date_format, $serverdiff) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $lang . "/c_common.php" );
	include( "lang/" . $lang . "/c_messages.php" );
	
	$message_html = '';
    
    $SQL = "SELECT message_title, message, client_id, posted, post_by, replies FROM ttcm_messages WHERE message_id = '" . $mid . "' AND verify_id = '" . $vid . "'";
	$retid = $db_q($db, $SQL, $cid);
	
	$number = $db_c( $retid );
	
	if ($number == 0) {
		$message_html .= " <br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\">   " . $MESSAGES_INVALID . "</div>\n";
	} 
	else {
	
		$row = $db_f($retid);
		$message_title = $row[ "message_title" ];
		$message_title = stripslashes($message_title);
		$message = $row[ "message" ];
		$message = stripslashes($message);
		$client_id = $row[ "client_id" ];
		$posted = $row[ "posted" ];
		$post_by = $row[ "post_by" ];
		$replies = $row[ "replies" ];
		$message_br = nl2br($message);
			
		$SQL2 = "SELECT DATE_FORMAT('$posted','%W, %M %D, %Y at %l:%i %p') AS posted2 FROM ttcm_messages WHERE message_id = '" . $mid . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$posted2 = $row2[ "posted2" ];
		
		$message_html .= "<p class=\"message-title\">" . $message_title . "</p>\n";
		$message_html .= "<p class=\"message-date\">" . $posted2 . "</p>\n";
		$message_html .= "<p class=\"message-by\"><em>" . $MESSAGES_POSTBY . " : " . $post_by . "</em></p>\n";
        $message_html .= "<p class=\"message-box\">$message_br</p>\n";
     	
		$SQL4 = "SELECT comment_id, comment, posted, post_by FROM ttcm_comments WHERE message_id = '" . $mid . "' ORDER BY posted ASC";
		$retid4 = $db_q($db, $SQL4, $cid);
		$number4 = $db_c( $retid4 );
		
		if ($number4 == 0) {
         	$message_html .= "<p class=\"message-date\">" . $MESSAGE_REPLIES . "</p>\n";
			$message_html .= "<p>" . $MESSAGE_NOREPLIES . "</p>";
		} 
		else {
			while ( $row4 = $db_f($retid4) ) {
				$comment_id = $row4[ "comment_id" ];
				$comment = $row4[ "comment" ];
				$comment = stripslashes($comment);
				$cposted = $row4[ "posted" ];
				$cpost_by = $row4[ "post_by" ];
				$comment_br = nl2br($comment);
			
				$SQL5 = "SELECT DATE_FORMAT('$cposted','%W, %M %D, %Y at %l:%i %p') AS cposted2 FROM ttcm_comments WHERE message_id = '" . $mid . "'";
				$retid5 = $db_q($db, $SQL5, $cid);
				$row5 = $db_f($retid5);
				$cposted2 = $row5[ "cposted2" ];

				$message_html .= "<p class=\"message-date\">" . $cposted2 . "</p>\n";
				$message_html .= "<p class=\"message-by\"><em>" . $MESSAGES_POSTBY . " : " . $cpost_by . "</em></p>\n";
	        	$message_html .= "<p class=\"message-box\">" . $comment_br . "</p>\n";

			}
		}
		
		// PULL USER DATA FROM DATABASE
		$query2 = " SELECT permissions, name FROM ttcm_user WHERE id = '" . $id . "' ";
		$retid2 = $db_q($db, $query2, $cid);
		$row2 = $db_f($retid2);
		$user_permissions = $row2[ "permissions" ];
		$user_perms = split(',', $user_permissions);

		// check if user has Message permissions
		if ( (in_array("80", $user_perms)) || (in_array("11", $user_perms)) ) {
			$ftype = "extquickreply";
			include( "includes/forms.php" );
		}
	}
	return $message_html;
}

// GET PROJECT TASKS
function project_tasks($client_id, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$task_html = "<h2>" . $TASKS_PROJTASKS . "</h2>\n";
    $task_html .= "<table class=\"table\">\n";
    $task_html .= "<tr class=\"title\">\n";
    $task_html .= "<td class=\"left\">" . $COL_TASKTITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=title&amp;tasks_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=title&amp;tasks_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$task_html .= "<td>" . $COL_STATUS . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=status&amp;tasks_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=status&amp;tasks_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$task_html .= "<td>" . $COL_UPDATED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=updated&amp;tasks_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=updated&amp;tasks_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$task_html .= "<td>" . $COL_MILESTONE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=milestone&amp;tasks_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;tasks_oby=milestone&amp;tasks_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
    $task_html .= "</tr>\n";
                    
    $SQL = "SELECT task_id, title, updated, status, finish, milestone FROM ttcm_task WHERE project_id = '" . $pid . "' AND client_id = '" . $client_id . "' ORDER BY " . $_SESSION['tasks_oby'] . " " . $_SESSION['tasks_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
	
	if ( $number == '0' ) {
		$task_html .= "<tr>\n";
        $task_html .= "<td class=\"left\" colspan=\"4\">" . $TASKS_NOTASKS . "</td>\n";
        $task_html .= "</tr>\n";
    } 
	else {
    
		while ( $row = $db_f($retid) ) {
			$task_id = $row[ "task_id" ];
			$task_title = $row[ "title" ];
			$task_title = stripslashes($task_title);
			$task_updated = $row[ "updated" ];
			$task_status = $row[ "status" ];
			$task_finish = $row[ "finish" ];
			$milestone = $row[ "data limite" ];
			
			$SQL2 = "SELECT DATE_FORMAT('$milestone','$_SESSION[date_format]') AS task_milestone2, DATE_FORMAT('$task_updated','$_SESSION[date_format] at %l:%i %p') AS task_update2 FROM ttcm_task WHERE task_id = '" . $task_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$task_milestones2 = $row2[ "task_milestone2" ];
			$task_updated2 = $row2[ "task_update2" ];

			$task_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
        	$task_html .= "<td class=\"left\"><a href=\"javascript:popUp('task.php?pid=" . $pid . "&amp;tid=" . $task_id . "');\">" . $task_title . "</a></td>\n";
        	$task_html .= "<td>" . $task_status . "</td>\n";
        	$task_html .= "<td>" . $task_updated2 . "</td>\n";
        	$task_html .= "<td>" . $task_milestones2 . "</td>\n";
        	$task_html .= "</tr>\n";
     	}
    } 
	$task_html .= "</table>\n";

	return $task_html;
}

// GET PROJECT DATA
function project_data($client_id, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$SQL = "SELECT title, description FROM ttcm_project WHERE project_id = '" . $pid . "' AND client_id = '" . $client_id . "'";
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			 
	if ( $number == '0' ) {
		$project = " <br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\">   " . $COMMON_INVALID . "</div>";
		return $project;
	} 
	else {

		$row = $db_f($retid);
		$project_title = $row[ "title" ];
		$project_title = stripslashes($project_title);
		$description = $row[ "description" ];
		$description = stripslashes($description);
		$description_html = nl2br($description);
		
		$project_html = "<h1>" . $PROJECTS_HEADER . ": " . $project_title . "</h1>\n";
        $project_html .= "<h3>" . $PROJECT_DESCRIPTION . "</h3>\n";
        $project_html .= "<p>" . $description_html . "</p>\n";
        
        $messages = get_projmessages("$client_id", "$pid");

        $project_html .= "<p>" . $messages . "</p>";

		$tasks = project_tasks("$client_id", "$pid");
       	
        $project_html .= "<p>" . $tasks . "</p>";

		$todo = todo_list("$client_id", "$pid");
		$project_html .= "<p>" . $todo . "</p>";
        
		if ( $_SESSION['files_active'] != '0') {
       		$files = getproject_files("$client_id", "$pid");
        	$project_html .= $files;
        }
        return $project_html;
	}	
}

// GET SMALL PROJECT DATA
function projectsm_data($client_id, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db, $currency;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$SQL = "SELECT start, finish, status, updated, cost, milestone FROM ttcm_project WHERE project_id = '" . $pid . "' AND client_id = '" . $client_id . "'";
	$retid = $db_q($db, $SQL, $cid);
			 
	$number = $db_c( $retid );

		$row = $db_f($retid);
		$start = $row[ "start" ];
		$finish = $row[ "finish" ];
		$status = $row[ "status" ];
		$updated = $row[ "updated" ];
		$cost = $row[ "cost" ];
		$project_milestone = $row[ "milestone" ];
			
		$SQL2 = "SELECT DATE_FORMAT('$project_milestone','$_SESSION[date_format]') AS milestone2, DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$updated','$_SESSION[date_format] at %l:%i %p') AS update2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_project WHERE project_id = '" . $pid . "'";
		$retid2 = $db_q($db, $SQL2, $cid);
		$row2 = $db_f($retid2);
		$started2 = $row2[ "start2" ];
		$finished2 = $row2[ "finish2" ];
		$milestones2 = $row2[ "milestone2" ];
		$updated2 = $row2[ "update2" ];
		
        $projectsm_html .= "<h3>" . $PROJECT_STATUS . "</h3>\n";
        $projectsm_html .= "<p><strong>" . $status . "</strong></p>\n";
        $projectsm_html .= "<h3>" . $PROJECT_QUOTE . "</h3>\n";
        $projectsm_html .= "<p>" . $currency . $cost . "</p>\n";
        $projectsm_html .= "<h3>" . $PROJECT_BEGAN . "</h3>\n";
        $projectsm_html .= "<p>" . $started2 . "</p>\n";
        $projectsm_html .= "<h3>" . $PROJECT_UPDATED . "</h3>\n";
        $projectsm_html .= "<p>" . $updated2 . "</p>\n";
        $projectsm_html .= "<h3>" . $PROJECT_MILESTONE . "</h3>\n";
        $projectsm_html .= "<p>" . $milestones2 . "</p>\n";
        $projectsm_html .= "<h3>" . $PROJECT_FINISH . "</h3>\n";
        
        if ( $finish == '0000-00-00' ) { 
        	$projectsm_html .= "<p></p>\n";
        } 
		else {
        	$projectsm_html .= "<p>" . $finished2 . "</p>\n";
        }
	return $projectsm_html;	
}

// GET PROJECT FILES
function getproject_files($client_id, $pid) {

	global $cid, $db_q, $db_c, $db_f, $db, $web_path;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);
	
	$files_html = "<h2>" . $DOWNLOADS_PROJFILES . "</h2>\n";
    $files_html .= "<table class=\"table\">\n";
    $files_html .= "<tr class=\"title\">\n";
    $files_html .= "<td class=\"left\">" . $COL_FILETITLE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=name&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=name&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td class=\"left\">" . $COL_FILETYPE . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=type_id&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=type_id&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";
   	$files_html .= "<td>" . $COL_PROJTITLE . "</td>\n";
   	$files_html .= "<td>" . $COL_ADDED . " <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;pid=" . $_GET['pid'] . "&amp;files_oby=added&amp;files_lby=ASC\"><img src=\"images/asc.gif\" width=\"10\" height=\"10\" border=\"0\"></a> <a href=\"main.php?pg=" . $_GET['pg'] . "&amp;clid=" . $clid . "&amp;pid=" . $pid . "&amp;files_oby=added&amp;files_lby=DESC\"><img src=\"images/desc.gif\" width=\"10\" height=\"10\" border=\"0\"></a></td>\n";

    $files_html .= "</tr>\n";
            
    $SQL = "SELECT file_id, type_id, project_id, name, link, added FROM ttcm_files WHERE project_id = '" . $pid . "' AND client_id = '" . $client_id . "' ORDER BY " . $_SESSION['files_oby'] . " " . $_SESSION['files_lby'];
	$retid = $db_q($db, $SQL, $cid);
	$number = $db_c( $retid );
			
	if ( $number == '0' ) {
		$files_html .= "<tr>\n";
        $files_html .= "<td class=\"left\" colspan=\"4\">" . $DOWNLOADS_NOFILES . "</td>\n";
        $files_html .= "</tr>\n";
    } 
	else {
		while ( $row = $db_f($retid) ) {
			$file_id = $row[ "file_id" ];
			$type_id = $row[ "type_id" ];
			$project_id = $row[ "project_id" ];
			$file = $row[ "name" ];
			$file = stripslashes($file);
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
			
			$SQL2 = "SELECT DATE_FORMAT('$added','$_SESSION[date_format]') AS added2 FROM ttcm_files WHERE file_id = '" . $file_id . "'";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$added2 = $row2[ "added2" ];
			
			$SQL3 = "SELECT file_type FROM ttcm_filetype WHERE type_id = '" . $type_id . "' ";
			$retid3 = $db_q($db, $SQL3, $cid);
			$row3 = $db_f($retid3);
			$file_type = $row3[ "file_type" ];
			
			$SQL4 = "SELECT title FROM ttcm_project WHERE project_id = '" . $project_id . "' ";
			$retid4 = $db_q($db, $SQL4, $cid);
			$row4 = $db_f($retid4);
			$project_title = $row4[ "title" ];
			$project_title = stripslashes($project_title);

			$files_html .= "<tr onmouseover=\"style.backgroundColor='" . $_SESSION['overcolor'] . "';\" onmouseout=\"style.backgroundColor='" . $_SESSION['outcolor'] . "'\">\n";
            $files_html .= "<td class=\"left\"><a href=\"javascript:newWin('" . $file_link . "');\">" . $file . "</td>\n";
            $files_html .= "<td class=\"left\">" . $file_type . "</td>\n";
            $files_html .= "<td>" . $project_title . "</td>\n";
            $files_html .= "<td>" . $added2 . "</td>\n";
            $files_html .= "</tr>\n";
		}
	}
	$files_html .= "</table>\n";
	
	return $files_html;
}

// GET TASK INFO
function task_info($client_id, $tid) {

	global $cid, $db_q, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$SQL = "SELECT title, description, start, updated, finish, status, notes, milestone FROM ttcm_task WHERE task_id = '" . $tid . "' AND client_id = '" . $client_id . "' ";
	$retid = $db_q($db, $SQL, $cid);
	
	$row = $db_f($retid);
	$task_title = $row[ "title" ];
	$task_title = stripslashes($task_title);
	$description = $row[ "description" ];
	$description = stripslashes($description);
	$start = $row[ "start" ];
	$updated = $row[ "updated" ];
	$finish = $row[ "finish" ];
	$status = $row[ "status" ];
	$notes = $row[ "notes" ];
	$notes = stripslashes($notes);
	$milestone = $row[ "data limite" ];
	$description_html = nl2br($description);
	$notes_html = nl2br($notes);
			
	$SQL2 = "SELECT DATE_FORMAT('$milestone','$_SESSION[date_format]') AS milestone2, DATE_FORMAT('$finish','$_SESSION[date_format]') AS finish2, DATE_FORMAT('$updated','$_SESSION[date_format] at %l:%i %p') AS update2, DATE_FORMAT('$start','$_SESSION[date_format]') AS start2 FROM ttcm_task WHERE task_id = '" . $tid . "'";
	$retid2 = $db_q($db, $SQL2, $cid);
	$row2 = $db_f($retid2);
	$started2 = $row2[ "start2" ];
	$finished2 = $row2[ "finish2" ];
	$milestones2 = $row2[ "milestone2" ];
	$updated2 = $row2[ "update2" ];
	
	$task_html = "<div id=\"taskcol\">\n";
  	$task_html .= "<div id=\"taskhead\">" . $task_title . "</div>\n";
  	$task_html .= "<div id=\"taskdata\">\n";
    $task_html .= "<h3>" . $TASKS_DESCRIPTION . "</h3>\n";
    $task_html .= "<p>" . $description_html . "</p>\n";
    $task_html .= "<h3>" . $TASKS_STATUS . "</h3>\n";
    $task_html .= "<p>" . $status . "</p>\n";
    $task_html .= "<h3>" . $TASKS_START . "</h3>\n";
    $task_html .= "<p>" . $started2 . "</p>\n";
    $task_html .= "<h3>" . $TASKS_UPDATED . "</h3>\n";
    $task_html .= "<p>" . $updated2 . "</p>\n";
    $task_html .= "<h3>" . $TASKS_MILESTONE . "</h3>\n";
    $task_html .= "<p>" . $milestones2 . "</p>\n";
    $task_html .= "<h3>" . $TASKS_FINISH . "</h3>\n";
    if ( $finish == '0000-00-00' ) {
    	$task_html .= "<p>NA</p>";
    } 
	else {
    	$task_html .= "<p>" . $finished2 . "</p>";
    }
    $task_html .= "<h3>" . $TASKS_NOTES . "</h3>\n";
    $task_html .= "<p>" . $notes_html . "</p>\n";
	$task_html .= "</div>";
	$task_html .= "</div>";
	$task_html .= "</div>";
	
	return $task_html;
}

// GET HELP TOPIC
function help_topic($tid) {

	global $cid, $db_q, $db_f, $db;
	
	include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
	include( "lang/" . $_SESSION['lang'] . "/c_helpsection.php" );
	
	$get_perm_vars = $_SESSION['perm_vars'];
	$user_perms = split(',', $get_perm_vars);

	$query = "SELECT cat_id, topic, description, views FROM ttcm_topics WHERE topic_id = '" . $tid . "' ";
	$retid = $db_q($db, $query, $cid);

	$row = $db_f($retid);
	$cat_id = $row[ "cat_id" ];
	$topic = $row[ "topic" ];
	$topic = stripslashes($topic);
	$description = $row[ "description" ];
	$description = stripslashes($description);
	$viewed = $row[ "views" ];
	$description_html = nl2br($description);
		
	$query2 = "SELECT category FROM ttcm_helpcat WHERE cat_id = '" . $cat_id . "' ";
	$retid2 = $db_q($db, $query2, $cid);
	$row2 = $db_f($retid2);
	$category = $row2[ "category" ];
	$category = stripslashes($category);

	$viewed++;
	
	// UPDATE VIEWED
	$update = " UPDATE ttcm_topics SET views = '" . $viewed . "' WHERE topic_id = '" . $tid . "' ";
	$result_2 = $db_q($db,"$update",$cid);

    $topic_html = "<h1>" . $topic . "</h1>\n";
    $topic_html .= "<h3><a href=\"main.php?pg=help\">" . $HELP_HEADER . "</a> - " . $category . "</h3>\n";
    $topic_html .= "<p>" . $description_html . "</p>\n";
    
    return $topic_html;
}
?>