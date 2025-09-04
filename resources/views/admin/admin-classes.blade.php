@extends('admin.layouts.app')

@section('title', 'Add Classes - Schoolwala')

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
              List of Classes !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> classes
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
                  <th>Class Name</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($classes as $class)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>
                  <td>{{ $class->name }}</td>
                  <td>
                    <button
                      class="btn btn-primary"
                      type="button"
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDesc{{ $class->id }}">
                      Description
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{ $class->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $class->id }}">
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

<!-- Desc Modal -->
@foreach ($classes as $class)
<div
  class="modal fade"
  id="backDropModalDesc{{ $class->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          {{ $class->name }} Description
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
              <strong>Description:</strong>
              <br />
              {{ $class->description }}
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

<!-- Add Class Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-classes.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Class
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
            <label for="nameBackdrop" class="form-label">Class Name</label>
            <input
              type="text"
              id="nameBackdrop"
              class="form-control"
              value="Class " name="name" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Class Description</label>
            <textarea class="form-control" name="description" id="description" rows="5">
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

<!-- Edit Class Modal -->
@foreach ($classes as $class)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $class->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-class.update', $class->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Class
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
            <label for="nameBackdrop" class="form-label">Class Name</label>
            <input
              type="text"
              id="nameBackdrop"
              class="form-control"
              value="{{ $class->name }}" name="name"/>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Class Description</label>
            <textarea class="form-control" name="description" id="description" rows="5">
                        {{ $class->description }}</textarea>
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

<!-- Delete Class Modal -->
@foreach ($classes as $class)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $class->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-class.delete', $class->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Class
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
            <p>Are you sure you want to delete this {{ $class->name }}?</p>
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