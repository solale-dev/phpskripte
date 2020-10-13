
/*
function mOver(MemoryBord) {
  document.getElementById(MemoryBord).innerHTML = "MemoryBord"
}
function mOut(MemoryBord) {
  document.getElementById(MemoryBord).innerHTML = "bilder/DeckBlatt.gif"
}
function mFlip(bildindex, rückseite) {
  memoryspiel = document.getElementById("MemoryBord");
  bild = memoryspiel.getElementsByTagName("img")[bildindex];
  if (bild.src.indexOf(rückseite) > - 1) {
    bild.src = bilder[bildindex];
  }
  else {
    bild.src = rückseite;
  }
}
*/
var spielfeld = document.getElementById("MemoryBord");
var deckblatt = "bilder/DeckBlatt.gif";
var alternativbild = "bilder/Muster.gif";
var anzahlsekunden = 3;
var verschiedenbilder, bilder, aufgedecktesBild1, aufgedecktesBild2, entfernteBilder;
var sektimer;
function initMemory() {
  entfernteBilder = 0;
//  verschiedenbilder = document.getElementById("verschiedenbilder").value;
var div2 = document.getElementById("div2");
verschiedenbilder = div2.getElementsByTagName("img").length;
  document.getElementById("AnzahlVersuche").innerText = 0;
  if (verschiedenbilder < 2 || verschiedenbilder > 102) {
    alert("Wert nicht im Bereich 2 bis 102");
    verschiedenbilder = 18;
  }
  bilder = [];
  for (let i = 0; i < verschiedenbilder; i++) {
    let bild = div2.getElementsByTagName("img")[i];
    bilder[i] = bild.src;
  }
  bilder = bilder.concat(bilder);
  aufgedecktesBild1 = -1;
  aufgedecktesBild2 = -1;
}
function mischen(arr) {
  let rnd1, rnd2, xhelp;
  const len = arr.length;
  for (let i = 0; i < 100; i++) {
    rnd1 = Math.floor(Math.random() * len);
    rnd2 = Math.floor(Math.random() * len);
    xhelp = arr[rnd1];
    arr[rnd1] = arr[rnd2];
    arr[rnd2] = xhelp;
  }
}
function umdrehen() {
  if (bilder[aufgedecktesBild1] === bilder[aufgedecktesBild2]) {
    //entferne Bilder
    spielfeld.getElementsByTagName("img")[aufgedecktesBild1].src = "bilder/Muster.gif";
    spielfeld.getElementsByTagName("img")[aufgedecktesBild2].src = "bilder/Muster.gif";
    spielfeld.getElementsByTagName("img")[aufgedecktesBild1].onclick = "";
    spielfeld.getElementsByTagName("img")[aufgedecktesBild2].onclick = "";
    aufgedecktesBild2 = -1;
    aufgedecktesBild1 = -1;
    entfernteBilder++;
  }
  else {
    spielfeld.getElementsByTagName("img")[aufgedecktesBild1].src = deckblatt;
    spielfeld.getElementsByTagName("img")[aufgedecktesBild2].src = deckblatt;
    aufgedecktesBild2 = -1;
    aufgedecktesBild1 = -1;
    stop3SekTimer();
    if (entfernteBilder == verschiedenbilder - 1) {
      //gewonnen
      stoppTimer();
    }
  }
}
function start3SekTimer() {
  sektimer = setTimeout(umdrehen, anzahlsekunden * 1000);
}
function stop3SekTimer() {
  clearTimeout(sektimer);
}
function steuerung(that, bildnr) {
  let versuche = document.getElementById("AnzahlVersuche");
  if (bildnr === aufgedecktesBild1 || bildnr === aufgedecktesBild2) return; //nochmal auf Bild geklickt

  if (aufgedecktesBild1 === -1) { // erstes Bild
    aufgedecktesBild1 = bildnr;
    that.src = bilder[bildnr];
    return;
  }
  if (aufgedecktesBild2 === -1) { //zweites Bild
    aufgedecktesBild2 = bildnr;
    that.src = bilder[bildnr];
    if (entfernteBilder == verschiedenbilder - 1) {
      //gewonnen
      stoppTimer();
    }
    start3SekTimer();
    versuche.innerText++;
    return;
  }
  umdrehen();
  aufgedecktesBild1 = bildnr;
  that.src = bilder[bildnr];
}
function aufbauSpielfeld(anzBilder) {
  memory = document.getElementById("MemoryBord");
  memory.innerHTML = "";
  for (let index = 0; index < anzBilder; index++) {
    img = document.createElement("img");
    img.src = deckblatt;
    /*
    img.onclick = function () { steuerung(this, index) };
    img.onmouseover = function () { mFlip(index, deckblatt) };
    img.onmouseout = function () { mFlip(index, deckblatt) };
    */
    /* Zur Übung mouseover/-out
    img.addEventListener("mouseover", function () { mFlip(index, deckblatt)) });
    img.addEventListener("mouseout", function () { mFlip(index, deckblatt) });
    img.addEventListener("click", function () { steuerung(this, index) });
    */
    img.onclick = function () { steuerung(this, index) };
    memory.appendChild(img)
  }

}
startBtn.addEventListener('click', () => {
  zeitOffset=0;starteZeit(document.getElementById("clock"),2);
  stoppTimer();
  resetTimer();
  initMemory();
  mischen(bilder);
  aufbauSpielfeld(verschiedenbilder * 2);
});

