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
include( "../lang/" . $_SESSION['lang'] . "/a_navigation.php" );

if ($_SESSION["mod1_installed"] == '1') {
	include( "../modules/basic_invoice/lang/" . $_SESSION['lang'] . "/a_invoice.php" );
}

if ($_SESSION["mod4_installed"] == '1') {
	include( "../modules/webhosting/lang/" . $_SESSION['lang'] . "/a_webhost.php" );
}

$get_perm_vars = $_SESSION['perm_vars'];
$user_perms = split(',', $get_perm_vars);
$sub_nav = '';

// SWITCH FOR PAGE TITLES
switch ( $_GET['pg'] ) {

	// MAIN PAGE
	case main:
		echo ("&nbsp;");
		break;

	// ADD CLIENT
	case addclient:
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addusertype\">$SNAV_ADDUSERTYPE</a></li> 
			<li><a href=\"main.php?pg=usertypes\">$SNAV_USERTYPES</a></li>");
		}
		break;
	
	// ADD FILE
	case addfile:
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has Filetype permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
	
	// ADD FILES
	case addfiles:
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has Filetype permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
	
	// ADD HELP CATEGORY
	case addhelpcat:
		// check if user has Help permissions
		if (in_array("64", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addhelpcat\">$SNAV_ADDHELPCAT</a></li>");
		}
		// check if user has Help permissions
		if (in_array("66", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtopic\">$SNAV_ADDHELPTOPIC</a></li>");
		}
		break;
	
	// ADD LINK
	case addlink:
		echo ("&nbsp;");
		break;
		
	// ADD MESSAGE
	case addmsg:
		// check if user has Message permissions
		if (in_array("10", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addmsg\">$SNAV_ADDMESSAGE</a></li>");
		}
		// check if user has Message permissions
		if (in_array("9", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allmsg\">$SNAV_ALLMESSAGES</a></li>");
		}
		break;
		
	// ADD NOTE
	case addnote:
		echo ("&nbsp;");
		break;
		
	// ADD USER PERMISSIONS
	case addperms:
		// check if user has Client permissions
		if (in_array("15", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addclient\">$SNAV_ADDCLIENT</a></li>");
		}
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a>");
		}
		break;
		
	// ADD PROJECT
	case addproj:
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addproj\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allproj\">$SNAV_ALLPROJECTS</a></li>");
		}
		break;
		
	// ADD TASK
	case addtask:
		echo ("&nbsp;");
		break;
		
	// ADD TO DO ITEM
	case addtodo:
		echo ("&nbsp;");
		break;
		
	// ADD HELP TOPIC
	case addtopic:
		// check if user has Help permissions
		if (in_array("64", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addhelpcat\">$SNAV_ADDHELPCAT</a></li>");
		}
		// check if user has Help permissions
		if (in_array("66", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtopic\">$SNAV_ADDHELPTOPIC</a></li>");
		}
		break;
		
	// ADD USER
	case adduser:
		// check if user has User permissions
		if (in_array("15", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addclient\">$SNAV_ADDCLIENT</a></li>");
		}
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a> &nbsp;");
}
		break;
		
	// ADD WEBSITE
	case addwebsite:
		echo ("&nbsp;");
		break;
		
	// ALL MESSAGES
	case allmsg:
		// check if user has Message permissions
		if (in_array("10", $user_perms)) {
			echo ("<li><a href=\">pg=addmsg\">$SNAV_ADDMESSAGES</a></li>");
		}
		// check if user has Message permissions
		if (in_array("9", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allmsg\">$SNAV_ALLMESSAGES</a></li>");
		}
		break;
		
	// ALL PROJECTS
	case allproj:
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			echo ("<li><a href=\">pg=addproj\">$SNAV_ADDPRJECT</a></li>");
		}
		// check if user has Project permissions
		if (in_array("50", $user_perms)) {
			echo ("<a href=\"main.php?pg=addtask\">$SNAV_ADDTASK</a></li>");
		}
		break;
		
	// ALL TASKS
	case alltasks:
		// check if user has Task permissions
		if (in_array("50", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtask\">$SNAV_ADDTASK</a></li>");
		}
		break;
	
	// ALL FILES BY TYPE
	case filebytype:
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has File permissions
		if (in_array("21", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filesbytype\">$SNAV_FILESTYPE</a></li>");
		}
		// check if user has File permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\">pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
	
	// ALL USERS
	case allusers:
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a></li>");
		}
		break;
		
	// APPEARANCE SETTINGS
	case appearance:
		// check if user has Admin permissions
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=settings\">$SNAV_DEFSETTINGS</a></li>
			<li><a href=\"main.php?pg=appearance\">$SNAV_APPEARSETTINGS</a></li>
			<li><a href=\"main.php?pg=templates\">$SNAV_TEMPLATES</a></li>");
		}
		break;
		
	// CHANGE PASSWORD
	case changepw:
		echo ("&nbsp;");
		break;
		
	// VIEW CLIENT
	case client:
		// check if user has Client permissions
		if (in_array("15", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addclient\">$SNAV_ADDCLIENT</a></li>");
		}
		// check if user has Client permissions
		if (in_array("16", $user_perms)) {
			$clid = $_GET['clid'];
			echo ("<li><a href=\"main.php?pg=editclient&amp;clid=$clid\">$SNAV_EDITCLIENT</a></li>");
		}
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a></li>");
		}
		// check if user has User permissions
		if (in_array("25", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allusers\">$SNAV_ALLUSERS</a></li>");
		}
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			$clid = $_GET['clid'];
			echo ("<li><a href=\"main.php?pg=addproj&amp;clid=$clid\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Note permissions
		if (in_array("19", $user_perms)) {
			$clid = $_GET['clid'];
			echo ("<li><a href=\"main.php?pg=addnotes&amp;clid=$clid\">$SNAV_ADDNOTES</a></li>");
		}
		break;

	// ALL CLIENTS
	case clients:
		// check if user has Client permissions
		if (in_array("15", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addclient\">$SNAV_ADDCLIENT</a></li>");
		}
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a></li>");
		}
		// check if user has User permissions
		if (in_array("25", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allusers\">$SNAV_ALLUSERS</a></li>");
		}
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addusertype\">$SNAV_ADDUSERTYPE</a></li><li><a href=\"main.php?pg=usertypes\">$SNAV_USERTYPES</a></li>");
		}
		break;
		
	// CLIENT LOGO
	case clientlogo:
		echo ("&nbsp;");
		break;
		
	// DELETE CLIENT
	case delclient:
		echo ("&nbsp;");
		break;
		
	// DELETE PROJECT
	case delproj:
		echo ("&nbsp;");
		break;
		
	// DELETE USER
	case deluser:
		echo ("&nbsp;");
		break;
		
	// EDIT ADMIN INFORMATION
	case editadmin:
		echo ("&nbsp;");
		break;
		
	// EDIT CLIENT
	case editclient:
		echo ("&nbsp;");
		break;
		
	// EDIT FILE
	case editfile:
		// check if user has Project permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		break;
		
	// EDITAR NÍVEIS DE USUÁRIOS
	case usertypes:
		// check if user has Settings permissions
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addusertype\">$SNAV_ADDUSERTYPE</a></li> 
			<li><a href=\"main.php?pg=usertypes\">$SNAV_USERTYPES</a></li>");
		}
		break;
		
	// ADICIOANR NÍVEIS DE USUÁRIOS
	case addusertypes:
		// check if user has Settings permissions
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addusertype\">$SNAV_ADDUSERTYPE</a></li> 
			<li><a href=\"main.php?pg=usertypes\">$SNAV_USERTYPES</a></li>");
		}
		break;
		
	// EDIT MESSAGE
	case editmsg:
		// check if user has Messages permissions
		if (in_array("10", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addmsg\">$SNAV_ADDMESSAGE</a></li>");
		}
		// check if user has Messages permissions
		if (in_array("9", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allmsg\">$SNAV_ALLMESSAGES</a></li>");
		}
		break;
		
	// EDIT USER PERMISSIONS
	case editperms:
		// check if user has Client permissions
		if (in_array("15", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addclient\">$SNAV_ADDCLIENT</a></li>");
		}
		// check if user has User permissions
		if (in_array("26", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=adduser\">$SNAV_ADDUSER</a></li>");
		}
		break;
		
	// EDIT PROJECT
	case editproj:
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addproj\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Task permissions
		if (in_array("50", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtask\">$SNAV_ADDTASK</a></li>");
		}
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allproj\">$SNAV_ALLPROJECTS</a></li>");
		}
		break;
		
	// EDIT PROJECT PERMISSIONS
	case projperms:
		echo ("&nbsp;");
		break;
		
	// EDIT OPÇÕES DE STATUS
	case statusoptions:
		echo ("&nbsp;");
		break;
		
	// EDIT TASK
	case edittask:
		// check if user has Task permissions
		if (in_array("2", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addproj\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Task permissions
		if (in_array("50", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtask\">$SNAV_ADDTASK</a></li>");
		}
		// check if user has Project permissions
		if (in_array("1", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allproj\">$SNAV_ALLPROJECTS</a></li>");
		}
		break;
		
	// EDIT HELP TOPIC
	case edittopic:
		// check if user has Help permissions
		if (in_array("64", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addhelpcat\">$SNAV_ADDHELPCAT</a></li>");
		}
		// check if user has Help permissions
		if (in_array("66", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtopic\">$SNAV_ADDHELPTOPIC</a></li>");
		}
		break;
		
	// EDIT USER
	case edituser:
		echo ("&nbsp;");
		break;
		
	// FILES
	case files:
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has Filetype permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
	
	// FILES BY TYPE
	case filesbytype:
		// check if user has Project permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has File permissions
		if (in_array("21", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filesbytype\">$SNAV_FILESTYPE</a></li>");
		}
		// check if user has File permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
		
	// FILE TYPES
	case filetypes:
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addfiles\">$SNAV_ADDFILE</a></li>");
		}
		// check if user has File permissions
		if (in_array("21", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filesbytype\">$SNAV_FILESTYPE</a></li>");
		}
		// check if user has File Type permissions
		if (in_array("59", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=filetypes\">$SNAV_ADDFILETYPE</a></li>");
		}
		break;
	
	// HELP SECTION
	case help:
		// check if user has Help permissions
		if (in_array("64", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addhelpcat\">$SNAV_ADDHELPCAT</a></li>");
		}
		// check if user has Help permissions
		if (in_array("62", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtopic\">$SNAV_ADDHELPTOPIC</a></li>");
		}
		break;
		
	// ADMINISTRAR LOGOMARCA
	case alogo:
		echo ("&nbsp;");
		break;

	// LER MENSAGEM
	case readmsg:
		// check if user has Message permissions
		if (in_array("10", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addmsg\">$SNAV_ADDMESSAGE</a></li>");
		}
		// check if user has Message permissions
		if (in_array("9", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allmsg\">$SNAV_ALLMESSAGES</a></li>");
		}
		break;
		
	// MENSAGENS
	case msg:
		// check if user has Message permissions
		if (in_array("10", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addmsg\">$SNAV_ADDMESSAGE</a></li>");
		}
		// check if user has Message permissions
		if (in_array("9", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=allmsg\">$SNAV_ALLMESSAGES</a></li>");
		}
		break;
		
	// MODIFICA INFORMAÇÕES DO USUÁRIO
	case usermod:
		echo ("&nbsp;");
		break;
		
	// PROCESSOS
	case proj:
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			$clid = $_GET['clid'];
			echo ("<li><a href=\"main.php?pg=addproj&amp;clid=$clid\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Task permissions
		if (in_array("50", $user_perms)) {
			$clid = $_GET['clid'];
			$pid = $_GET['pid'];
			echo ("<li><a href=\"main.php?pg=addtask&amp;clid=$clid&amp;pid=$pid\">$SNAV_ADDTASK</a></li>");
		}
		// check if user has Project permissions
		if (in_array("19", $user_perms)) {
			$clid = $_GET['clid'];
			$pid = $_GET['pid'];
			echo ("<li><a href=\"main.php?pg=addnotes&amp;clid=$clid&amp;pid=$pid\">$SNAV_ADDNOTES</a></li>");
		}
		// check if user has File permissions
		if (in_array("22", $user_perms)) {
			$clid = $_GET['clid'];
			$pid = $_GET['pid'];
			echo ("<li><a href=\"main.php?pg=addfiles&amp;clid=$clid&amp;pid=$pid\">$SNAV_ADDFILE</a></li>");
		}
		break;
		
	// PROJECTS
	case projects:
		// check if user has Project permissions
		if (in_array("2", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addproj\">$SNAV_ADDPROJECT</a></li>");
		}
		// check if user has Task permissions
		if (in_array("50", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addtask\">$SNAV_ADDTASK</a></li>");
		}
		// check if user has Task permissions
		if (in_array("49", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=tasks\">$SNAV_ACTIVETASKS</a></li>");
		}
		// check if user has Task permissions
		if (in_array("49", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=alltasks\">$SNAV_ALLTASKS</a></li>");
		}
		break;
		
	// SEARCH
	case search:
		echo ("&nbsp;");
		break;
		
	// SETTINGS
	case settings:
		// check if user has Admin permissions
		if (in_array("8", $user_perms)) {
			echo("<li><a href=\"main.php?pg=settings\">$SNAV_DEFSETTINGS</a></li>
			<li><a href=\"main.php?pg=appearance\">$SNAV_APPEARSETTINGS</a></li>
			<li><a href=\"main.php?pg=templates\">$SNAV_TEMPLATES</a></li>");
		}
		break;
		
	// OPÇÕES DE STATUS
	case status:
		echo ("&nbsp;");
		break;
		
	// TASKS
	case tasks:
		$clid = $_GET['clid'];
		$pid = $_GET['pid'];
		echo ("<li><a href=\"main.php?pg=addtask&amp;clid=$clid&amp;pid=$pid\">$SNAV_ADDTASK</a></li>
		<li><a href=\"main.php?pg=tasks\">$SNAV_ACTIVETASKS</a></li>
		<li><a href=\"main.php?pg=alltasks\">$SNAV_ALLTASKS</a></li>");
		break;
		
	// TEMPLATES
	case templates:
		// check if user has Admin permissions
		if (in_array("8", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=settings\">$SNAV_DEFSETTINGS</a></li>
			<li><a href=\"main.php?pg=appearance\">$SNAV_APPEARSETTINGS</a></li>
			<li><a href=\"main.php?pg=templates\">$SNAV_TEMPLATES</a></li>");
		}
		break;
		
	// WEB HOSTS
	case webhosts:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
	
	// ADD CLIENT HOST
	case addclienthost:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// ADD WEB HOST FEATURE
	case addwebfeature:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// ADD WEB HOST
	case addwebhost:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// ADD WEB PACKAGE
	case addwebpackage:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// EDIT CLIENT HOST
	case editclienthost:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// EDIT WEB FEATURE
	case editwebfeature:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
	
	// WEDIT WEB HOST
	case editwebhost:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// EDIT WEB PACKAGE
	case editwebpackage:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// WEB FEATURES
	case webfeatures:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// WEB PACKAGES
	case webpackages:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// HOSTED CLIENTS
	case hostedclients:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// DOMAIN CLIENTS
	case domainclients:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	// ADD DOMAIN CLIENTS
	case addclientdomain:
		// check if user has Web Host permissions
		if (in_array("101", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebhost\">$SNAV_ADDWEBHOST</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("105", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webpackages\">$SNAV_HOSTPACKAGES</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("106", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=addwebpackage\">$SNAV_ADDHOSTPACKAGE</a></li>");
		}
		// check if user has Web Host permissions
		if (in_array("109", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=webfeatures\">$SNAV_HOSTFEATURES</a></li>");
		}
		if (in_array("114", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=hostedclients\">$SNAV_HOSTEDCLIENTS</a></li>");
		}
		if (in_array("115", $user_perms)) {
			echo ("<li><a href=\"main.php?pg=domainclients\">$SNAV_DOMAINCLIENTS</a></li>");
		}
		break;
		
	default:
		echo "&nbsp;";
		break;
}
?>