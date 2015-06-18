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
include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$client_id = $_SESSION['client_id'];

// check if user has Status da Conta permissions
if (in_array("77", $user_perms)) {
	$acct_status = get_client_status($client_id);
	echo ($acct_status);
}
		
if ($_SESSION['projects_active'] != '0') {
	
	// check if user has Project permissions
	if (in_array("73", $user_perms)) {
		
		$psearch_html = searchbox(project, $PROJECTS_HEADER, $PROJECTS_INSTRUCT);
		echo ("<p>$psearch_html</p>");
	}
}
if ($_SESSION['files_active'] != '0') {

	// check if user has Downloads permissions
	if (in_array("83", $user_perms)) {
		
		$dsearch_html = searchbox(download, $DOWNLOADS_HEADER, $DOWNLOADS_INSTRUCT);
		echo ("<p>$dsearch_html</p>");
	}
}
if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {

	// check if user has Basic Invoice permissions
	if (in_array("89", $user_perms)) {

		$isearch_html = searchbox(invoice, $INVOICES_HEADER, $INVOICES_INSTRUCT);
		echo ("<p>$isearch_html</p>");
	}
}
?>