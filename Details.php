<!DOCTYPE HTML>  
<html>
<body>
  <?php
  $Geschlecht = $Vorname = $Nachname = $Kommentar = $Geburtsdatum= "";
  $geschlechter = array('Herr', 'Frau', 'Divers');
  $betriebssysteme = array("Wählen Sie ein Betriebssystem!", "Windows", "Linux", "Apple");
  $tiere = array("Katze", "Hund", "Vogel", "Andere");
  $lieblingsbetriebssystem = $betriebssysteme[0];
  $Tier=array();
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "Gaestebuch";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "INSERT INTO kommentare (Anrede, Vorname, Nachname, Lieblingsbetribssystem, Tiervorhanden, Geburtsdatum, Kommentar)";
  $sql .= " values('$Geschlecht', '$Vorname', '$Nachname', '$lieblingsbetriebssystem','" .  join(",", $Tier) . "', '$Geburtsdatum', '$Kommentar');";
  if ($conn->query($sql) === TRUE) {
     //$last_id = $conn->insert_id;
     echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Ihre Eingabe:</h2>",
      "$Geschlecht $Vorname $Nachname <br>",
      "Ihr Lieblingsbetriebssystem ist $lieblingsbetriebssystem<br>",
      "Ihr Kommentar von $KommentarDatum lautet: <b>$Kommentar</b><br>";
     //"Sie haben folgende Tiere: "join(",", $Tier); 
  }
  ?>
<form action="_get.php" method="get"> </form>
</body>
</html>