@extends('admin.layouts.app')

@section('title', 'Add Videos - Schoolwala')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
  .fab {
    position: fixed;
    right: 34px;
    bottom: 54px;
    width: 56px;
    height: 56px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #0d6efd;
    /* change color as you like */
    color: #fff !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15),
      0 6px 10px rgba(0, 0, 0, 0.08);
    text-decoration: none;
    z-index: 1050;
    /* sits above most UI */
    transition: transform 0.15s ease, box-shadow 0.15s ease,
      filter 0.15s ease;
  }

  .fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18),
      0 8px 14px rgba(0, 0, 0, 0.1);
    filter: brightness(1.05);
  }

  .fab:focus-visible {
    outline: 3px solid rgba(13, 110, 253, 0.45);
    outline-offset: 2px;
  }

  @media (prefers-reduced-motion: reduce) {
    .fab {
      transition: none;
    }
  }
</style>

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">
              List of Videos !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> videos
            </p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('./admin/assets/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User" />
          </div>
        </div>
        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Thumbnails</th>
                  <th>Class Names</th>
                  <th>Subjects</th>
                  <th>Chapters</th>
                  <th>Paid/ Free</th>
                  <th>Video Titles</th>
                  <th>Videos</th>
                  <th>Practice Q/A</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($videos as $video)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>
                  <td>
                    <img
                      class="img-fluid rounded"
                      src="{{ asset('storage/' . $video->video_thumbnail) }}"
                      width="50" />
                  </td>
                  <td>{{ $video->class->name }}</td>
                  <td>{{ $video->subject->name }}</td>
                  <td>{{ $video->chapter->name }}</td>
                  <td>
                    @if ($video->video_type == 'paid')
                    <span class="badge bg-label-success">Paid</span>
                    @elseif ($video->video_type == 'free')
                    <span class="badge bg-label-info">Free</span>
                    @endif
                  </td>
                  <td style="text-transform: capitalize; white-space: normal; word-break: break-word;">
                    <strong>{{ $video->video_title }}</strong>
                  </td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalPlayVideo{{ $video->id }}">
                      <i class="fa-solid fa-video"></i>
                    </button>
                  </td>

                  <td>
                    <div class="d-flex flex-column gap-2">
                      <button
                        type="button"
                        class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalAddTest{{ $video->id }}" style="width: fit-content;">
                        <i class="fa-solid fa-plus"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalViewTest{{ $video->id }}" style="width: fit-content;">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                    </div>
                  </td>

                  <td>
                    <div class="d-flex flex-column gap-2">
                      <button
                        type="button"
                        class="btn btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalEditClass{{ $video->id }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                      <button
                        class="btn btn-danger"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalDeleteClass{{ $video->id }}">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Video Modal -->
@foreach ($videos as $video)
<div
  class="modal fade"
  id="backDropModalPlayVideo{{ $video->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          {{ $video->class->name}} | {{ $video->subject->name}} | {{ $video->chapter->name}}
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p style="width: 100%">
              <strong>{{ $video->video_title }}</strong>
              <br />
              <br />
              <iframe
                src="{{ $video->video_link }}"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                style="width: 100%; height: 500px"></iframe>
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </form>
  </div>
</div>
@endforeach


<!-- Test View Modal -->
@foreach ($videos as $video)
<div
  class="modal fade"
  id="backDropModalViewTest{{ $video->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Practice Test | {{ $video->class->name}} | {{ $video->subject->name}} | {{ $video->chapter->name}}
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p class="fw-bold">Video Title: {{ $video->video_title }}</p>

            @php
            $questions = is_string($video->questions) ? json_decode($video->questions, true) : ($video->questions ?? []);
            $answers = is_string($video->answers) ? json_decode($video->answers, true) : ($video->answers ?? []);
            $correct = is_string($video->correct_answers) ? json_decode($video->correct_answers, true) : ($video->correct_answers ?? []);
            @endphp


            @if(!empty($questions))
            @foreach($questions as $i => $q)
            <p>
              <strong>{{ $i+1 }}.</strong> {{ $q }} <br>
              @php $ansArr = explode(',', $answers[$i] ?? ''); @endphp
              @foreach($ansArr as $key => $ans)
              @php $isCorrect = trim($ans) == ($correct[$i] ?? ''); @endphp
              <span class="me-2 {{ $isCorrect ? 'badge bg-success' : '' }}">
                {!! $isCorrect ? '<strong>'.chr(65+$key).'. '.trim($ans).'</strong>' : chr(65+$key).'. '.trim($ans) !!}
              </span>
              @endforeach
            </p>
            @endforeach
            @else
            <p>No practice test added yet.</p>
            @endif



          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Test Add Modal -->
@foreach ($videos as $video)
<div
  class="modal fade"
  id="backDropModalAddTest{{ $video->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="{{ route('admin.admin-videos.update', $video->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Practice Test | {{ $video->class->name}} | {{ $video->subject->name}} | {{ $video->chapter->name}}
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Title: {{ $video->video_title }}</label> <br>
            <label for="nameBackdrop1" class="form-label">Practice Questions & Answers</label>

            <input type="hidden" value="{{$video->id}}" name="video_id">

            @php
            $questions = is_string($video->questions) ? json_decode($video->questions, true) : ($video->questions ?? []);
            $answers = is_string($video->answers) ? json_decode($video->answers, true) : ($video->answers ?? []);
            $correct = is_string($video->correct_answers) ? json_decode($video->correct_answers, true) : ($video->correct_answers ?? []);
            @endphp


            <div id="questions-wrapper-{{ $video->id }}">
              @if(!empty($questions))
              @foreach($questions as $i => $q)
              <div class="multiple-section mb-3">
                <input type="text" class="form-control mb-2" placeholder="Enter Question" name="questions[]" value="{{ $q }}" />
                <input type="text" class="form-control mb-2" placeholder="Enter MCQ Answers (Comma Separated)" name="answers[]" value="{{ $answers[$i] ?? '' }}" />
                <input type="text" class="form-control mb-2" placeholder="Enter Correct Answer" name="correct_answers[]" value="{{ $correct[$i] ?? '' }}" />
                <button type="button" class="mb-2 btn btn-danger remove-section">Remove</button>
              </div>
              @endforeach
              @endif

              <div class="multiple-section mb-3">
                <input type="text" class="form-control mb-2" placeholder="Enter Question" name="questions[]" />
                <input type="text" class="form-control mb-2" placeholder="Enter MCQ Answers (Comma Separated)" name="answers[]" />
                <input type="text" class="form-control mb-2" placeholder="Enter Correct Answer" name="correct_answers[]" />
                <button type="button" class="mb-2 btn btn-danger remove-section">Remove</button>
              </div>
            </div>

            <button type="button" class="mt-2 btn btn-primary add-section" data-target="questions-wrapper-{{ $video->id }}">Add</button>


          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>

        <button
          type="submit"
          class="btn btn-primary">
          Save
        </button>
      </div>
    </form>
  </div>
</div>
@endforeach







<!-- Add Video Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <form class="modal-content" action="{{ route('admin.admin-videos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Video
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="class_id" class="form-label">Choose Class</label>
            <select name="class_id" id="class_id" class="form-select">
              <option value="" selected>Choose Class</option>
              @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="subject_id" class="form-label">Choose Subject</label>
            <select name="subject_id" id="subject_id" class="form-select">
              <option value="" selected>Choose Subject</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="chapter_id" class="form-label">Choose Chapter</label>
            <select name="chapter_id" id="chapter_id" class="form-select">
              <option value="" selected>Choose Chapter</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Title</label>
            <input type="text" class="form-control" name="video_title" id="video_title" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Type</label>
            <select name="video_type" id="video_type" class="form-select">
              <option value="" selected>Choose Video Type</option>
              <option value="paid">Paid</option>
              <option value="free">Free</option>
            </select>
          </div>
        </div>

        <div class="row g-2" id="video_link_row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Link</label>
            <input type="text" class="form-control" name="video_link" id="video_link" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Description</label>
            <textarea
              name="video_description"
              id="video_description"
              class="form-control"
              rows="5"></textarea>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Thumbnail</label>
            <input type="file" class="form-control" name="video_thumbnail" id="video_thumbnail" />
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Video Modal -->
@foreach ($videos as $video)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $video->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <form class="modal-content" action="{{ route('admin.admin-videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="class_id" class="form-label">Choose Class</label>
            <select name="class_id" id="class_id_edit{{ $video->id }}" class="form-select class-select">
              <option value="" disabled>Choose Class</option>
              @foreach ($classes as $class)
              <option value="{{ $class->id }}" {{ $class->id == $video->class_id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="subject_id" class="form-label">Choose Subject</label>
            <select name="subject_id" id="subject_id_edit{{ $video->id }}" class="form-select subject-select">
              <option value="" disabled>Choose Subject</option>
              @foreach ($subjects as $subject)
              <option value="{{ $subject->id }}" {{ $subject->id == $video->subject_id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="chapter_id" class="form-label">Choose Chapter</label>
            <select name="chapter_id" id="chapter_id_edit{{ $video->id }}" class="form-select chapter-select">
              <option value="" disabled>Choose Chapter</option>
              @foreach ($chapters as $chapter)
              <option value="{{ $chapter->id }}" {{ $chapter->id == $video->chapter_id ? 'selected' : '' }}>
                {{ $chapter->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="video_type" class="form-label">Video Type</label>
            <select name="video_type" id="video_type_edit{{ $video->id }}" class="form-select">
              <option value="paid" {{ $video->video_type == 'paid' ? 'selected' : '' }}>Paid</option>
              <option value="free" {{ $video->video_type == 'free' ? 'selected' : '' }}>Free</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="video_title" class="form-label">Video Title</label>
            <input type="text" class="form-control" name="video_title" value="{{ $video->video_title }}">
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="video_link" class="form-label">Video Link</label>
            <input type="text" class="form-control" name="video_link" value="{{ $video->video_link }}">
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="video_description" class="form-label">Video Description</label>
            <textarea name="video_description" class="form-control" rows="5">{{ $video->video_description }}</textarea>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="video_thumbnail" class="form-label">Video Thumbnail</label>
            <input type="file" class="form-control" name="video_thumbnail">
            @if($video->video_thumbnail)
            <img src="{{ asset('storage/'.$video->video_thumbnail) }}" alt="Thumbnail" class="mt-2" style="max-width: 120px; border-radius: 8px;">
            @endif
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach


<!-- Delete Video Modal -->
<div
  class="modal fade"
  id="backDropModalDeleteClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Video
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p>Are you sure you want to delete this Video?</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Button -->
<a
  type="button"
  data-bs-toggle="modal"
  data-bs-target="#backDropModalAddClass"
  class="fab"
  aria-label="Add new item"
  title="Add">
  Add
</a>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Base routes from Laravel
    let subjectRoute = "{{ route('admin.get-subjects', ':classId') }}";
    let chapterRoute = "{{ route('admin.get-chapters', ':subjectId') }}";

    // When Class changes
    $('#class_id').on('change', function() {
      let classId = $(this).val();
      $('#subject_id').html('<option value="">Choose Subject</option>');
      $('#chapter_id').html('<option value="">Choose Chapter</option>');

      if (classId) {
        let url = subjectRoute.replace(':classId', classId);

        $.get(url, function(data) {
          $.each(data, function(key, subject) {
            $('#subject_id').append('<option value="' + subject.id + '">' + subject.name + '</option>');
          });
        });
      }
    });

    // When Subject changes
    $('#subject_id').on('change', function() {
      let subjectId = $(this).val();
      $('#chapter_id').html('<option value="">Choose Chapter</option>');

      if (subjectId) {
        let url = chapterRoute.replace(':subjectId', subjectId);

        $.get(url, function(data) {
          $.each(data, function(key, chapter) {
            $('#chapter_id').append('<option value="' + chapter.id + '">' + chapter.name + '</option>');
          });
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Add new section
    $(document).on('click', '.add-section', function() {
      let targetWrapper = $(this).data('target'); // get wrapper ID
      let newSection = `
      <div class="multiple-section mb-3">
        <input type="text" class="form-control mb-2" placeholder="Enter Question" name="questions[]" />
        <input type="text" class="form-control mb-2" placeholder="Enter MCQ Answers (Comma Separated)" name="answers[]" />
        <input type="text" class="form-control mb-2" placeholder="Enter Correct Answer" name="correct_answers[]" />
        <button type="button" class="btn btn-danger remove-section">Remove</button>
      </div>
    `;
      $('#' + targetWrapper).append(newSection);
    });

    // Remove section
    $(document).on('click', '.remove-section', function() {
      $(this).closest('.multiple-section').remove();
    });
  });
</script>


@endsection