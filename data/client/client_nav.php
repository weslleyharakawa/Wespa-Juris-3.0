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

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

$lang = $_SESSION['lang'];
include("lang/" . $lang . "/c_navigation.php" );

echo ("<li><a href=\"?pg=main\" title=\"" . $NAV_HOME . "\">" . $NAV_HOME . "</a></li>");

		if ($_SESSION['messages_active'] == '1') {
			// check if user has Message permissions
			if ( (in_array("78", $user_perms)) OR (in_array("79", $user_perms)) OR (in_array("80", $user_perms)) ) {
				echo("<li><a href=\"?pg=msg\" title=\"" . $NAV_MESSAGES . "\">" . $NAV_MESSAGES . "</a></li>");
			}
		}
		if ($_SESSION['projects_active'] == '1') {
			// check if user has Project permissions
			if ( (in_array("73", $user_perms)) OR (in_array("82", $user_perms)) OR (in_array("83", $user_perms)) ) {
				echo("<li><a href=\"?pg=projects\" title=\"" . $NAV_PROJECTS . "\">" . $NAV_PROJECTS . "</a></li>");
			}
		}
		if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {
			// check if user has Basic Invoice permissions
			if (in_array("89", $user_perms)) {
				echo("<li><a href=\"?pg=binvoices\" title=\"" . $NAV_INVOICES . "\">" . $NAV_INVOICES . "</a></li>");
			}
		}
		if ( ($_SESSION["mod2_installed"] == '1') && ($_SESSION["mod2_active"] == '1') ) {
			echo("<li><a href=\"?pg=ginvoices\" title=\"" . $NAV_INVOICES . "\">" . $NAV_INVOICES . "</a></li>");
		}
		if ( ($_SESSION["mod3_installed"] == '1') && ($_SESSION["mod3_active"] == '1') ) {
			echo("<li><a href=\"?pg=tickets\" title=\"" . $NAV_TICKET . "\">" . $NAV_TICKET . "</a></li>");
		}
		if ( ($_SESSION["mod4_installed"] == '1') && ($_SESSION["mod4_active"] == '1') ) {
			echo("<li><a href=\"?pg=webhosting\" title=\"" . $NAV_HOSTING . "\">" . $NAV_HOSTING . "</a></li>");
		}
		if ($_SESSION['files_active'] == '1') {
			// check if user has Project File permissions
			if (in_array("83", $user_perms)) {
				echo("<li><a href=\"?pg=files\" title=\"" . $NAV_DOWNLOADFILES . "\">" . $NAV_DOWNLOADFILES . "</a></li>");
			}
		}
		if ($_SESSION['upload_active'] == '1') {
			// check if user has Upload permissions
			if ( (in_array("85", $user_perms)) OR (in_array("86", $user_perms)) ) {
				echo("<li><a href=\"?pg=uploads\" title=\"" . $NAV_UPLOADFILES . "\">" . $NAV_UPLOADFILES . "</a></li>");
			}
		}
		if ($_SESSION['help_active'] == '1') {
			// check if user has Help permissions
			if (in_array("87", $user_perms)) {
				echo("<li><a href=\"?pg=help\" title=\"" . $NAV_HELP . "\">" . $NAV_HELP . "</a></li>");
			}
		}
		if (in_array("88", $user_perms)) {
			echo("<li><a href=\"?pg=contact\" title=\"" . $HEADER_CONTACT . "\">" . $HEADER_CONTACT . "</a></li>");
		}
	
echo ("<li><a href=\"logout.php\" title=\"" . $NAV_LOGOUT . "\">" . $NAV_LOGOUT . "</a></li>");
?>