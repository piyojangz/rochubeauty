<?php
	session_start();
	if(!isset($_SESSION[LOGIN])){session_register("LOGIN");$_SESSION[LOGIN]=NULL;}
	if(!isset($_SESSION[STAFF_NAME])){session_register("STAFF_NAME");$_SESSION[STAFF_NAME]=NULL;}
	if(!isset($_SESSION[LAST_LOGIN])){session_register("LAST_LOGIN");$_SESSION[LAST_LOGIN]=NULL;}
	if(!isset($_SESSION[LAST_LOGOUT])){session_register("LAST_LOGOUT");$_SESSION[LAST_LOGOUT]=NULL;}
	if(!isset($_SESSION[USERNAME])){session_register("USERNAME");$_SESSION[USERNAME]=NULL;}
	if(!isset($_SESSION[WEB_LOGIN])){session_register("WEB_LOGIN");$_SESSION[WEB_LOGIN]=NULL;}
	if(!isset($_SESSION[CUSTOMER_ID])){session_register("CUSTOMER_ID");$_SESSION[CUSTOMER_ID]=NULL;}
?>