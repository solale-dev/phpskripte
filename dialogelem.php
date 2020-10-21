<?php
/*
Funktionen die verschiedene Eingabedialogelemente für HTML-Formulare zurückgeben
--------------------------------------------------------------------------------
*/

// Testen ob die Funktionen auch funktionieren, wenn Referenzen übergeben werden

/*
Die Funktion txtFeld gibt ein input-Textfeld zurück
    $name    --- Name
    $wert    --- Standardwert
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $groesse --- Größe des Textfeldes(30)
    $maxanz  --- max. Anzahl der Zeichen(50)
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function txtFeld($name, $wert="", $titel="", $klasse="", $groesse=30, $maxanz=50, $weitere="") {
  $txtfeld = "<input name='$name'";
  if (!empty($wert))
    $txtfeld .= " value='$wert'";
  if (!empty($groesse) AND is_integer($groesse))
    $txtfeld .= " size='$groesse'";
  if (!empty($maxanz) AND is_integer($maxanz))
    $txtfeld .= " maxlength='$maxanz'";
  if (!empty($titel))
    $txtfeld .= " title='$titel'";
  if (!empty($klasse))
    $txtfeld .= " class='$klasse'";
  $txtfeld .= " $weitere />";
  return $txtfeld;
}
/*
Die Funktion pssFeld gibt ein input-Passwortfeld zurück
    $name    --- Name
    $wert    --- Standardwert
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $groesse --- Größe des Textfeldes(30)
    $maxanz  --- max. Anzahl der Zeichen(50)
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function pssFeld($name, $wert="", $titel="", $klasse="", $groesse=30, $maxanz=50, $weitere="") {
  $pssfeld = "<input type='password' name='$name'";
  if (!empty($wert))
    $pssfeld .= " value='$wert'";
  if (!empty($groesse) AND is_integer($groesse))
    $pssfeld .= " size='$groesse'";
  if (!empty($maxanz) AND is_integer($maxanz))
    $pssfeld .= " maxlength='$maxanz'";
  if (!empty($titel))
    $pssfeld .= " title='$titel'";
  if (!empty($klasse))
    $pssfeld .= " class='$klasse'";
  $pssfeld .= " $weitere />";
  return $pssfeld;
}
/*
Die Funktion hdnFeld gibt ein input-Hiddenfeld zurück
    $name    --- Name
    $wert    --- Standardwert
*/
function hdnFeld($name, $wert) {
  return "<input type='hidden' name='$name' value='$wert' />";
}
/*
Die Funktion chkBox gibt ein Kontrollkästchen bzw. eine Checkbox zurück
    $name    --- Name
    $wert    --- Übertragener Wert bei Aktivierung
    $check   --- Aktivierung(false)
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function chkBox($name, $wert="On", $check=false, $titel="", $klasse="", $weitere="") {
  $chkbox = "<input type='checkbox' name='$name'";
  if ($wert != "On")
    $chkbox .= " value='$wert'";
  if ($check)
    $chkbox .= " checked='checked'";
  if (!empty($titel))
    $chkbox .= " title='$titel'";
  if (!empty($klasse))
    $chkbox .= " class='$klasse'";
  $chkbox .= " $weitere />";
  return $chkbox;
}
/*
Die Funktion optFeld gibt ein Optionsfeld zurück
    $name    --- Name
    $wert    --- Übertragener Wert bei Aktivierung
    $check   --- Aktivierung(false)
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function optFeld($name, $wert="On", $check=false, $titel="", $klasse="", $weitere="") {
  $optfeld = "<input type='radio' name='$name'";
  if ($wert != "On")
    $optfeld .= " value='$wert'";
  if ($check)
    $optfeld .= " checked='checked'";
  if (!empty($titel))
    $optfeld .= " title='$titel'";
  if (!empty($klasse))
    $optfeld .= " class='$klasse'";
  $optfeld .= " $weitere />";
  return $optfeld;
}
/*
Die Funktion optGruppe gibt ein Reihe von Optionen zurück, aus denen eine ausgewählt werden kann
    $name    --- Name
    $lstOpt  --- Liste der verschiedenen Optionswerte, die gleichzeitig auch angezeigt werden
    $wert    --- aktivierter Optionswert
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function optGruppe($name, $optlst, $wert="", $titel="", $klasse="", $weitere="") {
  $optgruppe="\n";
  foreach($lstOpt as $element) {
    $optgruppe .= "$element " . optFeld($name, $element, $element==$wert, $titel, $klasse, $weitere) . "<br />\n";
  }
  return $optgruppe;
}
/*
Die Funktion btnSubmit gibt einen Submit-Button zurück
    $name    --- Name (aktion)
    $wert    --- Anzeigetext auf dem Button (Absenden)
    $klasse  --- Klassenname des Stylesheets 
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte 
*/
function btnSubmit($name="aktion", $wert="Absenden", $klasse="", $weitere="") {
  return "<input type='submit' name='$name' value='$wert' class='$klasse' $weitere />";
}
/*
Die Funktion btnReset gibt einen Reset-Button zurück
    $wert    --- Anzeigetext auf dem Button(Zurücksetzen)
    $klasse  --- Klassenname des Stylesheets 
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte 
*/
function btnReset($wert="Zur&uuml;cksetzen", $klasse="reset", $weitere="") {
  return "<input type='reset' value='$wert' class='$klasse' $weitere />";
}
/*
Die Funktion cmbFeld gibt ein einzeiliges Kombinationsfeld zurück
    $name    --- Name
    $liste   --- Liste der Anzeigeelemente
    $wert    --- aktivierter Wert
    $titel   --- Anzeigetitel
    $klasse  --- Klassenname des Stylesheets
    $weitere --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function cmbFeld($name, $liste, $wert="", $titel="", $klasse="", $weitere=""){
  $cmbfeld = "<select name='$name'";
  if (!empty($titel))
    $cmbfeld .= " title='$titel'";
  if (!empty($klasse))
    $cmbfeld .= " class='$klasse'";
  $cmbfeld .= " $weitere>\n";
  
  foreach($liste as $element) {
    $cmbfeld .= "  <option";
    if ($element == $wert)
      $cmbfeld .= " selected='selected'";
    $cmbfeld .= ">$element</option>\n";
  }
  $cmbfeld .= "</select>\n";

  return $cmbfeld;
}
/*
Die Funktion lstFeld gibt ein mehrzeiliges Listenfeld mit mehrfacher Auswahlmöglichkeit zurück
    $name      --- Name
    $lstGesamt --- Liste aller Anzeigeelemente
    $lstWerte  --- Liste aller aktivierten Werte
    $titel     --- Anzeigetitel
    $klasse    --- Klassenname des Stylesheets
    $zeilenanz --- Anzahl der angezeigten Zeilen
    $weitere   --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function lstFeld($name, $lstGesamt, $lstWerte=array(), $titel="", $klasse="", $zeilenanz=8, $weitere="") {
  $lstfeld = "<select name='$name"."[]' multiple='multiple' size='$zeilenanz'";
  if (!empty($titel))
    $lstfeld .= " title='$titel'";
  if (!empty($klasse))
    $lstfeld .= " class='$klasse'";
  $lstfeld .= " $weitere>\n";
  
  if (!is_array($lstWerte))
    $lstWerte=array();
  foreach($lstGesamt as $element) {
    $lstfeld .= "  <option";
    if (in_array($element, $lstWerte))
      $lstfeld .= " selected='selected'";
    $lstfeld .= ">$element</option>\n";
  }
  $lstfeld .= "</select>\n";

  return $lstfeld;
}
/*
Die Funktion txtBereich gibt einen textarea-Bereich zurück
    $name       --- Name
    $wert       --- Standardtext im Textbereich
    $titel      --- Anzeigetitel
    $klasse     --- Klassenname des Stylesheets
    $spaltenanz --- Spaltenanzahl
    $zeilenanz  --- Zeilenanz
    $weitere    --- beliebiger String für die weitere Eingabe beliebiger Attribute+Werte
*/
function txtBereich($name, $wert="", $titel="", $klasse="", $spaltenanz=30, $zeilenanz=8, $weitere="") {
  $txtbereich = "<textarea name='$name'";
  if (!empty($titel))
    $txtbereich .= " title='$titel'";
  if (!empty($klasse))
    $txtbereich .= " class='$klasse'";
  $txtbereich .= " cols='$spaltenanz' rows='$zeilenanz' $weitere>$wert</textarea>\n";
  return $txtbereich;
}
?>
