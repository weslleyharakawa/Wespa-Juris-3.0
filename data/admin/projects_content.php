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

if ($_GET['clid']) {
	$clid = $_GET['clid'];
}
else if ($_POST['clid']) {
	$clid = $_POST['clid'];
}
else  {
	$clid = '0';
}

// Check if Messages section active
if ($_SESSION['projects_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
else {
	
	$for_client = cproject_selected("$clid");
	echo ("<p>$for_client</p>");
	echo ("<p>$PROJECTS_MAINTEXT</p>");
				  
	// check if user has Project permissions
	if (in_array("1", $user_perms)) {
					
		$active_list = active_projects("$clid");
		echo ("<p>$active_list</p>");
		$last_ten = ten_projects("$clid");
		echo ("<p>$last_ten</p>");
	} 
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>