let secondCount = 0;
let stopWatch;

const displayPara = document.querySelector('.clock');
function displayCount() {
  let hours = Math.floor(secondCount / 3600);
  let minutes = Math.floor((secondCount % 3600) / 60);
  let seconds = Math.floor(secondCount % 60);
  let displayHours = (hours < 10) ? '0' + hours : hours;
  let displayMinutes = (minutes < 10) ? '0' + minutes : minutes;
  let displaySecounds = (seconds < 10) ? '0' + seconds : seconds;
  displayPara.textContent = displayHours + ':' + displayMinutes + ':' + displaySecounds;
  secondCount++;
}
function stoppTimer() {
  clearInterval(stopWatch);
}
function resetTimer() {
  secondCount = 0;
  displayCount();
}
const startBtn = document.querySelector('.start');
const stopBtn = document.querySelector('.stop');
const resetBtn = document.querySelector('.reset');
startBtn.addEventListener('click', () => {
  stopWatch = setInterval(displayCount, 1000);
});
