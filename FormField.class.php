<?php
/**
 * Die FormField - Klasse ist die objektorientierte Variante der einzelnen Formularfelder und soll dessen Erzeugung vereinfachen
 */

  class FormField
  {
  	public $FormFieldName;
	public $FormFieldType;
	public $Options;
	public $Maxlength;
	public $isRequired;
	
	/**
	 * Konstruktor der FormField - Klasse
	 * In diesem Konstruktor wird der Formularfeld - Typ ermittelt, der Name zusammengebastelt (entweder wird die Endung abgeschnitten oder es wird dabei belassen, dass die Endung nicht abgeschnitten werden muss)
	 * Es wird festgestellt ob es ein Pflichtfeld ist.
	 */
	function __construct($AttribName, $AttribType, $Null)
	{
		$this->FormFieldType = $this->generateType($AttribName, $AttribType);
		// Je nach Typ muss die Endung abgeschnitten werden, die zur Unterscheidung bei sonst nicht unterscheidbaren Feldern dient
		$this->FormFieldName = ($this->FormFieldType == Fieldtypes::Radiobutton || $this->FormFieldType == Fieldtypes::Select || $this->FormFieldType == Fieldtypes::Password) ? substr($AttribName, 0, -2) : $AttribName; 
		$this->isRequired = ($Null == "YES") ? false : true;
	}
	/**
	 * Generiert den Typ des Formularfeldes aufgrund des Datenfeldnamens und seines Typs (mit eventuell vorhandener Maximallänge des Inhalts)
	 */
	function generateType($AttribName, $AttribType)
	{
	// http://www.tutorials.de/php/254786-regex-problem-mit-klammern.html von hier habe ich das Pattern, das notwendig war
	/* In diesem Falle reagiert dieses Pattern auf Werte, die einen Wert vor einer Klammer oder auch in der Klammer haben. Bspw: int(10), int, 10
	Wichtig sind dabei die Platzhalter. Diese kann man dazu verwenden, Maximallänge und auch Datentyp herauszufinden */
		if(preg_match('/^(.*?)(\((.*?)\))$/', $AttribType, $m));
		{
			$type = substr($AttribName, -2);	// Der Typ wird bei gewissen aus den letzten beiden Zeichen ermittelt		
			$searchString = (empty($m)) ? $AttribType : $m[1]; // Wenn die Matches leer sind (das ist bei einfachen Datentypen der Fall), dann wird der übergebene Attributtype gewählt
			
		switch($searchString) // Das ist der Typ ganz ohne Maximallänge und dergleichen (wenn es, wie bei Date oder Text keine Länge gibt, dann muss man nur mit dem Datentyp arbeiten)
			{
				case'varchar':
				$this->Maxlength = $m[3]; // Das ist die Maximallänge des Strings
				    if($type == "_p")
					{
						return FieldTypes::Password;
					}
					return FieldTypes::Textfield;
				case'enum':
				$this->Options = explode(",", str_replace("'", "", $m[3]));	
					if($type == "_d")
					{
						return FieldTypes::Select;
					}
					else
					{
							return FieldTypes::Radiobutton;
					}
				case'tinyint':
					return FieldTypes::Checkbox;
				case 'int':
				$this->Maxlength = $m[3]; // Das ist die Maximallänge des Strings
					return FieldTypes::NumericField;
				case'text':
					return FieldTypes::Textarea;
				case 'date';
					return FieldTypes::DataField;
			}
			return FieldTypes::Textfield;
		}	
	}
/**
 * Fügt Attribute wie Maximallänge oder Pflicht hinzu
 */
	function addAttributes($String)
	{
			if($this->isRequired)
			{
				$String .= " required='required'";
			}
	
			if($this->Maxlength > 0)
			{
				$String .= " maxlength='" . $this->Maxlength . "'";
			}
			
			return $String . ">\n";
	}
	
	/**
	 * Generiert das Feld begründet auf den vorliegenden Daten
	 */
	function buildField()
	{
		$Beginning = "";
		$Adjunct = "";
		$Ending = "";

		switch($this->FormFieldType) // überprüft, welchen Typ das Formularfeld hat
		{
		// Innerhalb jedes Falls wird ein HTML-Tag zusammengestellt, der schlussendlich ausgegeben wird, wodurch schliesslich das Formular aufgebaut wird
			case FieldTypes::Textfield:
			{
				$Beginning = "<input type='text' class='form-control' name='tb" . $this->FormFieldName . "'";
				break;
			}
			
			case FieldTypes::NumericField:
			{
				$Beginning = "<input type='number' title='ganzzahliger Wert' pattern='\d*' class='form-control' name='tb" . $this->FormFieldName . "'";
				break;
			}
			
			case FieldTypes::DataField:
			{
			// Pattern for Dates http://stackoverflow.com/questions/17080963/html5-pattern-for-formating-input-box-to-take-date-mm-dd-yyy
				$Beginning = "<input type='date' title='dd/mm/yyyy oder dd.mm.yyyy' pattern='\d{1,2}.\d{1,2}.\d{4}' class='form-control' name='tb" . $this->FormFieldName . "'";
				break;
			}
			
			case FieldTypes::Password:
			{
				$Beginning = "<input type='password' class='form-control' name='pw" . $this->FormFieldName . "'";
				break;
			}
			
			case FieldTypes::Radiobutton:
			{
				foreach($this->Options as $key => $value) // Das durch Explode gebildete Array wird durchlaufen und mit Radiobutton-Tag in eine Variable gespeichert
				{
					$Beginning .= $value . addRadioLabels($this->FormFieldType, $value, $this->addAttributes("<input type='radio' name='r" . $this->FormFieldName . "[]' value='" . $key . "'"));
				}
				break;
			}
			
			case FieldTypes::Select:
			{
				$Beginning = $this->addAttributes("<select name='ddl" . $this->FormFieldName ."' class='form-control'");
				
				foreach($this->Options as $key => $value)
				{
					$Beginning .= "<option name='o" . $value . "' value='" . $key . "'>" . $value . "</option>\n";
				}
				$Ending = "</select>";
				
	            break;
			}
			
			case FieldTypes::Checkbox:
			{
				$Beginning = "<input type='checkbox' class='form-control' name='cb" . $this->FormFieldName . "'";
				break;
			}
			case FieldTypes::Textarea:
			{
				$Beginning = "<textarea name='txt" . $this->FormFieldName . "' class='form-control'";
				$Ending = "</textarea>";
				
				break;
			}
		}	
		
		if($this->FormFieldType != FieldTypes::Select && $this->FormFieldType != FieldTypes::Radiobutton) // Bei Select und Radiobutton müssen die Attributes früher hinzugefügt werden, weil sie sonst falsch positioniert sind
		{
			$Beginning = $this->addAttributes($Beginning);
		}
		
		echo addFormDivs($Beginning . $Ending, $this->FormFieldName, $this->FormFieldType); /* Dies ist eine Funktion, die lediglich dafür sorgt, dass die Divs, die für das Design notwendig sind, 
																							gesetzt werden. Für die Funktionalität spielt es tendenziell keine Rolle */
	}
  }
?>