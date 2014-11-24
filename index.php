<?php
	// MySQL - Anbindung
    include "mysqlconfig.inc.php";
	// Enumeration Fieldtypes
	include "fieldtypes.class.php";
	// Zusätzliche Funktionen (dem Style zuträglich, notwendige Divs und Klassen für gute Strukturierung)
	include "functions.inc.php";
	// Die FormField - Klasse
	include "FormField.class.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulargenerator</title>

	<link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>
 <div class="navbar navbar-inverse navbar fixed-top" role="navigation">
  <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="#">Formulargenerator</a>
        </div>
      </div>
 </div>
<div class="container">
    <div class="page-header">
        <h1>Formulargenerator</h1>
      </div>
<div class="jumbotron">

<form action="index.php" method="post">
<div class="form-group">
<label for="lblFormName">Welches Formular möchtest du gerne generieren?</label>

<select name="sFormularname" class='form-control'>
<?php 
	$TABLES = $Connection->query("SHOW TABLES FROM " . MYSQLDB);
	// Der vorangegangene SQL - Befehl zeigt alle Tabellen, die sich innerhalb der DB befinden.
	// Mittels mysqli_fetch_array sammelt man diese innerhalb eines Arrays
	while ($table = mysqli_fetch_array($TABLES))
	{
		echo "<option value=". $table[0] .">".$table[0]."</option>";
	}
?>
</select>
</div>

<div class="form-group">
<input type="submit" class='btn btn-success' name="submit" value="generieren">
</div>
</form>
<!-- Start zu kopierender Quellcode - automatisch generiertes Formular -->

<?php 
if(array_key_exists('sFormularname', $_POST))
{
?>
<h2><?php echo $_POST["sFormularname"]; ?></h2>
  <form onSubmit="return false;" method="post" class='form-horizontal' role="form">
	<?php	
	$COLUMNS = $Connection->query("SHOW COLUMNS FROM " . $_POST["sFormularname"]);
	// Es findet eine Abfrage aller Columns innerhalb der gewählten Tabelle statt. 
	// Diese werden in ein Array "gesteckt", welches die wichtigsten Daten für unser Formularfeld enthält (nullable, Type, Fieldname).
	while($data = mysqli_fetch_array($COLUMNS))
	{
		if(strcasecmp($data['Field'], "id") != 0) {
		// strcasecmp ist eine Funktion, die nicht case sensitiv überprüft, ob der Name eines Attributes id ist. In diesem Fall erstellt er kein Formularfeld. Ansonsten schon.
		$FormField = new FormField($data['Field'], $data['Type'], $data['Null']);
		$FormField->buildField();	}
	}
	?>
	   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Abschicken</button>
	  <button type='cancel' class='btn btn-default'>Cancel</button>
    </div>
	</div>
	</form>
<!-- Ende zu kopierender Quellcode - automatisch generiertes Formular -->
<?php
}
?>
</div>
</div>
	
    <!-- jQuery (wird für Bootstrap JavaScript-Plugins benötigt) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

