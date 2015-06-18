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
include( "../lang/" . $_SESSION['lang'] . "/a_filemanagement.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Clients section active
if ($_SESSION['clients_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
else {
	
	$clid = $_GET['clid'];
	
	include ("includes/admin.tasks.php");
	
	// Check if Web Hosting section active
	if ( ($_SESSION["mod4_installed"] != '0') && ($_SESSION["mod4_active"] != '0') ) {
		include ("../modules/webhosting/includes/whost.tasks.php");
	}
	
	$client_company = company_name("$clid");
	echo ("<h1>$COMMON_CLIENT: $client_company</h1>");

	// check if user has Project permissions
	if (in_array("1", $user_perms)) {
					
		$active_proj = active_projects("$clid");
		echo ("<p>$active_proj</p>");
	}
	// check if user has Message permissions
	if (in_array("9", $user_perms)) {
		$messages = get_clmessages("$clid");
		echo ("<p>$messages</p>");
	}
	// check if user has Note permissions
	if (in_array("18", $user_perms)) {
		$notes = client_notes("$clid","$pid");
		echo ("<p>$notes</p>");
	}
	// check if user has File permissions
	if (in_array("21", $user_perms)) {
		$cfiles = client_files("$clid");
		echo ("<p>$cfiles</p>");
	}
	// check if user has User permissions
	if (in_array("25", $user_perms)) {
		$cusers = client_users("$clid");
		echo ("<p>$cusers</p>");
	}

// Check if Web Hosting section active
if ( ($_SESSION["mod4_installed"] != '0') && ($_SESSION["mod4_active"] != '0') ) {
		$chosting = client_hosting("$clid");
		echo ("<p>" . $chosting . "</p>");
		$cdomains = client_domains("$clid");
		echo ("<p>" . $cdomains . "</p>");
	}
}
?>