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
$query = " SELECT company, address1, address2, city, state, zip, country, phone, phone_alt, fax, aim, msn, yahoo, icq, skype,
logo, currency, serverdiff, def_aclient, def_aproject, def_projdone, def_atask, def_taskdone, def_invdone, def_ainvoice, 
date_format, overcolor, outcolor, language, messages_active, clients_active, projects_active, files_active, help_active, 
upload_active, version, file_ext FROM ttcm_admin WHERE company_id = '1' ";
$retid = $db_q($db, $query, $cid);

$row = $db_f($retid);
$_SESSION['admin_comapny'] = stripslashes($row[ "company" ]);
$_SESSION['admin_address1'] = stripslashes($row[ "address1" ]);
$_SESSION['admin_address2'] = stripslashes($row[ "address2" ]);
$_SESSION['admin_city'] = stripslashes($row[ "city" ]);
$_SESSION['admin_state'] = stripslashes($row[ "state" ]);
$_SESSION['admin_zip'] = $row[ "zip" ];
$_SESSION['admin_country'] = stripslashes($row[ "country" ]);
$_SESSION['admin_phone'] = $row[ "phone" ];
$_SESSION['admin_phone_alt'] = $row[ "phone_alt" ];
$_SESSION['admin_fax'] = $row[ "fax" ];
$_SESSION['admin_aim'] = $row[ "aim" ];
$_SESSION['admin_msn'] = $row[ "msn" ];
$_SESSION['admin_yahoo'] = $row[ "yahoo" ];
$_SESSION['admin_icq'] = $row[ "icq" ];
$_SESSION['admin_skype'] = $row[ "skype" ];
$_SESSION['site_logo'] = $row[ "logo" ];
$_SESSION['currency'] = $row[ "currency" ];
$_SESSION['serverdiff'] = $row[ "serverdiff" ];
$_SESSION['allowed_ext'] = $row[ "file_ext" ];
$_SESSION['default_acl'] = $row[ "def_aclient" ];
$_SESSION['default_apr'] = $row[ "def_aproject" ];
$_SESSION['default_prd'] = $row[ "def_projdone" ];
$_SESSION['default_ata'] = $row[ "def_atask" ];
$_SESSION['default_tad'] = $row[ "def_taskdone" ];
$_SESSION['default_ind'] = $row[ "def_invdone" ];
$_SESSION['default_ain'] = $row[ "def_ainvoice" ];
$_SESSION['date_format'] = $row[ "date_format" ];
$overcolor = $row[ "overcolor" ];
$outcolor = $row[ "outcolor" ];
$_SESSION['lang'] = $row[ "language" ];
$_SESSION['messages_active'] = $row[ "messages_active" ];
$_SESSION['clients_active'] = $row[ "clients_active" ];
$_SESSION['projects_active'] = $row[ "projects_active" ];
$_SESSION['files_active'] = $row[ "files_active" ];
$_SESSION['help_active'] = $row[ "help_active" ];
$_SESSION['upload_active'] = $row[ "upload_active" ];
$_SESSION['version'] = $row[ "version" ];

$overcheck = substr($overcolor, 0, 1);
$outcheck = substr($outcolor, 0, 1);

if ($overcheck != '#') {
	$_SESSION['overcolor'] = "#" . $overcolor;
}
else {
	$_SESSION['overcolor'] = $overcolor;
}
if ($outcheck != '#') {
	$_SESSION['outcolor'] = "#" . $outcolor;
}
else {
	$_SESSION['outcolor'] = $outcolor;
}

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
$vid = $_SESSION['valid_id'];
		
// PULL USER DATA FROM DATABASE
$query2 = "SELECT name, email, aim, msn, yahoo, icq, skype, permissions, address1, address2, city, state, zip, country, 
phone, phone_alt, fax FROM ttcm_user WHERE id = '" . $vid . "' ";
$retid2 = $db_q($db, $query2, $cid);

$row2 = $db_f($retid2);
$_SESSION['admin_name'] = stripslashes($row2[ "name" ]);
$_SESSION['user_email'] = $row2[ "email" ];
$_SESSION['aim_im'] = $row2[ "aim" ];
$_SESSION['msn_im'] = $row2[ "msn" ];
$_SESSION['yahoo_im'] = $row2[ "yahoo" ];
$_SESSION['icq_im'] = $row2[ "icq" ];
$_SESSION['skype_im'] = $row2[ "skype" ];
$_SESSION['skype_im'] = $row2[ "skype" ];
$_SESSION['user_address1'] = stripslashes($row2[ "address1" ]);
$_SESSION['user_address2'] = stripslashes($row2[ "address2" ]);
$_SESSION['user_city'] = stripslashes($row2[ "city" ]);
$_SESSION['user_state'] = stripslashes($row2[ "state" ]);
$_SESSION['user_zip'] = $row2[ "zip" ];
$_SESSION['user_country'] = stripslashes($row2[ "country" ]);
$_SESSION['user_phone'] = $row2[ "phone" ];
$_SESSION['user_phone_alt'] = $row2[ "phone_alt" ];
$_SESSION['user_fax'] = $row2[ "fax" ];
$user_permissions = $row2[ "permissions" ];

$_SESSION['perm_vars'] = $user_permissions;

?>