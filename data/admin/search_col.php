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
include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

	if ($_SESSION['projects_active'] != '0') {
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {

			$psearch_html = searchbox(project, $SEARCH_PROJECT, $SEARCH_PROJECTINSTRUCT);
  			echo ("<p>$psearch_html</p>");
		}
  	}
   if ($_SESSION['files_active'] != '0') {
		// check if user has File permissions
		if (in_array("21", $user_perms)) {
			
			$dsearch_html = searchbox(download, $SEARCH_DOWNLOAD, $SEARCH_DOWNLOADINSTRUCT);
  			echo ("<p>$dsearch_html</p>");
		}
  	}
  	if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {
		// check if user has Basic Invoice permissions
		if (in_array("69", $user_perms)) {
			$isearch_html = searchbox(invoice, $SEARCH_INVOICE, $SEARCH_INVOICEINSTRUCT);
  			echo ("<p>$isearch_html</p>");
		}
	}
  	if ($_SESSION['clients_active'] != '0') {
		// check if user has Client permissions
		if (in_array("", $user_perms)) {
			$csearch_html = searchbox(client, $SEARCH_CLIENT, $SEARCH_CLIENTINSTRUCT);
  			echo ("<p>$csearch_html</p>");
		}
		// check if user has User permissions
		if (in_array("25", $user_perms)) {
			$usearch_html = searchbox(user, $SEARCH_USER, $SEARCH_USERINSTRUCT);
  			echo ("<p>$usearch_html</p>");
		}
	}
?>