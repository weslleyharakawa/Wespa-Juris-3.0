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
include( "includes/admin.main.functions.php" );
include( "includes/admin.adv.functions.php" );

if ($_SESSION["mod1_installed"] != '0') {
	include ("../modules/basic_invoice/includes/admin.inv.functions.php");
}
if ($_SESSION["mod4_installed"] != '0') {
	include ("../modules/webhosting/includes/admin.whost.functions.php");
}
?>