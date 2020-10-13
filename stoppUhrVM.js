// Der zeitOffset dient der kurzfristigen Unterbrechung der StoppUhr mittels wartenZeit() und weiterZeit()
zeitOffset = 0;
/*
  Die Funktion starteZeit(...) startet eine StoppUhr. Die Zeit wird in dem Texteingabeelement txtZeitausgabe
  angezeigt. Mit txtZeitFormat können verschiedene Darstellungsformate für die vergangene Zeit ausgewählt werden.
    txtZeitausgabe --- Texteingabeelement für die Ausgabe
    txtZeitFormat  --- verschiedene Darstellungsformate
                       0 ---> Millisekunden
                       1 ---> Sekunden
                       2 ---> hh:mm:ss
*/
function starteZeit(txtZeitausgabe, txtZeitFormat) {
  // Überprüfen der Übergabeparameter
  formatZeit = (txtZeitFormat ? txtZeitFormat : 0);
  if (!txtZeitausgabe) {
    ausgabeZeit = null;
    formatZeit = -1;
  }
  else
    ausgabeZeit = txtZeitausgabe;

  zeitOffset -= (new Date()).getTime();
  stoppUhr = setInterval("zeitFkt()", 100);
}
/*
  Die Funktion beendeZeit() beendet die StoppUhr
*/
function beendeZeit() {
  if (stoppUhr) clearInterval(stoppUhr);
}
/*
  Die Funktion wartenZeit() stoppt/unterbricht die StoppUhr. Sie kann wieder gestartet werden mit weiterZeit()
*/
function wartenZeit() {
  beendeZeit();
  zeitOffset = gesMilliSekunden;
}
/*
  Die Funktion weiterZeit() startet die durch wartenZeit() unterbrochene StoppUhr wieder
*/
function weiterZeit() {
  starteZeit(ausgabeZeit, formatZeit);
}
/*
  Die Funktion zeitFkt() ist die periodisch aufgerufene Funktion, in der die vergangenen Sekunden entsprechend
  dem Darstellungsformat formatZeit ausgegeben wird
*/
function zeitFkt() {
  gesMilliSekunden = (new Date()).getTime() + zeitOffset;
  gesSekunden = Math.floor(gesMilliSekunden / 1000);
  switch (formatZeit) {
    case 2: ssZeit = gesSekunden % 60; // akt. Sekunden
      mmZeit = ((gesSekunden - ssZeit) / 60) % 60; // akt. Minuten
      hhZeit = (gesSekunden - ssZeit - mmZeit * 60) / 3600; // akt. Stunden
      ausgabeZeit.value = ((hhZeit < 10) ? "0" : "") + hhZeit + ":" +
        ((mmZeit < 10) ? "0" : "") + mmZeit + ":" +
        ((ssZeit < 10) ? "0" : "") + ssZeit;
      break;

    case 1: ausgabeZeit.value = gesSekunden;
      break;

    case 0:
      tsdMills = Math.floor(gesMilliSekunden / 1000);
      millis = Math.floor(gesMilliSekunden % 1000);
      ausgabeZeit.value = gesMilliSekunden.toLocaleString("de-DE");//tsdMills == 0 ? millis : tsdMills + "." + millis;
      break;

    default:
  }
}

