<!DOCTYPE HTML>  
<html>
<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["kommentareID"])) {
  $Geschlecht = $Vorname = $Nachname = $Kommentar = $Geburtsdatum= "";
  $lieblingsbetriebssystem = $KommentarDatum = $target_file = "";
  $Tier=array();
  
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "Gaestebuch";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $kid = $_GET["kommentareID"];
  $sql = "SELECT * FROM `kommentare` WHERE kommentareID = $kid";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  
  $Geschlecht = $row["Anrede"];
  $Vorname = $row["Vorname"];
  $Nachname = $row["Nachname"];
  $betriebssysteme = $row["Lieblingsbetribssystem"];
  $Geburtsdatum = $row["Geburtsdatum"];
  $target_file = $row["Bild"];
  //$Tier = explode(",", $row["Tiervorhanden"]);
  //$Tier = preg_split("/[\s,]+/", $row["Tiervorhanden"], -1, PREG_SPLIT_NO_EMPTY);
  $Tier = $row["Tiervorhanden"];
  $Kommentar = $row["Kommentar"];
  $KommentarDatum = $row["KommentarDatum"];
  $conn->close();
  
  $txtGeburtsdatum = "(Geboren am $Geburtsdatum)";
  if ($Geburtsdatum == "0000-00-00")
    $txtGeburtsdatum = "";
  else if ($Geburtsdatum == NULL)
    $txtGeburtsdatum = "";   
  
  $txtBetriebssystem = "Ihr Lieblingsbetriebssystem ist $betriebssysteme";
  if ($betriebssysteme == "")
    $txtBetriebssystem = "Sie haben keinen Lieblingsbetriebssystem";

  $txtTier = "Sie haben folgende Tiere: $Tier";
  if ($Tier == "")
    $txtTier = "Sie haben keine folgende Tiere";

  echo "<h2>Details</h2>",
     "$Geschlecht $Vorname $Nachname $txtGeburtsdatum", "<br>",
     "$txtBetriebssystem", "<br>",
     //"Sie haben folgende Tiere: " , join(",", $Tier), "<br>",
     //"Sie haben folgende Tiere: " , $Tier, "<br>",
     "$txtTier", "<br>",
     "Ihr Kommentar von $KommentarDatum lautet: <br><b>$Kommentar</b>", "<br>";
}
else {
  echo "Fehlerhafte Eingabe";
}

  ?>
</body>
</html>