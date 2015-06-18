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
include( "includes/client_variables.php" );
require( "includes/client.functions.php" );
require( "includes/sessions.php" );
$lang = $_SESSION['lang'];
require( $home_dir . "lang/" . $lang . "/c_login.php" );

if ($_SESSION["valid_cluser"])
	{
	// User already logged in, redirect to main page
	Header("Location: main.php");
	}
	
// PAGE TITLE
$page_title = $MAIN_PAGETITLE;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Acompanhamento Processual - <?php echo("$main_title"); ?></title>
<script language="JavaScript" src="includes/standard.js"></script>
<link rel="stylesheet" type="text/css" href="includes/styles.css" />
</head>
<body>

<div id="header">
	<img src="<?php echo $_SESSION['site_logo'] ?>" alt="<?php echo $_SESSION['admin_company'] ?>" />
	<hr />
	<ul id="nav">&nbsp;</ul>
	<ul id="subnav">&nbsp;</ul>
</div>
<center>

<script type="text/javascript"><!--
google_ad_client = "ca-pub-5657489025436669";
/* Wespa Juris - Links no Topo */
google_ad_slot = "7894042886";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</center>
	<hr />
	<div id="splitcol_left">
			<div id="login-box">
				<h1><?=$INDEX_LOGIN?></h1>
				<p><?=$INDEX_MAINTEXT?></p>
				<?php 
			
				if ($_GET['log'] == 'np') {
    				echo("<div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> &nbsp; $INDEX_NP</div>");
    			} 
				if ($_GET['log'] == 'nl') {
    				echo("<div id=\"warning\"><img src=\"images/warning.gif\" align=\"left\"> $INDEX_NL</div>");
    			} ?>
				<br />
				<form action="process_login.php" method="POST">
				<input type="hidden" name="do" value="login">
				<?=$INDEX_USERNAME?><br />
				<input type="text" size="35" class="input-box" name="username"><br />
				<?=$INDEX_PASSWORD?><br />
				<input type="password" size="35" class="input-box" name="password"><br />
				<a href="lost_password.php"><?=$INDEX_FORGOTPW?></a><br />
				<br /><input type="submit" class="submit-button" value="ENTRAR">
				</form>
				<br />
			</div>
	</div>
	<div id="splitcol_right">
		<div id="login-box">
			<h1><?=$INDEX_NOREG?></h1>
			<br />
			<?=$INDEX_NOREGTEXT?>
			<br />
		</div>
	</div>
<hr />
<div id="footer">
	<?php

echo ("<p>");
if ( $_SESSION['admin_company'] != '' ) {
	echo ( $_SESSION['admin_company'] . " | ");
}
if ( $_SESSION['admin_address1'] != '' ) {
	echo ( $_SESSION['admin_address1'] );
}
if ( $_SESSION['admin_address2'] != '' ) {
	echo (", " . $_SESSION['admin_address2'] );
}
echo ( " | " );
if ( $_SESSION['admin_city'] != '' ) {
	echo ( $_SESSION['admin_city'] . ", " );
}
if ( $_SESSION['admin_state'] != '' ) {
	echo ( $_SESSION['admin_state'] . " " );
}
if ( $_SESSION['admin_zip'] != '' ) {
	echo ( $_SESSION['admin_zip'] . " | " );
}
if ( $_SESSION['admin_country'] != '' ) {
	echo ( $_SESSION['admin_country'] );
}
echo("</p>
<br>
<center>
<script type='text/javascript'><!--
google_ad_client = 'ca-pub-5657489025436669';
/* Wespa Juris - 468x60 no Rodapé */
google_ad_slot = '3149035740';
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type='text/javascript'
src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
</script>
</center>
<br>
");

?>

	</div>
</body>
</html>