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

// GRAB CLIENT SESSION INFO
$client_id = $_SESSION['client_id'];
$vid = $_SESSION['valid_id'];
		
// PULL USER DATA FROM DATABASE
$query2 = " SELECT name, email, username, aim, msn, yahoo, icq, skype, permissions, address1, address2, city, state, zip, country, phone, phone_alt, fax 
FROM ttcm_user WHERE id = '" . $vid . "' ";
$retid2 = $db_q($db, $query2, $cid);

$row2 = $db_f($retid2);
$name = $row2[ "name" ];
$_SESSION['client_name'] = stripslashes($name);
$_SESSION['client_email'] = $row2[ "email" ];
$_SESSION['user_address1'] = stripslashes($row2[ 'address1' ]);
$_SESSION['user_address2'] = stripslashes($row2[ 'address2' ]);
$_SESSION['user_city'] = stripslashes($row2[ 'city' ]);
$_SESSION['user_state'] = stripslashes($row2[ 'state' ]);
$_SESSION['user_zip'] = $row2[ 'zip' ];
$_SESSION['user_country'] = stripslashes($row2[ 'country' ]);
$_SESSION['user_phone'] = $row2[ 'phone' ];
$_SESSION['user_phone_alt'] = $row2[ 'phone_alt' ];
$_SESSION['user_fax'] = $row2[ 'fax' ];
$_SESSION['client_username'] = $row2[ "username" ];
$_SESSION['aim_im'] = $row2[ "aim" ];
$_SESSION['msn_im'] = $row2[ "msn" ];
$_SESSION['yahoo_im'] = $row2[ "yahoo" ];
$_SESSION['icq_im'] = $row2[ "icq" ];
$_SESSION['skype_im'] = $row2[ "skype" ];
$user_permissions = $row2[ "permissions" ];

$_SESSION['perm_vars'] = $user_permissions;

// PULL CLIENT DATA
$query = " SELECT company, country, address1, address2, city, state, zip, phone, phone_alt, fax FROM ttcm_client WHERE client_id = '" . $client_id . "' ";
$retid = $db_q($db, $query, $cid);
	
$row = $db_f($retid);
$client_company = $row[ "company" ];
$_SESSION['client_company'] = stripslashes($client_company);
$client_country = $row[ "country" ];
$_SESSION['country'] = stripslashes($client_country);
$client_address1 = $row[ "address1" ];
$_SESSION['address1'] = stripslashes($client_address1);
$client_address2 = $row[ "address2" ];
$_SESSION['address2'] = stripslashes($client_address2);
$client_city = $row[ "city" ];
$_SESSION['city'] = stripslashes($client_city);
$client_state = $row[ "state" ];
$_SESSION['state'] = stripslashes($client_state);
$_SESSION['zip'] = $row[ "zip" ];
$_SESSION['phone'] = $row[ "phone" ];
$_SESSION['phone_alt'] = $row[ "phone_alt" ];
$_SESSION['fax'] = $row[ "fax" ];

?>