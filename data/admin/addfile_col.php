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
include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

// Check if Files section active
if ($_SESSION['files_active'] != '0') { 
	// check if user has File permissions
	if (in_array("22", $user_perms)) {
		echo("<b>$ADDFILE_FILEINFO</b><br>
		$ADDFILE_CHOOSE<p><a href=\"?pg=filetypes\">$SNAV_ADDFILETYPENAV</a>.<p>");
	}
}
?>