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
include( "../lang/" . $_SESSION['lang'] . "/a_titles.php" );

if ($_SESSION["mod1_installed"] != '0') {
	include("../modules/basic_invoice/lang/" . $_SESSION['lang'] . "/binvoice_titles.php");
}
if ($_SESSION["mod4_installed"] != '0') {
	include("../modules/webhosting/lang/" . $_SESSION['lang'] . "/webhost_titles.php");
}

// SWITCH FOR PAGE TITLES
switch ( $_GET['pg'] ) {

	// MAIN PAGE
	case main:
		$pg_title = $TITLE_MAIN;
		$left_content = "../data/admin/admin_content.php";
		$right_content = "../data/admin/admin_col.php";
		break;

	// ADD CLIENT
	case addclient:
		$pg_title = $TITLE_ADDCLIENT;
		$left_content = "../data/admin/addclient_content.php";
		$right_content = "../data/admin/addclient_col.php";
		break;
	
	// ADD FILE
	case addfile:
		$pg_title = $TITLE_ADDFILE;
		$left_content = "../data/admin/addfile_content.php";
		$right_content = "../data/admin/addfile_col.php";
		break;
	
	// ADD FILES
	case addfiles:
		$pg_title = $TITLE_ADDFILES;
		$left_content = "../data/admin/addfiles_content.php";
		$right_content = "../data/admin/addfiles_col.php";
		break;
	
	// ADD HELP CATEGORY
	case addhelpcat:
		$pg_title = $TITLE_ADDHELPCAT;
		$left_content = "../data/admin/addhelpcat_content.php";
		$right_content = "../data/admin/addhelpcat_col.php";
		break;
	
	// ADD LINK
	case addlink:
		$pg_title = $TITLE_ADDLINK;
		$left_content = "../data/admin/addlink_content.php";
		$right_content = "../data/admin/addlink_col.php";
		break;
		
	// ADD MESSAGE
	case addmsg:
		$pg_title = $TITLE_ADDMSG;
		$left_content = "../data/admin/addmsg_content.php";
		$right_content = "../data/admin/addmsg_col.php";
		break;
		
	// ADD NOTE
	case addnotes:
		$pg_title = $TITLE_ADDNOTE;
		$left_content = "../data/admin/addnotes_content.php";
		$right_content = "../data/admin/addnotes_col.php";
		break;
		
	// ADD USER PERMISSIONS
	case addperms:
		$pg_title = $TITLE_ADDPERMS;
		$left_content = "../data/admin/addperms_content.php";
		$right_content = "../data/admin/addperms_col.php";
		break;
		
	// ADD PROJECT
	case addproj:
		$pg_title = $TITLE_ADDPROJ;
		$left_content = "../data/admin/addproj_content.php";
		$right_content = "../data/admin/addproj_col.php";
		break;
		
	// ADD TASK
	case addtask:
		$pg_title = $TITLE_ADDTASK;
		$left_content = "../data/admin/addtask_content.php";
		$right_content = "../data/admin/addtask_col.php";
		break;
		
	// ADD TO DO ITEM
	case addtodo:
		$pg_title = $TITLE_ADDTODO;
		$left_content = "../data/admin/addtodo_content.php";
		$right_content = "../data/admin/addtodo_col.php";
		break;
		
	// ADD HELP TOPIC
	case addtopic:
		$pg_title = $TITLE_ADDTOPIC;
		$left_content = "../data/admin/addtopic_content.php";
		$right_content = "../data/admin/addtopic_col.php";
		break;
		
	// ADD USER
	case adduser:
		$pg_title = $TITLE_ADDUSER;
		$left_content = "../data/admin/adduser_content.php";
		$right_content = "../data/admin/adduser_col.php";
		break;
		
	// ADD WEBSITE
	case addwebsite:
		$pg_title = $TITLE_ADDWEBSITE;
		$left_content = "../data/admin/addwebsite_content.php";
		$right_content = "../data/admin/addwebsite_col.php";
		break;
		
	// ALL MESSAGES
	case allmsg:
		$pg_title = $TITLE_ALLMSG;
		$left_content = "../data/admin/allmsg_content.php";
		$right_content = "../data/admin/allmsg_col.php";
		break;
		
	// ALL PROJECTS
	case allproj:
		$pg_title = $TITLE_ALLPROJ;
		$left_content = "../data/admin/allproj_content.php";
		$right_content = "../data/admin/allproj_col.php";
		break;
		
	// ALL TASKS
	case alltasks:
		$pg_title = $TITLE_ALLTASKS;
		$left_content = "../data/admin/alltasks_content.php";
		$right_content = "../data/admin/alltasks_col.php";
		break;
	
	// ALL FILES BY TYPE
	case filebytype:
		$pg_title = $TITLE_FILEBYTYPE;
		$left_content = "../data/admin/filebytype_content.php";
		$right_content = "../data/admin/filebytype_col.php";
		break;
	
	// ALL USERS
	case allusers:
		$pg_title = $TITLE_ALLUSERS;
		$left_content = "../data/admin/allusers_content.php";
		$right_content = "../data/admin/allusers_col.php";
		break;
		
	// APPEARANCE SETTINGS
	case appearance:
		$pg_title = $TITLE_APPEARANCE;
		$left_content = "../data/admin/appearance_content.php";
		$right_content = "../data/admin/appearance_col.php";
		break;
		
	// CHANGE PASSWORD
	case changepw:
		$pg_title = $TITLE_CHANGEPW;
		$left_content = "../data/admin/changepw_content.php";
		$right_content = "../data/admin/changepw_col.php";
		break;
		
	// VIEW CLIENT
	case client:
		$pg_title = $TITLE_CLIENT;
		$left_content = "../data/admin/client_content.php";
		$right_content = "../data/admin/client_col.php";
		break;

	// ALL CLIENTS
	case clients:
		$pg_title = $TITLE_CLIENTS;
		$left_content = "../data/admin/clients_content.php";
		$right_content = "../data/admin/clients_col.php";
		break;
		
	// CLIENT LOGO
	case clogo:
		$pg_title = $TITLE_CLIENTLOGO;
		$left_content = "../data/admin/clogo_content.php";
		$right_content = "../data/admin/clogo_col.php";
		break;
		
	// DELETE CLIENT
	case delclient:
		$pg_title = $TITLE_DELCLIENT;
		$left_content = "../data/admin/delclient_content.php";
		$right_content = "../data/admin/delclient_col.php";
		break;
		
	// DELETE PROJECT
	case delproj:
		$pg_title = $TITLE_DELPROJ;
		$left_content = "../data/admin/delproj_content.php";
		$right_content = "../data/admin/delproj_col.php";
		break;
		
	// DELETE USER
	case deluser:
		$pg_title = $TITLE_DELUSER;
		$left_content = "../data/admin/deluser_content.php";
		$right_content = "../data/admin/deluser_col.php";
		break;
		
	// EDIT ADMIN INFORMATION
	case editadmin:
		$pg_title = $TITLE_EDITADMIN;
		$left_content = "../data/admin/editadmin_content.php";
		$right_content = "../data/admin/editadmin_col.php";
		break;
		
	// EDIT CLIENT
	case editclient:
		$pg_title = $TITLE_EDITCLIENT;
		$left_content = "../data/admin/editclient_content.php";
		$right_content = "../data/admin/editclient_col.php";
		break;
		
	// EDIT FILE
	case editfile:
		$pg_title = $TITLE_EDITFILE;
		$left_content = "../data/admin/editfile_content.php";
		$right_content = "../data/admin/editfile_col.php";
		break;
		
	// EDIT MESSAGE
	case editmsg:
		$pg_title = $TITLE_EDITMSG;
		$left_content = "../data/admin/editmsg_content.php";
		$right_content = "../data/admin/editmsg_col.php";
		break;
		
	// EDIT USER PERMISSIONS
	case editperms:
		$pg_title = $TITLE_EDITPERMS;
		$left_content = "../data/admin/editperms_content.php";
		$right_content = "../data/admin/editperms_col.php";
		break;
		
	// EDIT PROJECT
	case editproj:
		$pg_title = $TITLE_EDITPROJ;
		$left_content = "../data/admin/editproj_content.php";
		$right_content = "../data/admin/editproj_col.php";
		break;
		
	// EDIT PROJECT PERMISSIONS
	case projperms:
		$pg_title = $TITLE_PROJPERMS;
		$left_content = "../data/admin/projperms_content.php";
		$right_content = "../data/admin/projperms_col.php";
		break;
		
	// EDIT OPÇÕES DE STATUS
	case statusoptions:
		$pg_title = $TITLE_STATUSOPTIONS;
		$left_content = "../data/admin/statusoptions_content.php";
		$right_content = "../data/admin/statusoptions_col.php";
		break;
		
	// EDIT TASK
	case edittask:
		$pg_title = $TITLE_EDITTASK;
		$left_content = "../data/admin/edittask_content.php";
		$right_content = "../data/admin/edittask_col.php";
		break;
		
	// EDIT HELP TOPIC
	case edittopic:
		$pg_title = $TITLE_EDITTOPIC;
		$left_content = "../data/admin/edittopic_content.php";
		$right_content = "../data/admin/edittopic_col.php";
		break;
		
	// EDIT USER
	case edituser:
		$pg_title = $TITLE_EDITUSER;
		$left_content = "../data/admin/edituser_content.php";
		$right_content = "../data/admin/edituser_col.php";
		break;
		
	// FILES
	case files:
		$pg_title = $TITLE_FILES;
		$left_content = "../data/admin/files_content.php";
		$right_content = "../data/admin/files_col.php";
		break;
	
	// FILES BY TYPE
	case filesbytype:
		$pg_title = $TITLE_FILESBYTYPE;
		$left_content = "../data/admin/filesbytype_content.php";
		$right_content = "../data/admin/filesbytype_col.php";
		break;
		
	// FILE TYPES
	case filetypes:
		$pg_title = $TITLE_FILETYPES;
		$left_content = "../data/admin/filetypes_content.php";
		$right_content = "../data/admin/filetypes_col.php";
		break;
	
	// HELP SECTION
	case help:
		$pg_title = $TITLE_HELP;
		$left_content = "../data/admin/help_content.php";
		$right_content = "../data/admin/help_col.php";
		break;
		
	// ADMIN LOGO
	case alogo:
		$pg_title = $TITLE_ALOGO;
		$left_content = "../data/admin/alogo_content.php";
		$right_content = "../data/admin/alogo_col.php";
		break;
		
	// READ MESSAGE
	case readmsg:
		$pg_title = $TITLE_READMSG;
		$left_content = "../data/admin/readmsg_content.php";
		$right_content = "../data/admin/readmsg_col.php";
		break;
		
	// MESSAGES
	case msg:
		$pg_title = $TITLE_MSG;
		$left_content = "../data/admin/msg_content.php";
		$right_content = "../data/admin/msg_col.php";
		break;
		
	// MODIFY USER INFORMATION
	case usermod:
		$pg_title = $TITLE_EDITUINFO;
		$left_content = "../data/admin/usermod_content.php";
		$right_content = "../data/admin/usermod_col.php";
		break;
		
	// PROJECT
	case proj:
		$pg_title = $TITLE_PROJ;
		$left_content = "../data/admin/proj_content.php";
		$right_content = "../data/admin/proj_col.php";
		break;
		
	// PROJECTS
	case projects:
		$pg_title = $TITLE_PROJECTS;
		$left_content = "../data/admin/projects_content.php";
		$right_content = "../data/admin/projects_col.php";
		break;
		
	// SEARCH
	case search:
		$pg_title = $TITLE_SEARCH;
		$left_content = "../data/admin/search_content.php";
		$right_content = "../data/admin/search_col.php";
		break;
		
	// SETTINGS
	case settings:
		$pg_title = $TITLE_SETTINGS;
		$left_content = "../data/admin/settings_content.php";
		$right_content = "../data/admin/settings_col.php";
		break;
		
	// OPÇÕES DE STATUS
	case status:
		$pg_title = $TITLE_STATUS;
		$left_content = "../data/admin/status_content.php";
		$right_content = "../data/admin/status_col.php";
		break;
		
	// TASKS
	case tasks:
		$pg_title = $TITLE_TASKS;
		$left_content = "../data/admin/tasks_content.php";
		$right_content = "../data/admin/tasks_col.php";
		break;
		
	// TEMPLATES
	case templates:
		$pg_title = $TITLE_TEMPLATES;
		$left_content = "../data/admin/templates_content.php";
		$right_content = "../data/admin/templates_col.php";
		break;
		
	// EDITAR NÍVEIS DE USUÁRIO
	case usertypes:
		$pg_title = $TITLE_USERTYPES;
		$left_content = "../data/admin/usertypes_content.php";
		$right_content = "../data/admin/usertypes_col.php";
		break;
	
	// ADICIOANR NÍVEIS DE USUÁRIO
	case addusertype:
		$pg_title = $TITLE_ADDUSERTYPE;
		$left_content = "../data/admin/addusertype_content.php";
		$right_content = "../data/admin/addusertype_col.php";
		break;
		
	// EDITAR NÍVEIS DE USUÁRIOS
	case editusertype:
		$pg_title = $TITLE_EDITUSERTYPE;
		$left_content = "../data/admin/editusertype_content.php";
		$right_content = "../data/admin/editusertype_col.php";
		break;

	// ADD BASIC INVOICE
	case addbinvoice:
		$pg_title = $TITLE_ADDBINVOICES;
		$left_content = "../modules/basic_invoice/data/admin/addbinvoice_content.php";
		$right_content = "../modules/basic_invoice/data/admin/addbinvoice_col.php";
		break;
		
	// ALL BASIC INVOICES
	case allbinvoices:
		$pg_title = $TITLE_ALLBINVOICES;
		$left_content = "../modules/basic_invoice/data/admin/allbinvoices_content.php";
		$right_content = "../modules/basic_invoice/data/admin/allbinvoices_col.php";
		break;
		
	// BASIC INVOICES
	case binvoices:
		$pg_title = $TITLE_BINVOICES;
		$left_content = "../modules/basic_invoice/data/admin/binvoices_content.php";
		$right_content = "../modules/basic_invoice/data/admin/binvoices_col.php";
		break;
		
	// EDIT BASIC INVOICE
	case editbinvoice:
		$pg_title = $TITLE_EDITBINVOICE;
		$left_content = "../modules/basic_invoice/data/admin/editbinvoice_content.php";
		$right_content = "../modules/basic_invoice/data/admin/editbinvoice_col.php";
		break;
		
	// ADD WEB HOST / DOMAIN
	case addwebhost:
		$pg_title = $TITLE_ADDWEBHOST;
		$left_content = "../modules/webhosting/data/admin/addwebhost_content.php";
		$right_content = "../modules/webhosting/data/admin/addwebhost_col.php";
		break;
		
	// VIEW WEB HOSTS / DOMAIN REGISTRARS
	case webhosts:
		$pg_title = $TITLE_WEBHOSTS;
		$left_content = "../modules/webhosting/data/admin/webhosts_content.php";
		$right_content = "../modules/webhosting/data/admin/webhosts_col.php";
		break;
		
	// EDIT WEB HOSTS / DOMAIN REGISTRARS
	case editwebhost:
		$pg_title = $TITLE_EDITWEBHOST;
		$left_content = "../modules/webhosting/data/admin/editwebhost_content.php";
		$right_content = "../modules/webhosting/data/admin/editwebhost_col.php";
		break;
	
	// VIEW WEB HOSTSING PACKAGES
	case webpackages:
		$pg_title = $TITLE_WEBPACKAGES;
		$left_content = "../modules/webhosting/data/admin/webpackages_content.php";
		$right_content = "../modules/webhosting/data/admin/webpackages_col.php";
		break;
		
	// ADD WEB HOSTSING PACKAGES
	case addwebpackage:
		$pg_title = $TITLE_ADDWEBPACKAGE;
		$left_content = "../modules/webhosting/data/admin/addwebpackage_content.php";
		$right_content = "../modules/webhosting/data/admin/addwebpackage_col.php";
		break;
	
	// EDIT WEB HOSTING PACKAGE
	case editwebpackage:
		$pg_title = $TITLE_EDITWEBPACKAGE;
		$left_content = "../modules/webhosting/data/admin/editwebpackage_content.php";
		$right_content = "../modules/webhosting/data/admin/editwebpackage_col.php";
		break;
		
	// VIEW WEB HOSTING FEATURES
	case webfeatures:
		$pg_title = $TITLE_WEBFEATURES;
		$left_content = "../modules/webhosting/data/admin/webfeatures_content.php";
		$right_content = "../modules/webhosting/data/admin/webfeatures_col.php";
		break;
	
	// EDIT WEB HOSTING FEATURE
	case editwebfeature:
		$pg_title = $TITLE_EDITWEBFEATURE;
		$left_content = "../modules/webhosting/data/admin/editwebfeature_content.php";
		$right_content = "../modules/webhosting/data/admin/editwebfeature_col.php";
		break;
		
	// ADD CLIENT HOST
	case addclienthost:
		$pg_title = $TITLE_ADDCLIENTHOST;
		$left_content = "../modules/webhosting/data/admin/addclienthost_content.php";
		$right_content = "../modules/webhosting/data/admin/addclienthost_col.php";
		break;
	
	// EDIT CLIENT HOST
	case editclienthost:
		$pg_title = $TITLE_EDITCLIENTHOST;
		$left_content = "../modules/webhosting/data/admin/editclienthost_content.php";
		$right_content = "../modules/webhosting/data/admin/editclienthost_col.php";
		break;
	
	// VIEW HOSTED CLIENT
	case clienthost:
		$pg_title = $TITLE_CLIENTHOST;
		$left_content = "../modules/webhosting/data/admin/clienthost_content.php";
		$right_content = "../modules/webhosting/data/admin/clienthost_col.php";
		break;
		
	// VIEW HOSTED CLIENTS
	case hostedclients:
		$pg_title = $TITLE_HOSTEDCLIENTS;
		$left_content = "../modules/webhosting/data/admin/hostedclients_content.php";
		$right_content = "../modules/webhosting/data/admin/hostedclients_col.php";
		break;
		
	// VIEW DOMAIN CLIENTS
	case domainclients:
		$pg_title = $TITLE_DOMAINCLIENTS;
		$left_content = "../modules/webhosting/data/admin/domainclients_content.php";
		$right_content = "../modules/webhosting/data/admin/domainclients_col.php";
		break;
		
	// ADD DOMAIN CLIENTS
	case addclientdomain:
		$pg_title = $TITLE_ADDCLIENTDOMAIN;
		$left_content = "../modules/webhosting/data/admin/addclientdomain_content.php";
		$right_content = "../modules/webhosting/data/admin/addclientdomain_col.php";
		break;
	
	// EDIT DOMAIN CLIENTS
	case editclientdomain:
		$pg_title = $TITLE_EDITCLIENTDOMAIN;
		$left_content = "../modules/webhosting/data/admin/editclientdomain_content.php";
		$right_content = "../modules/webhosting/data/admin/editclientdomain_col.php";
		break;
		
	default:
		$pg_title = "$TITLE_INVALID";
		$pg_data = "invalid";
		break;

}