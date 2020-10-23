<?php
$target_dir = "bilder/";
$uploadOk = 1;
$GeschlechtErr = $VornameErr = $NachnameErr = $KommentarErr = "";
$Geschlecht = $Vorname = $Nachname = $Kommentar = $Geburtsdatum= "";
$sqlMeldung = $errormsg = "";
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
  // Check der Variable auf gültige Eingabe
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
  if(isset($_FILES["fileToUpload"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
      $errormsg .= "Datei ist kein Bild.<br>";
    }
   /* else if (file_exists($target_file)) {
      $errormsg .= "Leider, das Bild existiert bereits.<br>";
    }*/
    else if ($_FILES["fileToUpload"]["size"] > 250000) {
      $errormsg .= "Leider, Ihres Bild ist Groß.<br>";
    }
    else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $errormsg .= "Leider, nur JPG, JPEG, PNG & GIF sind erlaubt.<br>";
    }
    else {
      if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $errormsg .=  "Leider, beim Hochladen Ihres Bild ist ein Fehler aufgetreten.";
      }
    }
  }
  else {
    $target_file = NULL;
  }

  // Wenn keine Fehler dann speichern in DB
if (($GeschlechtErr . $VornameErr . $NachnameErr . $KommentarErr . $errormsg) == "") {

  $sql = "INSERT INTO kommentare (Anrede, Vorname, Nachname, Lieblingsbetribssystem, Tiervorhanden, Geburtsdatum, Kommentar, Bild)";
  $sql .= " values('$Geschlecht', '$Vorname', '$Nachname', '$lieblingsbetriebssystem','" .  join(",", $Tier) . "', '$Geburtsdatum', '$Kommentar', '$target_file');";
  if ($conn->query($sql) === TRUE) {
      //$last_id = $conn->insert_id;
      $sqlMeldung = "New record created successfully";
    } else {
      $sqlMeldung = "Error: " . $sql . "<br>" . $conn->error;
    }

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
img {
  width:50px;
  height:50px;
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
  padding: 8px 30px;
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
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
Geschlecht:
<input required type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Frau") echo "checked";?> value="Frau">Frau
<input required type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Herr") echo "checked";?> value="Herr">Herr
<input required type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Divers") echo "checked";?> value="Divers">Divers 
<span class="error">* <?php echo $GeschlechtErr;?></span>
  <br><br><br><br>
Vorname: <input required type="text" name="Vorname" value="<?php echo $Vorname;?>">
<span class="error">* <?php echo $VornameErr;?></span>
<br><br>
Nachname: <input required type="text" name="Nachname" value="<?php echo $Nachname;?>">
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
?>
<br><br><br>
Geburtsdatum: <input type="date" name="Geburtsdatum" value="<?php echo $Geburtsdatum;?>">
<br><br><br>
Kommentar: <textarea required name="Kommentar" rows="5" cols="30"><?php echo $Kommentar;?></textarea>
<span class="error">* <?php echo $KommentarErr;?></span>
<br><br>
  Bild:  <input type="file" name="fileToUpload" id="fileToUpload">
 <br><?php echo $errormsg; ?><br>
<button type="submit">Absenden</button>
 </form>

 <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $sqlMeldung, "<br>",
      "<h2>Ihre Eingabe:</h2>",
     "$Geschlecht $Vorname $Nachname <br>",
     "Ihr Kommentar lautet: <b>$Kommentar</b><br>";
 }
 ?>
 <?php
      $pagesize = 5;
      $firstpage = 1;
      $offset = 0;
      if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $firstpage = intval(empty($_GET["firstpage"])?1:$_GET["firstpage"]);
        $offset = intval(empty($_GET["offset"])?1:$_GET["offset"]);;
      }
      $page = intval($offset / 5) + 1;
      echo "<section><h1>Letzte Kommentare</h1> $offset : $page";
      $sql = "SELECT kommentareID, Anrede, Vorname,Nachname, Kommentar FROM kommentare limit $pagesize offset $offset";
      //'<a href="http://localhost/php/Gaestebuch.php?kommentarID=1" target="_blank">Detail-Link</a>';
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()) {
        $kid = $row["kommentareID"];
        echo "<p><a href='details.php?kommentareID=$kid' target='_blank'>",$row["Anrede"], " ", $row["Vorname"], " ", $row["Nachname"], " ", "</a><br>",
             "<b>", $row["Kommentar"], "</b></p>";
      }
      echo "</section>";

 ?>
 <br><br>
 <div class="pagination">
  <a href="http://localhost/php/vGB.php?offset=0"></a>
  <?php
   if ($firstpage > 1)  {
    $firstpage--;
    $offset = ($firstpage - 1) * $pagesize;
    echo "<a class='page-link' href= 'http://localhost/php/vGB.php?offset=$offset&firstpage=$firstpage' aria-label='Nächster'>",
          "<span class='sr-only'>Vorheriger</span>";
    $firstpage++;  
  }

  for ($i=$firstpage; $i < $firstpage + 5; $i++) { 
    $offset = ($i - 1) * $pagesize;
    if ($i == $page) {
      $aktiv = "class='active'";
    }
    else {
      $aktiv = "";
    }
    echo "<a $aktiv href='http://localhost/php/vGB.php?offset=$offset&firstpage=$firstpage'>$i</a>";
    }
  $offset = ($i - 1) * $pagesize;
  $firstpage++;
  if ($offset < 60)  {
    echo "<a class='page-link' href= 'http://localhost/php/vGB.php?offset=$offset&firstpage=$firstpage' aria-label='Nächster'>",
         "<span class='sr-only'>Nächster</span>";
  }
  $conn->close();
  ?>
  <a href="http://localhost/php/vGB.php?offset=45"></a>
</div>
</body>
</html>

