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

echo("<h1>$EDITCLIENT_HEADER</h1>");
			  
// check if user has Client permissions
if (in_array("16", $user_perms)) {
					
	include ("includes/admin.tasks.php");
	if ( $showform != '0' ) {
		$ftype = "editclient";
		include ("includes/forms.php"); 
	}
}
else {
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
}
?>