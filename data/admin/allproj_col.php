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
include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Projects section active
if ($_SESSION['project_active'] != '0') {
	
		$client_id = $_GET['client_id'];
		
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {
			$pclient_html = choose_cproject($client_id = '');
     		echo ("<p>$pclient_html</p>");
			$psearch_html = searchbox(project, $SEARCH_PROJECT, $SEARCH_PROJECTINSTRUCT);
     		echo ("<p>$psearch_html</p>");
		}
}
?>