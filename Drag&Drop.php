<?php
$errormsg = "";
$target_dir = "bilder/";
$uploadOk = 1;

if(isset($_POST["submit"])) {
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check === false) {
    $errormsg .= "Datei ist kein Bild.<br>";
    $uploadOk = 0;
  }
  if (file_exists($target_file)) {
    $errormsg .= "Leider, das Bild existiert bereits.<br>";
    $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errormsg .= "Leider, Ihres Bild ist Groß.<br>";
    $uploadOk = 0;
  }
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $errormsg .= "Leider, nur JPG, JPEG, PNG & GIF sind erlaubt.<br>";
    $uploadOk = 0;
  }
  if ($uploadOk == 0) {
    $errormsg .= "Leider, Ihres Bild wurde nicht hochgeladen.<br>";
  } else {
    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $errormsg .=  "Leider, beim Hochladen Ihres Bild ist ein Fehler aufgetreten.";
    }
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Drag&Drop</title>
  <style>
  button, input[type='submit'], form input {
   background-color: blue;
   color: white;
   padding: 15px 30px;
   text-align: center;
   display: inline-block;
   font-size: 16px;
   }
   button:hover {
     background-color: lightblue;
     color: black;
   }
#div1, #div2 {
  width: 40%;
  /*height: 300px;*/
  margin: 10px;
  padding: 20px;
  border: 5px solid darkblue;
}
#div1 {
  float: left;
}
#div2 {
  float: right;
}
div img {
  width:50px;
  height:50px;
}
.mark {
  border: blue 3pt solid;
}
body {
  text-align: center;
}
</style>
<script>
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));
}  
  function moveImgTo(id) {
    var lstImg = document.querySelectorAll(".mark");
    for (let index = 0; index < lstImg.length; index++) {
      document.getElementById(id).appendChild(lstImg[index]);
    }
}
function mark(bild) {
  if (bild.className == "mark")
    bild.className = "";
  else
    bild.className = "mark";
}
</script>
</head>
<body>
<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
<?php
$dirhandle = opendir($target_dir);
while (($file = readdir($dirhandle)) !== false) {
  if (!in_array($file, array(".", "..", "DeckBlatt.gif", "Muster.gif")))
    echo "<img id='i$file' src='bilder/$file' draggable='true' ondragstart='drag(event)' onclick='mark(this)'/>";
}
closedir($dirhandle);
/*
for ($i=1; $i <= 102; $i++) { 
  echo "<img id='i$i' src='bilder/$i.gif' draggable='true' ondragstart='drag(event)' onclick='mark(this)'/>";
}*/
?>
</div>
<div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)">
</div>
<button onclick="moveImgTo('div2')">&rarr;</button>
<button onclick="moveImgTo('div1')">&larr;</button>

  <h1>Memory Spiel</h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
  <?php echo $errormsg; ?>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
  <section id="memory">
    <button class="start stop">Neues Spiel</button>
    Anzahl Versuche: <b id="AnzahlVersuche">0</b> / <b class="clock"></b><input id="clock">
    <div id="MemoryBord"></div>
  </section>
  </div>
  <script src="stoppuhr.js"></script>
  <script src="stoppuhrVM.js"></script>
  <script src="memoryspiel.js"></script>
</body>
</html>
