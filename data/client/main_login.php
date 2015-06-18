<?php
/*
	=================================================================
	# Wespa Juris - Acompanhamento Processual Baseado na Web            
	# Copyright © 2012 Weslley A. Harakaes // Wespa Digital Ltda.                     
	#
	# Para obter atualizações, tirar dúvidas ou sugerir mudanças
	# visite o site: http://www.wespadigital.com
	#
	# O código deste software não pode ser vendido ou alterado
	# sem a autoização expressa de Wespa Digital Ltda. 
	# Mantenha os créditos do autor e os códigos de banners.
	#
	# Gratuíto para uso pessoal, não pode ser redistribuído.
	=================================================================
*/

include( "lang/" . $_SESSION['lang'] . "/c_common.php" );
include( "lang/" . $_SESSION['lang'] . "/c_navigation.php" );

echo ("$HEADER_LOGGEDIN <strong>$_SESSION[client_name] [ <a href=\"main.php?pg=usermod\" title=\"Editar\">$COMMON_EDIT</a> ] </strong>");

?>