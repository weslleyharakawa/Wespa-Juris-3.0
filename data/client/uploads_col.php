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
include( "lang/" . $_SESSION['lang'] . "/c_filemanagement.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$client_id = $_SESSION['client_id'];

// GET CLIENT STATUS
// check if user has Status da Conta permissions
if (in_array("77", $user_perms)) {
	$acct_status = get_client_status($client_id);
	echo ($acct_status);
}

// Check if Files section active
if ($_SESSION['uploads_active'] != '0') {
			
	// check if user has Upload permissions
	if (in_array("85", $user_perms)) {
		$cfiles = client_files($client_id);
        echo ($cfiles); 
	}
}
?>