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
include( "../lang/" . $_SESSION['lang'] . "/a_messages.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Messages section active
if ($_SESSION['messages_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
else {
	include ("includes/admin.tasks.php" );
	
	$cmessages = cmessages_selected("$clid");
	echo ("<h1>$cmessages</h1>");
	echo("<p>$MESSAGES_MAINTEXT</p>");

	// check if user has Message permissions
	if (in_array("9", $user_perms)) {
		$previous_msgs = get_messages("$clid", 10);
      	echo ("<p>$previous_msgs</p>"); 
	} 
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>