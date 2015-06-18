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

// CLIENT USERS ORDER BY
if (isset($_GET["cluser_oby"])) {
	$_SESSION['cluser_oby'] = $_GET["cluser_oby"];
	$_SESSION['cluser_lby'] = $_GET["cluser_lby"];
}
// Ordena lisat de Clientes
if (isset($_GET["clist_oby"])) {
	$_SESSION['clist_oby'] = $_GET["clist_oby"];
	$_SESSION['clist_lby'] = $_GET["clist_lby"];
}
// ALL PROJECTS LIST ORDER BY
if (isset($_GET["allproj_oby"])) {
	$_SESSION['allproj_oby'] = $_GET["allproj_oby"];
	$_SESSION['allproj_lby'] = $_GET["allproj_lby"];
}
// PROJECT PERMISSIONS LIST ORDER BY
if (isset($_GET["projperm_oby"])) {
	$_SESSION['projperm_oby'] = $_GET["projperm_oby"];
	$_SESSION['projperm_lby'] = $_GET["projperm_lby"];
}
// ACTIVE PROJECTS PERMISSIONS LIST ORDER BY
if (isset($_GET["aproj_oby"])) {
	$_SESSION['aproj_oby'] = $_GET["aproj_oby"];
	$_SESSION['aproj_lby'] = $_GET["aproj_lby"];
}
// PAST DUE PROJECTS PERMISSIONS LIST ORDER BY
if (isset($_GET["pdproj_oby"])) {
	$_SESSION['pdproj_oby'] = $_GET["pdproj_oby"];
	$_SESSION['pdproj_lby'] = $_GET["pdproj_lby"];
}
// ALL FILES BY TYPE LIST ORDER BY
if (isset($_GET["allfiles_oby"])) {
	$_SESSION['allftype_oby'] = $_GET["allftype_oby"];
	$_SESSION['allftype_lby'] = $_GET["allftype_lby"];
}
// ALL MESSAGES LIST ORDER BY
if (isset($_GET["allmessages_oby"])) {
	$_SESSION['allmessages_oby'] = $_GET["allmessages_oby"];
	$_SESSION['allmessages_lby'] = $_GET["allmessages_lby"];
}
// ALL USERS LIST ORDER BY
if (isset($_GET["allusers_oby"])) {
	$_SESSION['allusers_oby'] = $_GET["allusers_oby"];
	$_SESSION['allusers_lby'] = $_GET["allusers_lby"];
}
// PROJECT SEARCH LIST ORDER BY
if (isset($_GET["projsearch_oby"])) {
	$_SESSION['projsearch_oby'] = $_GET["projsearch_oby"];
	$_SESSION['projsearch_lby'] = $_GET["projsearch_lby"];
}
// DOWNLOAD SEARCH LIST ORDER BY
if (isset($_GET["dlsearch_oby"])) {
	$_SESSION['dlsearch_oby'] = $_GET["dlsearch_oby"];
	$_SESSION['dlsearch_lby'] = $_GET["dlsearch_lby"];
}
// CLIENT SEARCH LIST ORDER BY
if (isset($_GET["clsearch_oby"])) {
	$_SESSION['clsearch_oby'] = $_GET["clsearch_oby"];
	$_SESSION['clsearch_lby'] = $_GET["clsearch_lby"];
}
// USER SEARCH LIST ORDER BY
if (isset($_GET["usearch_oby"])) {
	$_SESSION['usearch_oby'] = $_GET["usearch_oby"];
	$_SESSION['usearch_lby'] = $_GET["usearch_lby"];
}
// CLIENT FILES LIST ORDER BY
if (isset($_GET["cfiles_oby"])) {
	$_SESSION['cfiles_oby'] = $_GET["cfiles_oby"];
	$_SESSION['cfiles_lby'] = $_GET["cfiles_lby"];
}
// LAST 10 PROJECTS LIST ORDER BY
if (isset($_GET["tenproj_oby"])) {
	$_SESSION['tenproj_oby'] = $_GET["tenproj_oby"];
	$_SESSION['tenproj_lby'] = $_GET["tenproj_lby"];
}
// TASKS LIST ORDER BY
if (isset($_GET["tasks_oby"])) {
	$_SESSION['tasks_oby'] = $_GET["tasks_oby"];
	$_SESSION['tasks_lby'] = $_GET["tasks_lby"];
}
// ACTIVE TASKS LIST ORDER BY
if (isset($_GET["atasks_oby"])) {
	$_SESSION['atasks_oby'] = $_GET["atasks_oby"];
	$_SESSION['atasks_lby'] = $_GET["atasks_lby"];
}
// ALL TASKS LIST ORDER BY
if (isset($_GET["alltasks_oby"])) {
	$_SESSION['alltasks_oby'] = $_GET["alltasks_oby"];
	$_SESSION['alltasks_lby'] = $_GET["alltasks_lby"];
}
// FILES LIST ORDER BY
if (isset($_GET["files_oby"])) {
	$_SESSION['files_oby'] = $_GET["files_oby"];
	$_SESSION['files_lby'] = $_GET["files_lby"];
}
// CLIENT FILES LIST ORDER BY
if (isset($_GET["cfiles_oby"])) {
	$_SESSION['cfiles_oby'] = $_GET["cfiles_oby"];
	$_SESSION['cfiles_lby'] = $_GET["cfiles_lby"];
}
// MESSAGES LIST ORDER BY
if (isset($_GET["messages_oby"])) {
	$_SESSION['messages_oby'] = $_GET["messages_oby"];
	$_SESSION['messages_lby'] = $_GET["messages_lby"];
}
// UNREAD MESSAGES LIST ORDER BY
if (isset($_GET["urmessages_oby"])) {
	$_SESSION['urmessages_oby'] = $_GET["urmessages_oby"];
	$_SESSION['urmessages_lby'] = $_GET["urmessages_lby"];
}
// PROJECT MESSAGES LIST ORDER BY
if (isset($_GET["pmessages_oby"])) {
	$_SESSION['pmessages_oby'] = $_GET["pmessages_oby"];
	$_SESSION['pmessages_lby'] = $_GET["pmessages_lby"];
}
// TO DO LIST ORDER BY
if (isset($_GET["todo_oby"])) {
	$_SESSION['todo_oby'] = $_GET["todo_oby"];
	$_SESSION['todo_lby'] = $_GET["todo_lby"];
}
// CLIENT MESSAGES LIST ORDER BY
if (isset($_GET["clmessages_oby"])) {
	$_SESSION['clmessages_oby'] = $_GET["clmessages_oby"];
	$_SESSION['clmessages_lby'] = $_GET["clmessages_lby"];
}
?>