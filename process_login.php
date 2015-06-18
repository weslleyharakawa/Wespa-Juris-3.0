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
session_start();

require( "includes/config.php" );
require( "includes/client.functions.php" );
require( "includes/sessions.php" );

if ($_POST['do'] == "login") {
	
	if (!$_POST["username"] || !$_POST["password"]) {
		Header("Location: index.php?log=nl");
	}
	
	$encpassword = $_POST['password'];
	
	$password = md5($encpassword);
	
		$SQL = "SELECT * FROM ttcm_user WHERE username = '$_POST[username]' AND password = '$password' ";
		$results = $db_q($db, $SQL, $cid);

		if ( $obj = @mysql_fetch_object($results) ) {
			
			$user_id = $obj->id;
			
			$SQL2 = "SELECT * FROM ttcm_user WHERE id = '$user_id' ";
			$retid2 = $db_q($db, $SQL2, $cid);
			$row2 = $db_f($retid2);
			$user_type = $row2[ "type" ];
			
			if ($user_type == '0') {
		
				// Login Valid, create session variable
				$_SESSION["valid_id"] = $user_id;
				$_SESSION["valid_cluser"] = $_POST["username"];
				$_SESSION["client_id"] = $obj->client_id;
				
				include("includes/session_defaults.php");
				include("includes/c_session_variables.php");
			}
			else if ($user_type == '1') {
				// Login O.K., create session variable
				$_SESSION['valid_id'] = $user_id;
				$_SESSION['valid_admin'] = 'admin';
				$_SESSION['valid_user'] = $_POST['username'];
				
				include("admin/includes/session_defaults.php");
				include("admin/includes/a_session_variables.php");
			}
			
			$query = " SELECT serverdiff FROM ttcm_admin WHERE company_id = '1' ";
			$retid = $db_q($db, $query, $cid);
			$row = $db_f($retid);
			$server_diff = $row[ "serverdiff" ];
			
			$last_login = date("Y/m/d G:i:s", time() + $server_diff * 60 * 60);
		
			mysql_query("UPDATE ttcm_user SET last_login = '" . $last_login . "' WHERE id = '" . $user_id . "'");
			
			include("includes/check_modules.php");
		
			if ($user_type == '0') {
				// Redirect to member page
				Header("Location: main.php?pg=main");
			}
			else if ($user_type == '1') {
				// Redirect to admin page
				Header("Location: admin/main.php?pg=main");
			}
		}
		else
		{
			// Login not successful
			Header("Location: index.php?log=np");
		} 
	}
?>