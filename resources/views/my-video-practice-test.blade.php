@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-video-practice-test.css') }}" />

<style>
  .sticky-cta {
    display: none !important;
  }
</style>

<link
  href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
  rel="stylesheet" />

@section('content')
<!-- PRACTICE TEST -->
<div class="container">
  <!-- Test Header -->
  <div class="test-header">
    <h1>Practice Test: {{ $chapter->name }} - {{ $chapter->class->name }}</h1>
    <p>
      Test your knowledge about " <strong>{{ $chapter->name }}</strong> " with these fun questions!
      Choose the correct answers and see how well you understand the
      concepts.
    </p>

    <div class="test-info">
      <div class="info-item">
        <i class="fas fa-question-circle"></i>
        <span>{{ count($questions) }} Questions</span>
      </div>
      <div class="info-item">
        <i class="fas fa-clock"></i>
        <span>Estimated time: 10 minutes</span>
      </div>
      <div class="info-item">
        <i class="fas fa-medal"></i>
        <span>Earn {{ count($questions) * 2 }} points</span>
      </div>
    </div>
  </div>

  <!-- Test Form Start -->
  <form id="practiceTestForm">
    <!-- Progress Bar -->
    <div class="progress-container">
      @if ($submittedTest === null)
      <div class="progress-header">
        <div class="progress-title">Test Progress</div>
        <div class="progress-percent">0%</div>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill"></div>
      </div>
      @else
      <div class="progress-header">
        <div class="progress-title">Test Completed (Marks : {{ $submittedTest->score }})</div>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" id="progressFill2" style="width: 100%"></div>
      </div>
      @endif
    </div>

    <!-- Questions -->
    <div class="questions-container">
      @foreach ($questions as $index => $question)
      <div class="question mb-4">
        <div class="question-header">
          <div class="question-number">{{ $loop->iteration }}</div>
          <div class="question-text">{{ $question }} ?</div>
        </div>

        @php
        $options = $answers[$index] ?? [];
        $optionLabels = ['A', 'B', 'C', 'D'];
        $selectedAnswer = $submittedTest->student_answers[$index] ?? null;
        @endphp

        <div class="options-grid mt-2">
          @foreach ($options as $optionIndex => $optionText)
          <div class="option {{ $selectedAnswer == $optionText ? 'selected' : '' }}"
            data-question="{{ $loop->parent->iteration }}"
            data-option="{{ strtolower($optionLabels[$optionIndex] ?? '') }}">
            <div class="option-label">{{ $optionLabels[$optionIndex] ?? '' }}</div>
            <div class="option-text">{{ $optionText }}</div>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    <!-- Submit Button -->
    @if ($submittedTest === null)
    <div class="submit-section">
      <button type="submit" class="btn-submit" id="submitTest">Submit Test</button>
    </div>
    @endif
  </form>
  <!-- Test Form End -->
</div>


<!-- Result Popup -->
<div class="result-popup" id="resultPopup">
  <div class="result-content">
    <div class="result-icon"><i class="fas fa-medal"></i></div>
    <h2 class="result-title">Test Completed!</h2>
    <div class="result-score">0</div>
    <p class="result-message"></p>
    <div class="result-actions">
      <a href="{{ route('student.my-video-practice-test.result', [$class->id, $subject->id, $chapter->id, $video->id]) }}" class="btn-result btn-review"><i class="fas fa-redo"></i> Review Answers</a>
      <a href="{{ route('student.my-chapter-videos', ['classId' => $class->id,'subjectId'=> $subject->id,'chapterId' => $chapter->id]) }}" class="btn-result btn-next"><i class="fas fa-arrow-right"></i> Next Lesson</a>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    const totalQuestions = {{count($questions)}};
    let answeredQuestions = 0;

    // Update progress bar
    function updateProgress() {
      const percentage = Math.round((answeredQuestions / totalQuestions) * 100);
      document.querySelector(".progress-percent").textContent = `${percentage}%`;
      document.getElementById("progressFill").style.width = `${percentage}%`;
    }

    // Option click
    const options = document.querySelectorAll(".option");
    options.forEach(option => {
      option.addEventListener("click", function() {
        const questionNum = this.dataset.question;
        const allQuestionOptions = document.querySelectorAll(`.option[data-question="${questionNum}"]`);
        allQuestionOptions.forEach(opt => opt.classList.remove("selected"));
        this.classList.add("selected");

        // Count answered questions (one per question)
        answeredQuestions = document.querySelectorAll(".question .option.selected").length;
        updateProgress();
      });
    });

    // Submit form
    document.getElementById("practiceTestForm").addEventListener("submit", function(e) {
      e.preventDefault();

      // Collect answers
      const answers = [];
      for (let i = 1; i <= totalQuestions; i++) {
        const selectedOption = document.querySelector(`.option[data-question="${i}"].selected`);
        if (selectedOption) {
          answers.push(selectedOption.querySelector(".option-text").textContent.trim());
        } else {
          alert(`Please answer all ${totalQuestions} questions before submitting!`);
          return;
        }
      }

      // AJAX request
      fetch("{{ route('student.myVideoPracticeTest.submit', ['studentId' => $studentId, 'videoId' => $video->id]) }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            answers
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.status === "success") {
            document.getElementById("resultPopup").classList.add("active");
            document.querySelector(".result-score").textContent = `${data.score} Marks`;
            document.querySelector(".result-message").textContent = `You answered ${data.score / 2} out of ${totalQuestions} questions correctly.`;
          } else {
            alert("Error submitting test. Please try again.");
          }
        })
        .catch(err => {
          console.error(err);
          alert("Error submitting test.");
        });
    });

    // Close popup if clicked outside
    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("result-popup")) {
        document.getElementById("resultPopup").classList.remove("active");
      }
    });

    // Initialize progress bar
    updateProgress();
  });
</script>



@endsection