document.addEventListener("DOMContentLoaded", () => {
  const quizContainer = document.getElementById("quiz-container");
  const submitBtn = document.getElementById("submit-btn");
  const resultDiv = document.getElementById("result");

  let questions = [];

  fetch("http://localhost:8000/api/questions")
    .then((response) => response.json())
    .then((data) => {
      questions = data;
      renderQuestions(questions);
    })
    .catch((err) => {
      quizContainer.innerHTML =
        "<p>Error loading questions. Is the backend running?</p>";
      console.error(err);
    });

  function renderQuestions(questions) {
    quizContainer.innerHTML = "";
    questions.forEach((q) => {
      const block = document.createElement("div");
      block.className = "question-block";
      let inputHtml = "";

      if (q.type === "multiple_choice") {
        inputHtml = q.options
          .map(
            (opt, idx) =>
              `<label><input type="radio" name="q${q.id}" value="${idx}"> ${opt}</label>`,
          )
          .join("");
      } else if (q.type === "true_false") {
        inputHtml = `
                <label><input type="radio" name="q${q.id}" value="true"> True</label>
                <label><input type="radio" name="q${q.id}" value="false"> False</label>
            `;
      } else if (q.type === "short_answer") {
        inputHtml = `<input type="text" name="q${q.id}" class="text-answer" placeholder="Your answer...">`;
      }

      block.innerHTML = `
            <div class="question-text">${q.id}. ${q.text}</div>
            <div class="options">${inputHtml}</div>
        `;
      quizContainer.appendChild(block);
    });
  }

  submitBtn.addEventListener("click", () => {
    const answers = {};
    questions.forEach((q) => {
      if (q.type === "short_answer") {
        const input = document.querySelector(`input[name="q${q.id}"]`);
        if (input && input.value.trim() !== "") {
          answers[q.id] = input.value;
        }
      } else {
        const selected = document.querySelector(
          `input[name="q${q.id}"]:checked`,
        );
        if (selected) {
          answers[q.id] = selected.value;
        }
      }
    });

    fetch("http://localhost:8000/api/submit", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ answers }),
    })
      .then((res) => res.json())
      .then((result) => {
        if (result.percentage !== undefined) {
          resultDiv.innerHTML = `You scored ${result.score} out of ${result.total} (${result.percentage}%) - ${result.passed ? "Pass" : "Fail"}`;
        } else if (result.result) {
          resultDiv.innerHTML = `Score: ${result.score}/${result.total} - ${result.result}`;
        } else {
          resultDiv.innerHTML = JSON.stringify(result);
        }
        resultDiv.classList.remove("hidden");
        submitBtn.disabled = true;
      })
      .catch((err) => {
        resultDiv.innerHTML = "Error submitting answers.";
        console.error(err);
      });
  });
});
