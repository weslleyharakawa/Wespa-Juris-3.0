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

require( "includes/config.php" );
require( "includes/client.adv.functions.php" );

global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;

// PULL ADMIN DATA FROM DATABASE
$query = " SELECT logo, language, date_format FROM ttcm_admin WHERE company_id = '1' ";
$retid = $db_q($db, $query, $cid);
$row = $db_f($retid);
$site_logo = $row[ "logo" ];
$company = $row[ "company" ];
$company_email = $row[ "email" ];

$logo = $web_path . $site_logo;

$lang = $row[ "language" ];
$date_format = $row[ "date_format" ];
$server_diff = $row[ "serverdiff" ];

require( $home_dir . "lang/" . $lang . "/c_messages.php" );
include( $home_dir . "lang/" . $lang . "/c_titles.php" );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo("$TITLE_GETMESSAGE"); ?></title>
<script language="JavaScript" src="includes/standard.js"></script>
<link rel="stylesheet" type="text/css" href="includes/styles.css" />
</head>
<body>

<div id="header">
	<img src="<?=$logo?>" alt="<?=$company?>" />
	<hr />

	<ul id="nav">
		<li><a href="index.php">Login</a> &nbsp; &nbsp;</li>
	</ul>
	<ul id="subnav"></ul>

</div>
	<hr />
	<div id="rightcol">
		<div id="innerright">
		</div>
	  </div>
	<hr />
<div id="leftcol">
<?php 
include("includes/client.tasks.php");
$mid = $_GET['mid'];
$id = $_GET['id'];
$vid = $_GET['vid'];
$read_msg = read_message("$mid", "$id", "$vid", "$lang", $date_format, $serverdiff);
echo ("<p>$read_msg</p>");
?>
				</div>
		<hr />

		<div id="footer">
		</div>
</body>
</html>