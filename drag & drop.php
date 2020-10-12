<!DOCTYPE HTML>
<html>
<head>
  <title>Drag & Drop</title>
<style>
#div1, #div2 {
  float: left;
  width: 300px;
  height: 300px;
  margin: 10px;
  padding: 20px;
  border: 5px solid darkblue;
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
</script>
</head>
<body>

<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
  <img 
</div>

<div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

</body>
</html>
