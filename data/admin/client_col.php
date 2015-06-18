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
include( "../lang/" . $_SESSION['lang'] . "/a_client.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Client section active
if ($_SESSION['clients_active'] != '0') { 
	
	$clid = $_GET['clid'];
	
	include ("includes/admin.tasks.php");
		
		if (in_array("41", $user_perms)) {
			$ftype = 'clientstatus';
			include ("includes/forms.php"); 
		}
		// check if user has User permissions
		if (in_array("29", $user_perms)) {
			$cinfo = client_info("$clid");
			echo ("<p>$cinfo</p>");
		}
		// check if user has Website permissions
		if (in_array("31", $user_perms)) {
			$cwebs = show_websites("$clid");
			echo ("<p>$cwebs</p>");
		}
		// check if user has Logo permissions
		if (in_array("34", $user_perms)) {
			$clogo = client_logo("$clid");
			echo ("<p>$clogo</p>");
		}
		// check if user has Link permissions
		if (in_array("36", $user_perms)) {
			$clinks = client_links("$clid");
			echo ("<p>$clinks</p>");
		}
		// check if user has Upload permissions
		if (in_array("39", $user_perms)) {
			$ulfiles = uploaded_files("$clid");
			echo ("<p>$ulfiles</p>"); 
		}
}
?>