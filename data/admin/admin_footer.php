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
echo("<br />
<center>
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
</script>

<br>
<br>
<b>AVISO IMPORTANTE:</b>
<br>Wespa Juris é um software de acompanhamento processual de distribuição gratuita.
<br>Você e seu escritório podem usar sem custo, desde que que não remova os banners do Google e os créditos do autor que aparecem aqui.
<br>Se esse script está sendo útil. FAÇA UMA DOAÇÃO para o desenvoledor, a Wespa Digital Ltda, clicando no botão à seguir:<br><BR>

<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form target='pagseguro' action='https://pagseguro.uol.com.br/checkout/v2/donation.html' method='post'>
<input type='hidden' name='receiverEmail' value='info@wespadigital.com' />
<input type='hidden' name='currency' value='BRL' />
<input type='image' src='https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/84x35-doar-azul.gif' name='submit' alt='Pague com PagSeguro - é rápido, grátis e seguro!' />
</form>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->

<br>
<br>
NOTA: <font=red>O aviso acima aparece APENAS para você que é administardor do Wespa Juris, seus clientes e advogados não vêem isso.</font><br><br>
Wespa Juris 3.0 - Sistema de Acompanhamento Processual desenvolvido por <b><a href='http://www.wespadigital.com' target='_blank'>WESPA Digital</a></b></center></p>");

?>