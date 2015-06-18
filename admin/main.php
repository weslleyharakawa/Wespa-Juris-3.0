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

if ( (!$_SESSION["valid_user"]) OR (!$_SESSION["valid_admin"]) )
{
	// User not logged in, redirect to login page
	Header("Location: ../index.php");
}
	
$vid = $_SESSION["valid_id"];

require( "../includes/config.php" );
require( "includes/admin.functions.php" );
require( "includes/sessions.php" );
include( "../lang/" . $_SESSION['lang'] . "/a_common.php" );
include( "includes/admin.template_titles.php" );

// load template
$page = new Page("../templates/admin_template.tpl");

// get logo
$logo_path = $web_path . $_SESSION['site_logo'];
$logo = "<img src=\"" . $logo_path . "\" alt=\"" . $_SESSION['admin_company'] . "\" />";

$page->replace_tags(array(
  "logo" => "$logo",
  "left_col" => "$left_content",
  "right_col" => "$right_content",
  "main_nav" => "../data/admin/admin_nav.php",
  "sub_nav" => "../data/admin/sub_nav.php",
  "title" => "$pg_title",
  "login" => "../data/admin/admin_login.php",
  "footer" => "../data/admin/admin_footer.php"
));

$page->output();

?>