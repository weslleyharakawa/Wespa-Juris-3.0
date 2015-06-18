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

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

$admin_info = get_admin_info(1);
echo($admin_info);

// check if user has Website permissions
if (in_array("31", $user_perms)) {
	$admin_websites = show_websites(0);
	echo($admin_websites); 
}
echo ("<h3>$COMMON_MODIFY</h3>");

// check if user has Admin permissions
if (in_array("7", $user_perms)) {
	echo("<p><a href=\"main.php?pg=editadmin\" title=\"" . $SIDE_EDITADMIN . "\">" . $SIDE_EDITADMIN . "</a></p>
	<p><a href=\"main.php?pg=usermod\" title=\"editar seus dados\">editar seus dados</a></p>");
}
echo ("<a href=\"main.php?pg=changepw\" title=\"" . $SIDE_CHANGEPW . "\">" . $SIDE_CHANGEPW . "</a></p>");
?>