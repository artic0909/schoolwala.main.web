@extends('admin.layouts.app')

@section('title', 'Video Feedbacks - Schoolwala')

@section('content')

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
              List of Video Feedbacks !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> video
              feedback
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
                  <th>Video Details</th>
                  <th>Total Likes</th>
                  <th>Student Details</th>
                  <th>Feedbacks</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($videoFeedbacks as $key => $feedback)
                <tr>
                  <td><strong>{{$loop->iteration}}</strong></td>

                  <td>
                    <p class="m-0 p-0">{{ $feedback->video->class->name ?? '-' }}</p>
                    <p class="m-0 p-0">{{ $feedback->video->subject->name ?? '-' }}</p>
                    <p class="m-0 p-0">{{ $feedback->video->chapter->name ?? '-' }}</p>
                    <p class="m-0 p-0">{{ $feedback->video->video_title ?? '-' }}</p>
                  </td>

                  <td>
                    <span class="text-danger fw-bold">{{ $feedback->video->likes ?? '-' }}</span>
                  </td>

                  <td>
                    <p class="m-0 p-0"><strong>Name:</strong> {{ $feedback->student->student_name ?? '-' }}</p>
                    <p class="m-0 p-0"><strong>Email:</strong> {{ $feedback->student->email ?? '-' }}</p>
                    <p class="m-0 p-0"><strong>Mobile:</strong> {{ $feedback->student->mobile ?? '-' }}</p>
                    <p class="m-0 p-0"><strong>STU ID:</strong> {{ $feedback->student->student_id ?? '-' }}</p>
                  </td>

                  <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                      data-bs-target="#backDropModalFeedback{{ $feedback->id }}">
                      Feedback
                    </button>
                  </td>

                  <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                      data-bs-target="#backDropModalEdit{{ $feedback->id }}">Edit</button>
                    &nbsp;
                    <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                      data-bs-target="#backDropModalDelete{{ $feedback->id }}">Delete</button>
                  </td>
                </tr>
                @endforeach

              </tbody>

              <!-- Pagination Footer -->
              <tr>
                <td colspan="6">
                  <div class="d-flex justify-content-center align-items-center mt-2">
                    <!-- Custom Pagination -->
                    <div class="d-flex justify-content-center align-items-center mt-3">
                      @if ($videoFeedbacks->onFirstPage())
                      <button class="btn btn-secondary me-2" disabled>Prev</button>
                      @else
                      <a href="{{ $videoFeedbacks->previousPageUrl() }}" class="btn btn-primary me-2">Prev</a>
                      @endif

                      <form action="" method="GET" class="d-flex align-items-center">
                        <input type="number" name="page" value="{{ $videoFeedbacks->currentPage() }}"
                          min="1" max="{{ $videoFeedbacks->lastPage() }}"
                          class="form-control text-center me-1" style="width: 70px;"
                          onchange="this.form.submit()" readonly>

                        <span class="mx-1">/</span>
                        <input type="text" readonly value="{{ $videoFeedbacks->lastPage() }}"
                          class="form-control text-center ms-1" style="width: 70px;">
                      </form>

                      @if ($videoFeedbacks->hasMorePages())
                      <a href="{{ $videoFeedbacks->nextPageUrl() }}" class="btn btn-primary ms-2">Next</a>
                      @else
                      <button class="btn btn-secondary ms-2" disabled>Next</button>
                      @endif
                    </div>

                  </div>
                </td>
              </tr>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Feedback Modal -->
@foreach ($videoFeedbacks as $feedback)
<div
  class="modal fade"
  id="backDropModalFeedback{{ $feedback->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Student Feedback
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
            <p class="fw-bold">
              {{ $feedback->student->student_id ?? '-' }} | {{ $feedback->student->student_name ?? '-' }}
            </p>
            <p class="fw-bold m-0 p-0">Video Title:</p>
            <span>{{ $feedback->video->video_title ?? '-' }}</span>
            <p class="fw-bold m-0 p-0 mt-2 text-danger">
              Rating: {{ $feedback->rating ?? '-' }}/5
            </p>
            <p class="fw-bold m-0 p-0 mt-2">Feedback:</p>
            <p>
              {{ $feedback->feedback ?? '-' }}
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

<!-- Add Video Feedback Modal -->
<!-- <div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Video Feedback
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
            <label for="nameBackdrop" class="form-label">Choose Class</label>
            <select name="" id="" class="form-select">
              <option value="1">Class 1</option>
              <option value="2">Class 2</option>
              <option value="3">Class 3</option>
              <option value="4">Class 4</option>
              <option value="5">Class 5</option>
            </select>
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Subject</label>
            <select name="" id="" class="form-select">
              <option value="1">Subject 1</option>
              <option value="2">Subject 2</option>
              <option value="3">Subject 3</option>
              <option value="4">Subject 4</option>
              <option value="5">Subject 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Chapter</label>
            <select name="" id="" class="form-select">
              <option value="1">Chapter 1</option>
              <option value="2">Chapter 2</option>
              <option value="3">Chapter 3</option>
              <option value="4">Chapter 4</option>
              <option value="5">Chapter 5</option>
            </select>
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Type</label>
            <select name="" id="" class="form-select">
              <option value="paid">Paid</option>
              <option value="free">Free</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Video Title</label>
            <select name="" id="" class="form-select">
              <option value="1">Title 1</option>
              <option value="2">Title 2</option>
              <option value="3">Title 3</option>
              <option value="4">Title 4</option>
              <option value="5">Title 5</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student ID</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Name</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Email</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Mobile</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Rating</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Feedback</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
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
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div> -->

<!-- Edit Video Feedback Modal -->
@foreach ($videoFeedbacks as $feedback)
<div
  class="modal fade"
  id="backDropModalEdit{{ $feedback->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-video-feedbacks.edit', $feedback->id) }}">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Video Feedback
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
            <label for="nameBackdrop" class="form-label">Rating</label>
            <div class="d-flex gap-5">
              <input type="number" name="rating" id="rating" value="{{ $feedback->rating }}" class="form-control" /> Out of
              <input type="number" class="form-control" value="5" readonly>
            </div>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Feedback</label>
            <textarea
              name="feedback"
              id="feedback"
              class="form-control"
              rows="5">{{ $feedback->feedback }}</textarea>
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
@endforeach

<!-- Delete Video Feedback Modal -->
@foreach ($videoFeedbacks as $feedback)
<div
  class="modal fade"
  id="backDropModalDelete{{ $feedback->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-video-feedbacks.delete', $feedback->id) }}">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Video Feedback
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
            <p>
              Are you sure you want to delete this video feedback?
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
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Add Button -->
<!-- <a
  type="button"
  data-bs-toggle="modal"
  data-bs-target="#backDropModalAddClass"
  class="fab"
  aria-label="Add new item"
  title="Add">
  Add
</a> -->

@endsection