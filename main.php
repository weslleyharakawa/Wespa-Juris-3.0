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

if (!$_SESSION["valid_cluser"])
	{
	// USER NOT LOGGED IN - REDIRECT TO INDEX
	Header("Location: index.php");
	}
	
$vid = $_SESSION["valid_id"];

require( "includes/config.php" );
require( "includes/functions.php" );
require( "includes/sessions.php" );
include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
include( "includes/client.template_titles.php" );

// load template
$page = new Page("templates/client_template.tpl");

// get logo
$logo_path = $web_path . $_SESSION['site_logo'];
$logo = "<img src=\"" . $logo_path . "\" alt=\"" . $_SESSION['admin_company'] . "\" />";

$page->replace_tags(array(
  "logo" => "$logo",
  "left_col" => "$left_content",
  "right_col" => "$right_content",
  "main_nav" => "data/client/client_nav.php",
  "sub_nav" => "data/client/sub_nav.php",
  "title" => "$pg_title",
  "login" => "data/client/main_login.php",
  "footer" => "data/client/main_footer.php"
));

$page->output();

?>