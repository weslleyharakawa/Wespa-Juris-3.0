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

echo ("<h1>$COMMON_WELCOME $admin_name</h1>");

	include ("includes/admin.tasks.php");

	if ($_SESSION['projects_active'] != '0') {
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {
			$past_due = pastdue_projects();
      		echo ("<p>$past_due</p>");	
			$active_list = active_projects($clid=0);
         	echo ("<p>$active_list</p>"); 
		}
		else {
			echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
		} 
	} 
?>