@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-video-practice-test.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')
    <!-- PRACTICE TEST -->
    <div class="container">
      <!-- Test Header -->
      <div class="test-header">
        <h1>Practice Test: Large Numbers</h1>
        <p>
          Test your knowledge about large numbers with these fun questions!
          Choose the correct answers and see how well you understand the
          concepts.
        </p>

        <div class="test-info">
          <div class="info-item">
            <i class="fas fa-question-circle"></i>
            <span>5 Questions</span>
          </div>
          <div class="info-item">
            <i class="fas fa-clock"></i>
            <span>Estimated time: 10 minutes</span>
          </div>
          <div class="info-item">
            <i class="fas fa-medal"></i>
            <span>Earn 25 points</span>
          </div>
        </div>
      </div>

      <!-- Progress Bar -->
      <div class="progress-container">
        <div class="progress-header">
          <div class="progress-title">Test Progress</div>
          <div class="progress-percent">20%</div>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
      </div>

      <!-- Questions -->
      <div class="questions-container">
        <!-- Question 1 -->
        <div class="question">
          <div class="question-header">
            <div class="question-number">1</div>
            <div class="question-text">
              What is the place value of 7 in the number 5,76,432?
            </div>
          </div>
          <div class="options-grid">
            <div class="option" data-question="1" data-option="a">
              <div class="option-label">A</div>
              <div class="option-text">7,000</div>
            </div>
            <div class="option" data-question="1" data-option="b">
              <div class="option-label">B</div>
              <div class="option-text">70,000</div>
            </div>
            <div class="option" data-question="1" data-option="c">
              <div class="option-label">C</div>
              <div class="option-text">700</div>
            </div>
            <div class="option" data-question="1" data-option="d">
              <div class="option-label">D</div>
              <div class="option-text">70</div>
            </div>
          </div>
        </div>

        <!-- Question 2 -->
        <div class="question">
          <div class="question-header">
            <div class="question-number">2</div>
            <div class="question-text">
              Which number is greater: 4,32,156 or 4,23,651?
            </div>
          </div>
          <div class="options-grid">
            <div class="option" data-question="2" data-option="a">
              <div class="option-label">A</div>
              <div class="option-text">4,32,156</div>
            </div>
            <div class="option" data-question="2" data-option="b">
              <div class="option-label">B</div>
              <div class="option-text">4,23,651</div>
            </div>
            <div class="option" data-question="2" data-option="c">
              <div class="option-label">C</div>
              <div class="option-text">Both are equal</div>
            </div>
            <div class="option" data-question="2" data-option="d">
              <div class="option-label">D</div>
              <div class="option-text">Cannot be determined</div>
            </div>
          </div>
        </div>

        <!-- Question 3 -->
        <div class="question">
          <div class="question-header">
            <div class="question-number">3</div>
            <div class="question-text">
              What is 1 million in the Indian numbering system?
            </div>
          </div>
          <div class="options-grid">
            <div class="option" data-question="3" data-option="a">
              <div class="option-label">A</div>
              <div class="option-text">10 lakh</div>
            </div>
            <div class="option" data-question="3" data-option="b">
              <div class="option-label">B</div>
              <div class="option-text">1 lakh</div>
            </div>
            <div class="option" data-question="3" data-option="c">
              <div class="option-label">C</div>
              <div class="option-text">1 crore</div>
            </div>
            <div class="option" data-question="3" data-option="d">
              <div class="option-label">D</div>
              <div class="option-text">10 crore</div>
            </div>
          </div>
        </div>

        <!-- Question 4 -->
        <div class="question">
          <div class="question-header">
            <div class="question-number">4</div>
            <div class="question-text">How do you write 9,87,654 in words?</div>
          </div>
          <div class="options-grid">
            <div class="option" data-question="4" data-option="a">
              <div class="option-label">A</div>
              <div class="option-text">
                Nine lakh eight-seven thousand six hundred fifty-four
              </div>
            </div>
            <div class="option" data-question="4" data-option="b">
              <div class="option-label">B</div>
              <div class="option-text">
                Ninety-eight thousand seven hundred sixty-four
              </div>
            </div>
            <div class="option" data-question="4" data-option="c">
              <div class="option-label">C</div>
              <div class="option-text">
                Nine crore eighty-seven lakh sixty-five thousand four
              </div>
            </div>
            <div class="option" data-question="4" data-option="d">
              <div class="option-label">D</div>
              <div class="option-text">
                Nine lakh eighty-seven thousand six hundred fifty-four
              </div>
            </div>
          </div>
        </div>

        <!-- Question 5 -->
        <div class="question">
          <div class="question-header">
            <div class="question-number">5</div>
            <div class="question-text">
              Which of these numbers comes after 99,999?
            </div>
          </div>
          <div class="options-grid">
            <div class="option" data-question="5" data-option="a">
              <div class="option-label">A</div>
              <div class="option-text">10,000</div>
            </div>
            <div class="option" data-question="5" data-option="b">
              <div class="option-label">B</div>
              <div class="option-text">99,100</div>
            </div>
            <div class="option" data-question="5" data-option="c">
              <div class="option-label">C</div>
              <div class="option-text">1,00,000</div>
            </div>
            <div class="option" data-question="5" data-option="d">
              <div class="option-label">D</div>
              <div class="option-text">9,99,999</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="submit-section">
        <button class="btn-submit" id="submitTest">Submit Test</button>
      </div>
    </div>

    <!-- Result Popup -->
    <div class="result-popup" id="resultPopup">
      <div class="result-content">
        <div class="result-icon">
          <i class="fas fa-medal"></i>
        </div>
        <h2 class="result-title">Test Completed!</h2>
        <div class="result-score">80%</div>
        <p class="result-message">
          Great job! You answered 4 out of 5 questions correctly.
        </p>
        <div class="result-actions">
          <a href="#" class="btn-result btn-review">
            <i class="fas fa-redo"></i> Review Answers
          </a>
          <a href="my-chapter-videos.html" class="btn-result btn-next">
            <i class="fas fa-arrow-right"></i> Next Lesson
          </a>
        </div>
      </div>
    </div>


        <script>
      // Initialize variables
      const totalQuestions = 5;
      let answeredQuestions = 0;

      // Update progress bar
      function updateProgress() {
        const percentage = Math.round(
          (answeredQuestions / totalQuestions) * 100
        );
        document.querySelector(
          ".progress-percent"
        ).textContent = `${percentage}%`;
        document.getElementById("progressFill").style.width = `${percentage}%`;
      }

      // Option selection
      const options = document.querySelectorAll(".option");
      options.forEach((option) => {
        option.addEventListener("click", function () {
          const questionNum = this.dataset.question;
          const allQuestionOptions = document.querySelectorAll(
            `.option[data-question="${questionNum}"]`
          );

          // Remove selected class from all options in this question
          allQuestionOptions.forEach((opt) => {
            opt.classList.remove("selected");
          });

          // Add selected class to clicked option
          this.classList.add("selected");

          // Check if this is the first time answering this question
          const wasAnswered = Array.from(allQuestionOptions).some((opt) =>
            opt.classList.contains("selected")
          );
          if (!wasAnswered) {
            answeredQuestions++;
            updateProgress();
          }
        });
      });

      // Submit test
      document
        .getElementById("submitTest")
        .addEventListener("click", function () {
          const selectedOptions =
            document.querySelectorAll(".option.selected").length;

          if (selectedOptions < totalQuestions) {
            alert(
              `Please answer all ${totalQuestions} questions before submitting!`
            );
            return;
          }

          // Show result popup
          document.getElementById("resultPopup").classList.add("active");
        });

      // Close popup if clicked outside
      document.addEventListener("click", function (e) {
        if (e.target.classList.contains("result-popup")) {
          document.getElementById("resultPopup").classList.remove("active");
        }
      });

      // Initialize progress bar
      document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
          document.getElementById("progressFill").style.width = "20%";
        }, 300);
      });
    </script>


@endsection