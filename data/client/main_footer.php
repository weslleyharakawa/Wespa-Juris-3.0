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
echo("<center>
<script type='text/javascript'><!--
google_ad_client = 'ca-pub-5657489025436669';
/* Wespa Juris - 468x60 */
google_ad_slot = '3149035740';
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type='text/javascript'
src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>
</script></center></p>");

?>