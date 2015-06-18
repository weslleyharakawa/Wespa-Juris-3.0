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
include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
include( "lang/" . $_SESSION['lang'] . "/c_messages.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$client_id = $_SESSION['client_id'];

// Check if Messages section active
if ($_SESSION['projects_active'] == '0') { 
	echo("$COMMON_NOTACTIVE</p>");
}
else {

	echo("<h1>$ALL_PROJECTS_HEADER</h1>
    <p>$ALL_PROJECTS_MAINTEXT</p>");
	
	// check if user has Project permissions
	if (in_array("73", $user_perms)) {
		$project_html = get_projects("$client_id", 0);
    	echo ($project_html); 
	}
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>