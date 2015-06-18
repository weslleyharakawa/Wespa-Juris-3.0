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

// Check if Messages section active
if ($_SESSION['messages_active'] == '0') { 
	echo("$COMMON_NOTACTIVE</p>");
}
else {

	echo("<h1>$ADDMESSAGE_HEADER</h1>");
	include( "includes/client.tasks.php" );
			
	// check if user has Message permissions
	if (in_array("79", $user_perms)) {
		$ftype = "addmessage";
		include( "includes/forms.php" );
	}
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>