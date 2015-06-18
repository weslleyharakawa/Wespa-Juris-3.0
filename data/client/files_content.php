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

if ($_SESSION['files_active'] == '0') {
    echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE");
}
else {
	echo("<h1>$DOWNLOADS_HEADER</h1>
	<p>$DOWNLOADS_MAINTEXT</p>");

	// check if user has Download permissions
	if (in_array("83", $user_perms)) {
		$pfiles = project_files("$client_id");
		echo ($pfiles);
	}
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>