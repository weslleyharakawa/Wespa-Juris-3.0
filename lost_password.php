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
require( "includes/client.functions.php" );

global $cid, $db_q, $db_c, $db_f, $db, $home_dir, $web_path;

// PULL ADMIN DATA FROM DATABASE
$query = " SELECT logo, language, date_format FROM ttcm_admin WHERE company_id = '1' ";
$retid = $db_q($db, $query, $cid);
$row = $db_f($retid);
$site_logo = $row[ "logo" ];
$company = $row[ "company" ];
$admin_company = stripslashes($company);
$company_email = $row[ "email" ];

$logo = $web_path . $site_logo;

$lang = $row[ "language" ];
$date_format = $row[ "date_format" ];
$server_diff = $row[ "serverdiff" ];

include( $home_dir . "lang/" . $lang . "/c_login.php" );
include( $home_dir . "lang/" . $lang . "/c_titles.php" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Acompanhamento Processual - <?php echo("$TITLE_FORGOTPW"); ?></title>
<script language="JavaScript" src="includes/standard.js"></script>
<link rel="stylesheet" type="text/css" href="includes/styles.css" />
</head>
<body>

<div id="header">
	<img src="<?=$logo?>" alt="<?=$admin_company?>" />
	<hr />
	<ul id="nav">&nbsp;</ul>
	<ul id="subnav">&nbsp;</ul>
</div>
	<hr />
	<div id="fullcol">
			<p>&nbsp;</p>
			<div id="login-box">
			<?php
			echo("<h1>" . $LOSTPW_MAINTEXT . "</h1>");

					if ($_GET['do'] == 'recover') {	
						
						$SQL_check = " SELECT username FROM ttcm_user WHERE username = '" . $_POST['username'] . "' ";
						$SQLretid = $db_q($db, $SQL_check, $cid);
						$username_db = $db_c( $SQLretid );
			
						if ($username_db == '0') {
							echo("<div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; " . $LOSTPW_NOTFOUND . "</div>
							<form action=\"?do=recover\" method=\"POST\">USERNAME<br />
							<p><input type=\"text\" size=\"25\" class=\"input-box\" name=\"username\"></p>
							<p><input type=\"submit\" class=\"submit-button\" value=\"" . $LOSTPW_RESETPW . "\"></p>
							</form>");
						}
						else {
							$reset_pw = reset_pw("$_POST[username]");
							echo("$reset_pw");
							echo("<div id=\"success\"><img src=\"images/success.gif\" align=\"left\"> &nbsp;Password for " . $_POST['username'] . " has been reset.</div>
							<br /><p><a href=\"index.php\">Click Here</a> to login</p>");
						}
					}
					else {
						echo("<br /><form action=\"?do=recover\" method=\"POST\">" . $INDEX_USERNAME . "<br />
						<p><input type=\"text\" size=\"25\" class=\"head\" name=\"username\"></p>
						<p><input type=\"submit\" class=\"body\" value=\"" . $LOSTPW_RESETPW . "\"></p>
						</form>");
					} ?>
					</div>
			</div>

		<hr />
</body>
</html>