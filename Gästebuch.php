<!DOCTYPE HTML>  
<html>
<head>
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
  border: 21px solid darkgreen;
  font-size: 14px;
  font-family: 'serif';
}
button:hover {
  border: 2px solid black;
}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE TABLE MyGuests (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  Vorname VARCHAR(30) NOT NULL,
  Nachname VARCHAR(30) NOT NULL,
  Kommentar VARCHAR(500),
  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
$sql = "CREATE DATABASE myDB";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();

$GeschlechtErr = $VornameErr = $NachnameErr = "";
$Geschlecht = $Vorname = $Nachname = $Kommentar = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (empty($_POST["Geschlecht"])) {
  $GeschlechtErr = "Geschlecht ist Pflicht";
 } else {
  $Geschlecht = test_input($_POST["Geschlesht"]);
 }
  if (empty($_POST["Vorname"])) {
    $VornameErr = "Vorname ist Pflicht";
  } else {
    $Vorname = test_input($_POST["Vorname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$Vorname)) {
      $VornameErr = "nur Buchstaben erlaubt";
    }
  }
    if (empty($_POST["Nachname"])) {
      $NachnameErr = "Nachname ist Pflicht";
    } else {
      $Nachname = test_input($_POST["Nachname"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$Nachname)) {
        $NachnameErr = "nur Buchstaben erlaubt";
      }
    }
    if (empty($_POST["Kommentar"])) {
      $Kommentar = "";
    } else {
      $Kommentar = test_input($_POST["Kommentar"]);
    }
     
    if ($_POST["Tier"]) {
      $farben = $_POST["Tier"];
      echo "";
    }
   
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

  }
  ?>

<h2>Gästebuch</h2>
<p><span class="error">* Pflichtfeld</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Geschlecht:
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Frau") echo "checked";?> value="Frau">Frau
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Herr") echo "checked";?> value="Herr">Herr
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="divers") echo "checked";?> value="other">divers 
<span class="error">* <?php echo $GeschlechtErr;?></span>
  <br><br>
Vorname: <input type="text" name="Vorname" value="<?php echo $Vorname;?>">
<span class="error">* <?php echo $VornameErr;?></span>
<br><br>
Nachname: <input type="text" name="Nachname" value="<?php echo $Nachname;?>">
<span class="error">* <?php echo $NachnameErr;?></span>
<br><br>
<select name="Lieblings-Betriebssystem" onchange="zeigt(this.value)">
<option value="">Wählen ein Betriebssystem:</option>
<option value="1">Windows</option>
<option value="2">Linux</option>
<option value="3">Apple</option>
</select><br><br>
<p>Tier vorhanden?</p>
<input type="checkbox" name="Tier[]" value="Katze" /> Katze
<input type="checkbox" name="Tier[]" value="Hund" /> Hund
<input type="checkbox" name="Tier[]" value="Vogel" /> Vogel
<input type="checkbox" name="Tier[]" value="Andere" /> Andere
<br><br>
Geburtsdatum: <input type="date" name="Geburtsdatum"/><br><br>
Kommentar: <textarea name="Kommentar" rows="5" cols="30"><?php echo $Kommentar;?></textarea>
<br><br>
<button type="submit">Absenden</button>
 </form>
</body>
</html>