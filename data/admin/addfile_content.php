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

// Check if Files section active
if ($_SESSION['files_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
else {
	
	echo("<h1>$ADDFILE_HEADER</h1>
	<p>$ADDFILE_MAINTEXT</p>");

	// check if user has File permissions
	if (in_array("22", $user_perms)) {
					
		if ( ( $_POST['from'] == 'step1' ) || ( $_POST['from'] == 'step2' ) ) {
			include ("includes/admin.tasks.php");
			if ( $showform != '0' ) {
				$ftype = "addfile";
				include ("includes/forms.php");
			}
		}
		else {
			echo ("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_INVALID.</div>");
			echo ("<p>$ADDFILE_STARTON <a href=\"?pg=addfiles\" title=\"$COMMON_THISPAGE\">$COMMON_THISPAGE</a>.</p>");
		}
	} 
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	} 
}
?>