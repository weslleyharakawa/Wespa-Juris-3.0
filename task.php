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
session_start();

require( "includes/config.php" );
require( "includes/functions.php" );
require( "includes/sessions.php" );
include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
include( "lang/" . $_SESSION['lang'] . "/c_projects.php" );
include( "includes/client.template_titles.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$TITLE_TASK?></title>
<script language="JavaScript" src="includes/standard.js"></script>
<link rel="stylesheet" type="text/css" href="includes/styles.css" />
</head>
<body>

<?php 
$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$client_id = $_SESSION['client_id'];
$tid = $_GET['tid'];

// check if user has Task permissions
if (in_array("82", $user_perms)) {

	$pull_tasks = task_info("$client_id", "$tid");
	echo ($pull_tasks);
}
else {
	echo $COMMON_NOPERMISSION;
} ?>
	
</body>
</html>
