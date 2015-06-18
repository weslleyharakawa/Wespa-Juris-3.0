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
include( "lang/" . $_SESSION['lang'] . "/c_titles.php" );

if ($_SESSION["mod1_installed"] != '0') {
	include("modules/basic_invoice/lang/" . $_SESSION['lang'] . "/binvoice_titles.php");
}
if ($_SESSION["mod4_installed"] != '0') {
	include("modules/webhosting/lang/" . $_SESSION['lang'] . "/webhost_titles.php");
}

// SWITCH FOR PAGE TITLES
switch ( $_GET['pg'] ) {

	// MAIN PAGE
	case main:
		$pg_title = $TITLE_MAIN;
		$left_content = "data/client/client_content.php";
		$right_content = "data/client/client_col.php";
		break;

	// ADD MESSAGE
	case addmsg:
		$pg_title = $TITLE_ADDMESSAGE;
		$left_content = "data/client/addmsg_content.php";
		$right_content = "data/client/addmsg_col.php";
		break;
	
	// ALL MESSAGES
	case allmsg:
		$pg_title = $TITLE_ALLMESSAGES;
		$left_content = "data/client/allmsg_content.php";
		$right_content = "data/client/allmsg_col.php";
		break;
	
	// ALL PROJECTS
	case allproj:
		$pg_title = $TITLE_ALLPROJECTS;
		$left_content = "data/client/allproj_content.php";
		$right_content = "data/client/allproj_col.php";
		break;
	
	// CHANGE PASSWORD
	case changepw:
		$pg_title = $TITLE_CHANGEPW;
		$left_content = "data/client/changepw_content.php";
		$right_content = "data/client/changepw_col.php";
		break;
	
	// CONTACCT
	case contact:
		$pg_title = $TITLE_CONTACT;
		$left_content = "data/client/contact_content.php";
		$right_content = "data/client/contact_col.php";
		break;
		
	// FILE DOWNLOADS
	case files:
		$pg_title = $TITLE_DOWNLOADS;
		$left_content = "data/client/files_content.php";
		$right_content = "data/client/files_col.php";
		break;
		
	// HELP SECTION
	case help:
		$pg_title = $TITLE_HELP;
		$left_content = "data/client/help_content.php";
		$right_content = "data/client/help_col.php";
		break;
		
	// LOST PASSWORD
	case forgotpw:
		$pg_title = $TITLE_FORGOTPW;
		$left_content = "data/client/forgotpw_content.php";
		$right_content = "data/client/forgotpw_col.php";
		break;
		
	// READ MESSAGE
	case readmsg:
		$pg_title = $TITLE_READMESSAGE;
		$left_content = "data/client/readmsg_content.php";
		$right_content = "data/client/readmsg_col.php";
		break;
		
	// VIEW MESSAGES
	case msg:
		$pg_title = $TITLE_VIEWMESSAGES;
		$left_content = "data/client/msg_content.php";
		$right_content = "data/client/msg_col.php";
		break;
		
	// MODIFY CLIENT INFORMATION
	case clientmod:
		$pg_title = $TITLE_CLIENTMOD;
		$left_content = "data/client/clientmod_content.php";
		$right_content = "data/client/clientmod_col.php";
		break;
		
	// MODIFY USER INFORMATION
	case usermod:
		$pg_title = $TITLE_USERMOD;
		$left_content = "data/client/usermod_content.php";
		$right_content = "data/client/usermod_col.php";
		break;
		
	// VIEW PROJECT
	case proj:
		$pg_title = $TITLE_VIEWPROJECT;
		$left_content = "data/client/proj_content.php";
		$right_content = "data/client/proj_col.php";
		break;
		
	// VIEW PROJECTS
	case projects:
		$pg_title = $TITLE_PROJECTS;
		$left_content = "data/client/projects_content.php";
		$right_content = "data/client/projects_col.php";
		break;
		
	// READ MESSAGE OUTSIDE
	case getmsg:
		$pg_title = $TITLE_GETMESSAGE;
		$left_content = "data/client/getmsg_content.php";
		$right_content = "data/client/getmsg_col.php";
		break;
		
	// SEARCH
	case search:
		$pg_title = $TITLE_SEARCH;
		$left_content = "data/client/search_content.php";
		$right_content = "data/client/search_col.php";
		break;
		
	// CONTACT ERROR
	case error:
		$pg_title = $TITLE_ERROR;
		$left_content = "data/client/error_content.php";
		$right_content = "data/client/error_col.php";
		break;
	
	// CONTACT SUCCESS
	case success:
		$pg_title = $TITLE_SUCCESS;
		$left_content = "data/client/success_content.php";
		$right_content = "data/client/success_col.php";
		break;
	
	// PROJECT TASK
	case task:
		$pg_title = $TITLE_TASK;
		$left_content = "data/client/task_content.php";
		$right_content = "data/client/task_col.php";
		break;
		
	// HELP TOPIC
	case topic:
		$pg_title = $TITLE_TOPIC;
		$left_content = "data/client/topic_content.php";
		$right_content = "data/client/topic_col.php";
		break;
		
	// CLIENT UPLOADS
	case uploads:
		$pg_title = $TITLE_UPLOADS;
		$left_content = "data/client/uploads_content.php";
		$right_content = "data/client/uploads_col.php";
		break;
		
	// CLIENT BASIC INVOICES
	case binvoices:
		$pg_title = $TITLE_BINVOICES;
		$left_content = "modules/basic_invoice/data/client/binvoices_content.php";
		$right_content = "modules/basic_invoice/data/client/binvoices_col.php";
		break;
		
	// CLIENT WEB HOSTING
	case webhosting:
		$pg_title = $TITLE_WEBHOSTING;
		$left_content = "modules/webhosting/data/client/webhosting_content.php";
		$right_content = "modules/webhosting/data/client/webhosting_col.php";
		break;

	default:
		$pg_title = "Invalid";
		$pg_data = "invalid";
		break;

}