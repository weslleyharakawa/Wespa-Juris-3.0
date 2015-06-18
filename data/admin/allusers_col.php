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
include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Files section active
if ($_SESSION['clients_active'] != '0') { 
	
	// check if user has User permissions
	if (in_array("25", $user_perms)) {
		$usearch_html = searchbox(user, $SEARCH_USER, $SEARCH_USERINSTRUCT);
  		echo ($usearch_html);
  		echo ("<p>"); 
	}
}
?>