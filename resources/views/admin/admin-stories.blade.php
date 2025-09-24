@extends('admin.layouts.app')

@section('title', 'Add Stories - Schoolwala')

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
              List of Stories !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> stories
            </p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('admin/assets/img/illustrations/man-with-laptop-light.png') }}"
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
                  <th>Classes</th>
                  <th>Story Tags</th>
                  <th>Student Images</th>
                  <th>Student Names</th>
                  <th>Short Feedbacks</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($stories as $story)
                <tr>
                  <td>
                    <strong>{{$loop->iteration}}</strong>
                  </td>

                  <td>
                    <span class="badge bg-label-info">{{$story->class->name}}</span>
                  </td>

                  <td>{{$story->storyTag->tag_name}}</td>
                  <td>
                    <img
                      src="{{asset('storage/'.$story->image) }}"
                      class="w-px-40 h-auto rounded-circle"
                      alt="" />
                  </td>
                  <td>{{$story->name}}</td>

                  <td>
                    {{$story->feedback}}
                  </td>



                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{ $story->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $story->id }}">
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

<!-- Add Story Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-stories.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Story
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="row g-2">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Choose Class</label>
              <select name="class_id" class="form-select" id="">
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row g-2">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Choose Story Tags</label>
              <select name="story_tag_id" class="form-select" id="">
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Image</label>
            <input type="file" name="image" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Name</label>
            <input type="text" name="name" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Short Feedback</label>
            <input type="text" name="feedback" class="form-control" />
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

<!-- Edit Story Modal -->
@foreach($stories as $story)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $story->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-stories.update', $story->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Story
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="row g-2">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Choose Class</label>
              <select name="class_id" class="form-select" id="">
                <option value="{{ $story->class->id }}" selected>{{ $story->class->name }}</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row g-2">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Choose Story Tags</label>
              <select name="story_tag_id" class="form-select" id="">
                <option value="{{ $story->storyTag->id }}" selected>{{ $story->storyTag->tag_name }}</option>
                @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student Name</label>
            <input type="text" name="name" class="form-control" value="{{ $story->name }}" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Short Feedback</label>
            <input type="text" name="feedback" class="form-control" value="{{ $story->feedback }}" />
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

<!-- Delete Story Modal -->
@foreach($stories as $story)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $story->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-stories.delete', $story->id) }}">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Story
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
            <p>Are you sure you want to delete this story?</p>
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