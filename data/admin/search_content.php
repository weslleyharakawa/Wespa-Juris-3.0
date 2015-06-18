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
include( "../lang/" . $_SESSION['lang'] . "/a_search.php" );

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);

if ($_GET['for']) {
	$for = $_GET['for'];
}
else if ($_POST['for']) {
	$for = $_POST['for'];
}

if ($_GET['search']) {
	$search = $_GET['search'];
}
else if ($_POST['search']) {
	$search = $_POST['search'];
}

echo("<h1>$SEARCH_HEADER</h1>
<p>$SEARCH_MAINTEXT</p>");
            
if ( $for == 'project' ) {
	$search_results = project_search("$search");
	echo ("<p>$search_results</p>");
}
if ( $for == 'invoice' ) {
	$search_results = invoice_search("$search");
	echo ("<p>$search_results</p>");
}
if ( $for == 'download' ) {
	$search_results = download_search("$search");
	echo ("<p>$search_results</p>");
}
if ( $for == 'client' ) {
	$search_results = client_search("$search");
	echo ("<p>$search_results</p>");
}
if ( $for == 'user' ) {
	$search_results = user_search("$search");
	echo ("<p>$search_results</p>");
}
?>