<?php
    define("MYSQLHOST", "localhost");
	define("MYSQLUSER", "root");
	define("MYSQLPASSWORD", "");
	define("MYSQLDB", "Formulargenerator");
	
	$Connection = mysqli_connect(MYSQLHOST, MYSQLUSER, MYSQLPASSWORD);
	
	// Verbindung zu MySQL
	if(!$Connection)
	{
		echo "Keine Verbindung zu MySQL möglich.";
	}
	
	// Wählen der Datenbank
	if(!$Connection->select_db(MYSQLDB))
	{
		echo "Keine Verbindung zur Datenbank möglich.";
	}
	
	// Setzen des Charsets bei allfälligen Umlauten
	if (!$Connection->set_charset("utf8")) {
		echo "Setzen des Charsets nicht möglich";
	}
	
?>