const questions = document.getElementsByTagName("h3");
const responses = document.getElementsByClassName("btn");
const answer1 = document.getElementsByClassName("answers1");
const answer2 = document.getElementsByClassName("answers2");
const answer3 = document.getElementsByClassName("answers3");
const answer4 = document.getElementsByClassName("answers4");
const score = document.getElementsByClassName("score");
let scoreCalc = 0;
let timmer = document.getElementById("timmer");
let count = 0;
let time = 0;
let second = 60;

fetch("quizGame.php")
  .then((response) => response.json())
  .then((data) => console.log(data))
  .catch((error) => console.error(error));

async function afficherQuiz() {
  try {
    const reponse = await fetch("quizGame.php");
    var data = await reponse.json();
    console.log(data);
  } catch (error) {
    console.error();
  }
}
afficherQuiz();

function timeDown() {
  time = setInterval(() => {
    timmer.innerHTML = `Timing: ${second} sec`;
    if (second > 0) {
      second--;
    } else {
      clearInterval(time);
    }
  }, 1000);
}
timeDown();
