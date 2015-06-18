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

if ($_GET['clid']) {
	$clid = $_GET['clid'];
}
else if ($_POST['clid']) {
	$clid = $_POST['clid'];
}
else  {
	$clid = '0';
}

// Check if Clients section active
if ($_SESSION['clients_active'] == '0') { 
	echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOTACTIVE</div>");
}
else {

	$company = company_name("$clid"); 
	echo ("<h1>$CLOGO_FOR $company</h1>
	<p>$CLOGO_MAINTEXT</p>");
				  
	// check if user has Logo permissions
	if (in_array("35", $user_perms)) {
					
		include( "includes/admin.tasks.php");
		$ftype = "clogo";
		include ("includes/forms.php"); 
	}
	else {
		echo("&nbsp;<br /><div id=\"warning\"><img src=\"../images/warning.gif\" align=\"left\"> &nbsp; $COMMON_NOPERMISSION</div>");
	}
}
?>