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

	// Create query
	$SQL2 = "SELECT module_id, installed, active FROM ttcm_modules ";
	$result2 = $db_q($db, $SQL2, $cid);
		
		while ($row2 = $db_f($result2)) {
			$module_id = $row2[ "module_id" ];
			$mod_installed = $row2[ "installed" ];
			$mod_active = $row2[ "active" ];
			
			$session_inst = "mod" . $module_id . "_installed";
			$session_active = "mod" . $module_id . "_active";
			
			$_SESSION[$session_inst] = $mod_installed;
			$_SESSION[$session_active] = $mod_active;
		}
?>