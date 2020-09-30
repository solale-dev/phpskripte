<!DOCTYPE HTML>  
<html>
<head>
<style>
input, select, textarea {
  border: 1px solid darkblue;
  box-sizing: border-box;
  font-size: 2px;
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
  font-size: 2px;
  font-family: 'serif';
}
button:hover {
  border: 2px solid black;
}
</style>
</head>
<body>

<?php
$GeschlechtErr = $VornameErr = $NachnameErr = "";
$Geschlecht = $Vorname = $Nachname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 if (empty($_POST["Geschlecht"])) {
  $GeschlechtErr = "Geschlecht ist Pflicht";
 } else {
  $Geschlecht = test_input($_POST["Geschlesht"]);
 }
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
    if (empty($_POST["Kommenter"])) {
      $Kommenter = "";
    } else {
      $Kommenter = test_input($_POST["Kommenter"]);
    }
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    ?>

<h2>Gästebuch</h2>
<p><span class="error">* Pflichtfeld</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Geschlecht:
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Frau") echo "checked";?> value="Frau">Frau
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="Herr") echo "checked";?> value="Herr">Herr
<input type="radio" name="Geschlecht"<?php if (isset($Geschlecht) && $Geschlecht=="other") echo "checked";?> value="other">Other  
<span class="error">* <?php echo $GeschlechtErr;?></span>
  <br><br>
Vorname: <input type="text" name="Vorname" value="<?php echo $Vorname;?>">
<span class="error">* <?php echo $VornameErr;?></span>
<br><br>
Nachname: <input type="text" name="Nachname" value="<?php echo $Nachname;?>">
<span class="error">* <?php echo $NachnameErr;?></span>
<br><br>
kommenter: <textarea name="Kommenter" rows="5" cols="30"><?php echo $Kommenter;?></textarea>
<br><br>
<select name="Lieblings Betribssystem" onchange="zeigt(this.value)">
<option value="">wählen ein Betribssystem:</option>
<option value="1">Windows</option>
<option value="2">Linux</option>
<option value="3">Apple</option>
</select><br><br>
<select name="Tier vorhanden" onchange="zeigt(this.value)">
<option value="">Tier:</option>
<option value="1">Katze</option>
<option value="2">Hund</option>
<option value="3">andere</option>
</select><br><br>
Geburtsdatum: <input type="date" name="Geburtsdatum"/><br><br>
<button type="submit">Absend</button> 
</form>
</body>
</html>