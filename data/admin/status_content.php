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
include( "../lang/" . $_SESSION['lang'] . "/a_settings.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

echo("<h1>$STATUS_HEADER</h1>
<p>$STATUS_MAINTEXT</p>");
            
// check if user has Admin permissions
if (in_array("55", $user_perms)) {
					
	include( "includes/admin.tasks.php" );
		
	$show_account = show_options(account, $COMMON_ACCOUNT);
	echo ("<p>$show_account</p>");
		
	$show_project = show_options(project, $COMMON_PROJECT);
	echo ("<p>$show_project</p>");

	if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {
		$show_invoice = show_options(invoice, $COMMON_INVOICE);
		echo ("<p>$show_invoice</p>");
	}
		
	$show_task = show_options(tasks, $COMMON_TASK);
	echo ("<p>$show_task</p>");
} 
else {
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
}
?>