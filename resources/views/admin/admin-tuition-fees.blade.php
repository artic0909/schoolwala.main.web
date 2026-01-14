@extends('admin.layouts.app')

@section('title', 'Tuition Fees - Schoolwala')

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
              List of Tuition Fees !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> tuitions
              fees
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

        <!-- Student Search Filter -->
        <div
          class="col-lg-12 mb-4 d-flex px-5 justify-content-end">
          <button class="btn btn-info">Export</button>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>QR Image</th>
                  <th>Class Name</th>
                  <th>Fees Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($feeses as $fees)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>

                  <td>
                    @if($fees->qrimage)
                    <img src="{{ asset('storage/' . $fees->qrimage) }}" alt="QR Code" width="120">
                    @endif
                  </td>

                  <td>
                    <span class="badge bg-label-primary">{{$fees->class->name}}</span>
                  </td>
                  <td>{{$fees->amount}}</td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{ $fees->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $fees->id }}">
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

<!-- Add Tuition Fees Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-tuition-fees.add') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Tuition Fees
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
              <option value="" selected>Choose Class</option>
              @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Fees Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">QR Code</label>
            <input type="file" name="qrimage" id="qrimage" class="form-control" />
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

<!-- Edit Tuition Fees Modal -->
@foreach($feeses as $fees)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $fees->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" action="{{ route('admin.admin-tuition-fees.edit', $fees->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Tuition Fees
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
              @if($fees->class)
              <option value="{{ $fees->class->id }}" selected>{{ $fees->class->name }}</option>

              @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Fees Amount</label>
            <input type="number" name="amount" id="amount" value="{{$fees->amount}}" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">QR Code</label>
            <input type="file" name="qrimage" id="qrimage" class="form-control" />
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

<!-- Delete Tuition Fees Modal -->
@foreach($feeses as $fees)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $fees->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-tuition-fees.delete', $fees->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Tuition Fees
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
              Are you sure you want to delete this tuition fees
              <span class="text-danger">{{ $fees->class->name }} Fees: {{ $fees->amount }}</span>?
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