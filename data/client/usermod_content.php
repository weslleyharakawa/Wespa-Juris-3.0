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
include( "lang/" . $_SESSION['lang'] . "/c_userinfo.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$client_id = $_SESSION['client_id'];

echo("<h1>$YINFO_HEADER</h1>
<p>$YINFO_MAINTEXT</p>");

include("includes/client.tasks.php");
if ($showform != '0') {
	$ftype = "modifyy";
	include("includes/forms.php"); 
}
?>