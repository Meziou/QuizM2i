document.addEventListener('DOMContentLoaded', function() {
  let scoreCalc = 0;
  let currentQuestion = 0;
  let second = 10;
  let timer;
  let questions = [];
  const questionsContainer = document.getElementById("questions");
  const scoreContainer = document.getElementById("score");
  const timerContainer = document.getElementById("timer");
  const resultContainer = document.getElementById("result");
  const replayButton = document.getElementById("replay");
  const questionCountContainer = document.getElementById("question-count");
  const quizId = new URLSearchParams(window.location.search).get('id');

  async function fetchQuiz() {
    const response = await fetch(`quizGame.php?action=getQuestions&id=${quizId}`);
    const data = await response.json();
    return data;
  }

  function startQuiz(fetchedQuestions) {
    questions = fetchedQuestions;
    displayQuestion(questions[currentQuestion]);
    timer = setInterval(() => {
      if (second > 0) {
        second--;
        timerContainer.innerText = `${second}`;
      } else {
        nextQuestion();
      }
    }, 1000);
  }

  function displayQuestion(question) {
    questionCountContainer.innerText = `Question ${currentQuestion + 1}/${questions.length}`;
    questionsContainer.innerHTML = `
            <h3 class="question">${question.name}</h3>
            <div class="row mt-5">
                ${question.response.map((res, index) => `
                    <div class="col-6 ">
                        <button class="btn btn-outline-primary btn-answer w-100 mb-4" data-id="${index + 1}">${res}</button>
                    </div>
                `).join('')}
            </div>
        `;
    document.querySelectorAll('.btn-answer').forEach(button => {
      button.addEventListener('click', () => {
        document.querySelectorAll('.btn-answer').forEach(btn => btn.classList.remove('clicked', 'text-light'));
        button.classList.add('clicked', 'text-light');
        validateAnswer(question, button.dataset.id);
      });
    });
  }

  async function validateAnswer(question, selectedAnswer) {
    const response = await fetch('quizGame.php?action=checkAnswer', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        questionId: question.id,
        selectedAnswer: selectedAnswer
      })
    });
    const result = await response.json();

    if (result.correct) {
      scoreCalc++;
      resultContainer.innerText = "Bravo !";
      resultContainer.classList.add('correct');
      resultContainer.classList.remove('wrong');
    } else {
      resultContainer.innerText = "Dommage !";
      resultContainer.classList.add('wrong');
      resultContainer.classList.remove('correct');
    }

    resultContainer.style.display = "block";

    setTimeout(() => {
      resultContainer.innerText = "";
      resultContainer.classList.remove('correct', 'wrong');
      resultContainer.style.display = "none";
      nextQuestion();
    }, 1000);
  }

  function nextQuestion() {
    clearInterval(timer);
    second = 10;
    currentQuestion++;
    if (currentQuestion < questions.length) {
      displayQuestion(questions[currentQuestion]);
      timer = setInterval(() => {
        if (second > 0) {
          second--;
          timerContainer.innerText = `${second}`;
        } else {
          nextQuestion();
        }
      }, 1000);
    } else {
      endQuiz();
    }
  }

  function endQuiz() {
    questionCountContainer.innerHTML = "";
    questionsContainer.innerHTML = "";
    timerContainer.innerHTML = "";
    scoreContainer.innerHTML = `Vous avez marqué ${scoreCalc} points !`;
    replayButton.style.display = "block";
  }

  fetchQuiz().then(questions => startQuiz(questions));
});