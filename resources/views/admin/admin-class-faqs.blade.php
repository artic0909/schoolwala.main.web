@extends('admin.layouts.app')

@section('title', 'Add Class FAQs - Schoolwala')

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
              List of Class's Frequently Asked Questions !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> faqs
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
                  <th>Questions/ Answers</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($classFaqs as $classFaq)
                <tr>
                  <td>
                    <strong>{{$loop->iteration}}</strong>
                  </td>
                  <td>{{$classFaq->class->name}}</td>
                  <td>
                    <button
                      class="btn btn-primary"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalQuestion{{$classFaq->id}}">
                      Question
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-info"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalAnswers{{$classFaq->id}}">
                      Answer
                    </button>
                  </td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{$classFaq->id}}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{$classFaq->id}}">
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

<!-- Question Modal -->
@foreach ($classFaqs as $classFaq)
<div
  class="modal fade"
  id="backDropModalQuestion{{ $classFaq->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Question
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
              <strong>Question:</strong>
              <br />
              {{ $classFaq->question }}
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

<!-- Answer Modal -->
@foreach ($classFaqs as $classFaq)
<div
  class="modal fade"
  id="backDropModalAnswers{{ $classFaq->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Answer</h5>
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
              <strong>Answer:</strong>
              <br />
              {{ $classFaq->answer }}
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

<!-- Add FAQ Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-class-faqs.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Add FAQ</h5>
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

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Question</label>
            <textarea class="form-control" name="question" id="question" rows="5">
                        </textarea>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Answer</label>
            <textarea class="form-control" name="answer" id="answer" rows="5">
                        </textarea>
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

<!-- Edit FAQ Modal -->
@foreach ($classFaqs as $classFaq)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $classFaq->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-class-faqs.update', $classFaq->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit FAQ
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
              <option value="{{ $classFaq->class_id }}" selected disabled>{{ $classFaq->class->name }}</option>
              @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Question</label>
            <textarea class="form-control" name="question" id="question" rows="5">
            {{ $classFaq->question }}</textarea>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Answer</label>
            <textarea class="form-control" name="answer" id="answer" rows="5">
            {{ $classFaq->answer }}</textarea>
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

<!-- Delete FAQ Modal -->
@foreach ($classFaqs as $classFaq)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $classFaq->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-class-faqs.delete', $classFaq->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete FAQ
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
            <p>Are you sure you want to delete this FAQ?</p>
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