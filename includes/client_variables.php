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

// PULL ADMIN DATA FROM DATABASE
$query = " SELECT * FROM ttcm_admin WHERE company_id = '1' ";
$retid = $db_q($db, $query, $cid);

$row = $db_f($retid);
$company = $row[ "company" ];
$_SESSION['admin_company'] = stripslashes($company);
$address1 = $row[ "address1" ];
$_SESSION['admin_address1'] = stripslashes($address1);
$address2 = $row[ "address2" ];
$_SESSION['admin_address2'] = stripslashes($address2);
$city = $row[ "city" ];
$_SESSION['admin_city'] = stripslashes($city);
$state = $row[ "state" ];
$_SESSION['admin_state'] = stripslashes($state);
$_SESSION['admin_zip'] = $row[ "zip" ];
$country = $row[ "country" ];
$_SESSION['admin_country'] = stripslashes($country);
$_SESSION['admin_phone'] = $row[ "phone" ];
$_SESSION['admin_phone_alt'] = $row[ "phone_alt" ];
$_SESSION['admin_fax'] = $row[ "fax" ];
$_SESSION['admin_email'] = $row[ "email" ];
$_SESSION['site_logo'] = $row[ "logo" ];
$_SESSION['currency'] = $row[ "currency" ];
$_SESSION['serverdiff'] = $row[ "serverdiff" ];
$_SESSION['date_format'] = $row[ "date_format" ];
$_SESSION['overcolor'] = $row[ "overcolor" ];
$_SESSION['outcolor'] = $row[ "outcolor" ];
$_SESSION['lang'] = $row[ "language" ];
$_SESSION['allowed_ext'] = $row[ "file_ext" ];
$_SESSION['admin_aim'] = $row[ "aim" ];
$_SESSION['admin_msn'] = $row[ "msn" ];
$_SESSION['admin_yahoo'] = $row[ "yahoo" ];
$_SESSION['admin_icq'] = $row[ "icq" ];
$_SESSION['admin_skype'] = $row[ "skype" ];
$_SESSION['messages_active'] = $row[ "messages_active" ];
$_SESSION['clients_active'] = $row[ "clients_active" ];
$_SESSION['projects_active'] = $row[ "projects_active" ];
$_SESSION['files_active'] = $row[ "files_active" ];
$_SESSION['help_active'] = $row[ "help_active" ];
$_SESSION['upload_active'] = $row[ "upload_active" ];

$admin_website = '';

$query3 = " SELECT website FROM ttcm_websites WHERE client_id = '0' ORDER BY website";
$retid3 = $db_q($db, $query3, $cid);

while ( $row3 = $db_f($retid3) ) {
	$awebsite = $row3[ "website" ];
	$link_website = "http://" . $awebsite;
	$admin_website .= $link_website;
	$admin_website .= "<br />";
}
$_SESSION['admin_website'] = $admin_website;
?>