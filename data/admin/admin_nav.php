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
include("../lang/" . $lang . "/a_navigation.php" );

		echo ("<li><a href=\"?pg=main\" title=\"" . $MNAV_HOME . "\">" . $MNAV_HOME . "</a></li>");
		
		if (in_array("8", $user_perms)) {
			echo("<li><a href=\"?pg=settings\" title=\"" . $MNAV_SETTINGS . "\">" . $MNAV_SETTINGS . "</a></li>");
		}
		if ($_SESSION['messages_active'] == '1') {
			if (in_array("9", $user_perms)) {
				echo("<li><a href=\"?pg=msg\" title=\"" . $MNAV_MESSAGES . "\">" . $MNAV_MESSAGES . "</a></li>");
			}
		}
		if ($_SESSION['clients_active'] == '1') {
			if (in_array("14", $user_perms)) {
				echo("<li><a href=\"?pg=clients\" title=\"" . $MNAV_CLIENTS . "\">" . $MNAV_CLIENTS . "</a></li>");
			}
		}
		if ($_SESSION['projects_active'] == '1') {
			if (in_array("1", $user_perms)) {
				echo("<li><a href=\"?pg=projects\" title=\"" . $MNAV_PROJECTS . "\">" . $MNAV_PROJECTS . "</a></li>");
			}
		}
		if ( ($_SESSION["mod1_installed"] == '1') && ($_SESSION["mod1_active"] == '1') ) {
			if (in_array("69", $user_perms)) {
				echo("<li><a href=\"?pg=binvoices\" title=\"" . $MNAV_INVOICES . "\">" . $MNAV_INVOICES . "</a></li>");
			}
		}
		if ( ($_SESSION["mod2_installed"] == '1') && ($_SESSION["mod2_active"] == '1') ) {
			if (in_array("69", $user_perms)) {
				echo("<li><a href=\"?pg=ginvoices\" title=\"" . $MNAV_INVOICES . "\">" . $MNAV_INVOICES . "</a></li>");
			}
		}
		if ( ($_SESSION["mod3_installed"] == '1') && ($_SESSION["mod3_active"] == '1') ) {
			echo("<li><a href=\"?pg=tickets\" title=\"" . $MNAV_TICKET . "\">" . $MNAV_TICKET . "</a></li>");
		}
		if ( ($_SESSION["mod4_installed"] == '1') && ($_SESSION["mod4_active"] == '1') ) {
			if (in_array("104", $user_perms)) {
				echo("<li><a href=\"?pg=webhosts\" title=\"" . $MNAV_HOSTING . "\">" . $MNAV_HOSTING . "</a></li>");
			}
		}
		if ($_SESSION['files_active'] == '1') {
			if (in_array("21", $user_perms)) {
				echo("<li><a href=\"?pg=files\" title=\"" . $MNAV_FILEMANAGEMENT . "\">" . $MNAV_FILEMANAGEMENT . "</a></li>");
			}
		}
		if ($_SESSION['help_active'] == '1') {
			if (in_array("62", $user_perms)) {
				echo("<li><a href=\"?pg=help\" title=\"" . $MNAV_HELP . "\">" . $MNAV_HELP . "</a></li>");
			}
		}
	
		echo ("<li><a href=\"logout.php\" title=\"" . $MNAV_LOGOUT . "\">" . $MNAV_LOGOUT . "</a></li>");
?>