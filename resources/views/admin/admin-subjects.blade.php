@extends('admin.layouts.app')

@section('title', 'Add Subjects - Schoolwala')

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
              List of Subjects !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> subjects
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
                  <th>Class Names</th>
                  <th>Subjects</th>
                  <th>Subject BGs</th>
                  <th>Subject Icons</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($subjects as $subject)
                <tr>
                  <td>
                    <strong>{{$loop->iteration}}</strong>
                  </td>
                  <td>{{$subject->class->name}}</td>
                  <td>{{$subject->name}}</td>
                  <td>{{$subject->bg_color_txt}}</td>
                  <!-- maths-bg -->
                  <td>{{$subject->icon_txt}}</td>
                  <!-- fas fa-calculator -->

                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{$subject->id}}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{$subject->id}}">
                      Delete
                    </button>
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

<!-- Add Subject Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-subjects.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Subject
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
            <select name="class_id" id="class_id" class="form-select">
              @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Subject Name</label>
            <input type="text" name="name" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Subject BG</label>
            <select name="bg_color_txt" id="bg_color_txt" class="form-select">
              <option value="" selected>Choose Subject BG Color</option>
              <option value="maths-bg">Math Background Color</option>
              <option value="science-bg">Science Background Color</option>
              <option value="english-bg">English Background Color</option>
              <option value="social-bg">Bengali Background Color</option>
              <option value="social-bg">Social Background Color</option>
              <option value="social-bg">Geography Background Color</option>
              <option value="social-bg">History Background Color</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Subject Icon</label>
            <select name="icon_txt" id="icon_txt" class="form-select">
              <option value="" selected>Choose Subject Icon</option>
              <option value="fas fa-calculator"><i class="fas fa-calculator"></i> Math Icon</option>
              <option value="fas fa-flask"><i class="fas fa-flask"></i> Science Icon</option>
              <option value="fas fa-book-open"><i class="fas fa-book-open"></i> English Icon</option>
              <option value="fas fa-globe-asia"><i class="fas fa-globe-asia"></i> Social Science Icon</option>
              <option value="fas fa-language"><i class="fas fa-language"></i> Bengali Icon</option>
              <option value="fas fa-map-marked-alt"><i class="fas fa-map-marked-alt"></i> Geography Icon</option>
              <option value="fas fa-landmark"><i class="fas fa-landmark"></i> History Icon</option>
            </select>
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

<!-- Edit Subject Modal -->
@foreach ($subjects as $subject)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $subject->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-subjects.update', $subject->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Choose Class</label>
            <select name="class_id" class="form-select">
              <option value="{{ $subject->class_id }}" selected>{{ $subject->class->name }}</option>
              @foreach ($classes as $class)
              @if($class->id !== $subject->class_id)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="name" value="{{ $subject->name }}" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label class="form-label">Subject BG</label>
            <select name="bg_color_txt" class="form-select">
              <option value="{{ $subject->bg_color_txt }}" selected>{{ $subject->bg_color_txt }}</option>
              <option value="maths-bg">Math Background Color</option>
              <option value="science-bg">Science Background Color</option>
              <option value="english-bg">English Background Color</option>
              <option value="bengali-bg">Bengali Background Color</option>
              <option value="social-bg">Social Background Color</option>
              <option value="geography-bg">Geography Background Color</option>
              <option value="history-bg">History Background Color</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label class="form-label">Subject Icon</label>
            <select name="icon_txt" class="form-select">
              <option value="{{ $subject->icon_txt }}" selected>{{ $subject->icon_txt }}</option>
              <option value="fas fa-calculator">Math Icon</option>
              <option value="fas fa-flask">Science Icon</option>
              <option value="fas fa-book-open">English Icon</option>
              <option value="fas fa-globe-asia">Social Science Icon</option>
              <option value="fas fa-language">Bengali Icon</option>
              <option value="fas fa-map-marked-alt">Geography Icon</option>
              <option value="fas fa-landmark">History Icon</option>
            </select>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
@endforeach


<!-- Delete Subject Modal -->
@foreach ($subjects as $subject)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $subject->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-subjects.delete', $subject->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Subject
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
            <p>Are you sure you want to delete this {{ $subject->name }}?</p>
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
<a
  type="button"
  data-bs-toggle="modal"
  data-bs-target="#backDropModalAddClass"
  class="fab"
  aria-label="Add new item"
  title="Add">
  Add
</a>

@endsection