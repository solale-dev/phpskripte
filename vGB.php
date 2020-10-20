<?php
$target_dir = "bilder/";
$uploadOk = 1;
$GeschlechtErr = $VornameErr = $NachnameErr = $KommentarErr = "";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["Geschlecht"])) {
    $GeschlechtErr = "Geschlecht ist Pflicht";
  }
  else {
    $Geschlecht = test_input($_POST["Geschlecht"]);
  }
  if (empty($_POST["Vorname"])) {
    $VornameErr = "Vorname ist Pflicht";
  }
  else {
    $Vorname = test_input($_POST["Vorname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$Vorname)) {
      $VornameErr = "nur Buchstaben erlaubt";
    }
  }
  if (empty($_POST["Nachname"])) {
    $NachnameErr = "Nachname ist Pflicht";
  }
  else {
    $Nachname = test_input($_POST["Nachname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$Nachname)) {
      $NachnameErr = "nur Buchstaben erlaubt";
    }
  }
  if (empty($_POST["Kommentar"])) {
    $KommentarErr = "Kommentar ist pflicht";
  }
  else {
    $Kommentar = test_input($_POST["Kommentar"]);
    if (!preg_match("/^[a-zA-Z-' .0-9]*$/",$Kommentar)) {
      $KommentarErr = "nur Buchstaben erlaubt";
    }
  }
  if (!empty($_POST["Lieblings-Betriebssystem"]) && in_array($_POST["Lieblings-Betriebssystem"], $betriebssysteme)) {
    $lieblingsbetriebssystem = $_POST["Lieblings-Betriebssystem"];
  }
  if (isset($_POST["Tier"])) {
    foreach ($_POST["Tier"] as $value) {
      if (in_array($value, $tiere))
        $Tier[] = $value;
    }
  }
  if (isset($_POST["Geburtsdatum"])) {
    $Geburtsdatum = $_POST["Geburtsdatum"];
  }
// Wenn keine Fehler dann speichern in DB

$sql = "INSERT INTO kommentare (Anrede, Vorname, Nachname, Lieblingsbetribssystem, Tiervorhanden, Geburtsdatum, Kommentar)";
$sql .= " values('$Geschlecht', '$Vorname', '$Nachname', '$lieblingsbetriebssystem','" .  join(",", $Tier) . "', '$Geburtsdatum', '$Kommentar');";
if ($conn->query($sql) === TRUE) {
   //$last_id = $conn->insert_id;
   echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<!DOCTYPE HTML>  
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
input, select, textarea {
  border: 1px solid darkblue;
  box-sizing: border-box;
  font-size: 14px;
  font-family: 'serif';
  width: 300px;
  padding: 6px;
}
textarea {
  height: 250px;
}
input[type=text]:focus {background-color: lightblue;}
.error {color: red;}
button {
  height: 40px;
  background: green;
  color: white;
  border: 10px solid darkgreen;
  font-size: 14px;
  font-family: 'serif';
}
button:hover {
  border: 12px solid black;
}
.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
}

.pagination a.active {
  background-color: dodgerblue;
  color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
</head>
<body>
</style>
</head>
<body>
<h2>Gästebuch</h2>
<p><span class="error">* Pflichtfeld</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Geschlecht:
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Frau") echo "checked";?> value="Frau">Frau
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Herr") echo "checked";?> value="Herr">Herr
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Divers") echo "checked";?> value="Divers">Divers 
<span class="error">* <?php echo $GeschlechtErr;?></span>
  <br><br><br><br>
Vorname: <input type="text" name="Vorname" value="<?php echo $Vorname;?>">
<span class="error">* <?php echo $VornameErr;?></span>
<br><br>
Nachname: <input type="text" name="Nachname" value="<?php echo $Nachname;?>">
<span class="error">* <?php echo $NachnameErr;?></span>
<br><br><br>
<select name="Lieblings-Betriebssystem">
  <?php
  for ($i=0; $i < count($betriebssysteme); $i++) {
    $selected = "";
    if ($lieblingsbetriebssystem == $betriebssysteme[$i]) {
      $selected = " selected";
    }
    echo "<option$selected>$betriebssysteme[$i]</option>";
  }
  ?>
</select><br><br><br>
<p>Tier vorhanden?</p>
<?php
foreach ($tiere as $value) {
  $checked = "";
  if (!empty($Tier) && in_array($value, $Tier)) {
    $checked = " checked";
  }
  echo "<input type='checkbox' name=\"Tier[]\" value=\"$value\"$checked> $value";
}
/*
<input type="checkbox" name="Tier[]" value="Katze"> Katze
<input type="checkbox" name="Tier[]" value="Hund"> Hund
<input type="checkbox" name="Tier[]" value="Vogel"> Vogel
<input type="checkbox" name="Tier[]" value="Andere"> Andere
*/
?>
<br><br><br>
Geburtsdatum: <input type="date" name="Geburtsdatum" value="<?php echo $Geburtsdatum;?>">
<br><br><br>
Kommentar: <textarea name="Kommentar" rows="5" cols="30"><?php echo $Kommentar;?></textarea>
<span class="error">* <?php echo $KommentarErr;?></span>
<br><br>
<button type="submit">Absenden</button>
 </form>
 <?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   echo "<h2>Ihre Eingabe:</h2>",
     "$Geschlecht $Vorname $Nachname <br>",
     "Ihr Kommentar lautet: <b>$Kommentar</b><br>";
 }
 ?>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  <?php echo $target_dir = "bilder/"; ?>
  <input type="file" name="fileToUpload" id="fileToUpload">
</form>
 <br><br>
 <?php
      echo "<section><h1>Letzte Kommentare</h1>";
      $sql = "SELECT kommentareID, Anrede, Vorname,Nachname, Kommentar FROM kommentare limit 5 offset 10";
      //'<a href="http://localhost/php/Gaestebuch.php?kommentarID=1" target="_blank">Detail-Link</a>';
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()) {
        $kid = $row["kommentareID"];
        echo "<p><a href='details.php?kommentareID=$kid' target='_blank'>",$row["Anrede"], " ", $row["Vorname"], " ", $row["Nachname"], "</a><br>",
             "<b>", $row["Kommentar"], "</b></p>";
      }
      echo "</section>";
 $conn->close();
 ?>
 <div class="pagination">
  <a href="#">&laquo;</a>
  <a class="active" href="http://localhost/php/Gaestebuch.php?kommentarID=1">1</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">2</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">3</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">4</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">5</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">6</a>
  <a href="http://localhost/php/Gaestebuch.php?kommentarID=1">&raquo;</a>
</div>


</body>
</html>

