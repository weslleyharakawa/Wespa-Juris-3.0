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
include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
include( "../lang/" . $_SESSION['lang'] . "/a_project.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

if (!$_GET['clid']) {
	$clid = '0';
}
else {
	$clid = $_GET['clid'];
}

global $cid, $db_q, $db_c, $db_f, $db;
$vid = $_SESSION['valid_id'];

$query = "SELECT permissions FROM ttcm_project WHERE project_id = '" . $_GET['pid'] . "' ";
$retid1 = $db_q($db, $query, $cid);
$row1 = $db_f($retid1);
$permissions = $row1[ "permissions" ];
$projperms = split(',', $permissions);

// Check if Projects section active
if ($_SESSION['projects_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
// Check if user has permission to view project
else if (!in_array($vid, $projperms)) { 
	echo("<div id=\"rightcol\">\n
	<div id=\"innerright\">\n
	</div>\n
	</div>\n
	<hr />\n
	<div id=\"leftcol\">\n
	<p>$COMMON_NOPERMISSION</p>\n
	</div>
	<hr />");
}
else {
	
	include ("includes/admin.tasks.php");
			
	// check if user has Project permissions
	if (in_array("1", $user_perms)) {
		
		$clid = $_GET['clid'];
		$pid = $_GET['pid'];
					
		$client_company = company_name("$clid");
			
		$show_project = project_main("$pid", "$clid", "$client_company");
		echo ("<p>$show_project</p>");
				
		// check if user has Message permissions
		if (in_array("9", $user_perms)) {
			$messages = get_projmessages("$clid","$pid");
			echo ("<p>$messages</p>");
		}
		// check if user has Notes permissions
		if (in_array("43", $user_perms)) {
			$notes = client_notes("$clid","$pid");
			echo ("<p>$notes</p>");
		}
		// check if user has To Do permissions
		if (in_array("46", $user_perms)) {
			$show_todo = todo_list("$clid", "$pid");
			echo ("<p>$show_todo</p>");
		}
		// check if user has Tasks permissions
		if (in_array("49", $user_perms)) {
			$show_tasks = tasks_main("$pid", "$clid");
			echo ("<p>$show_tasks</p>");
		}
		// check if user has File permissions
		if (in_array("21", $user_perms)) {
			$show_files = files_main("$pid", "$clid");
			echo ("<p>$show_files</p>");
		}
		// check if user has Client File permissions
		if (in_array("39", $user_perms)) {
			$show_cfiles = cfiles_main("$pid", "$clid");
			echo ("<p>$show_cfiles</p>");
		}
	} 
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	} 
}
?>