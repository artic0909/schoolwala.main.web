@extends('admin.layouts.app')

@section('title', 'Upload Faculties - Schoolwala')

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
              List of Faculties !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> faculties
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
                  <th>Profile</th>
                  <th>FAC ID</th>
                  <th>Faculty Name</th>
                  <th>Asigned Classes</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>About Faculty</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($faculties as $fac)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>
                  <td>
                    <img
                      src="{{ $fac->image ? asset('storage/'.$fac->image) : './assets/img/avatars/1.png' }}"
                      class="w-px-40 h-auto rounded-circle" />
                  </td>
                  <td>
                    <span class="badge bg-label-danger">{{ $fac->fac_id }}</span>
                  </td>
                  <td>{{ $fac->name }}</td>
                  <td>
                    @if (!empty($fac->assigned_classes))
                    @foreach ($fac->assigned_classes as $classId)
                    @php
                    $class = \App\Models\Classes::find($classId);
                    @endphp
                    @if($class)
                    <span class="badge bg-label-primary">{{ $class->name }}</span>
                    @endif
                    @endforeach
                    @else
                    <span class="text-muted">No classes assigned</span>
                    @endif
                  </td>


                  <td>{{ $fac->email }}</td>
                  <td>{{ $fac->mobile }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalAbout{{ $fac->id }}">
                      About
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{ $fac->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $fac->id }}">
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

<!-- About Faculty Modal -->
@foreach ($faculties as $fac)
<div
  class="modal fade"
  id="backDropModalAbout{{ $fac->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          About Faculty
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
              <strong>Faculty Name: {{ $fac->name }} | FAC ID: {{ $fac->fac_id }}</strong>
              <br />
              {{ $fac->about_fac }}
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

<!-- Add Faculty Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" action="{{ route('admin.admin-upload-faculties.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Faculty
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
            <label for="nameBackdrop" class="form-label">Faculty Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" required placeholder="XYZ" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Asign Classes<span class="text-danger">*</span></label>
            <br />
            <div>
              @foreach ($classes as $class)
              <p
                class="d-flex justify-content-start align-items-center m-0 p-0">
                <span>{{ $class->name }}</span> &nbsp;
                <input type="checkbox" class="form-check" name="assigned_classes[]" value="{{ $class->id }}" />

              </p>
              @endforeach
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Email ID<span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" placeholder="xyz@gmail" required />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Mobile<span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile" required />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Profile Image</label>
            <input type="file" name="image" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">About Faculty</label>
            <textarea
              name="about_fac"
              id="about_fac"
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Faculty Modal -->
@foreach ($faculties as $fac)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $fac->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" action="{{ route('admin.admin-upload-faculties.update', $fac->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <input type="hidden" name="fac_id" value="{{ $fac->id }}">

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Faculty | <span class="badge bg-label-success">{{ $fac->name }}</span> | <span class="badge bg-label-primary">{{ $fac->fac_id }}</span>
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
            <!-- realtime change whatever i choose image -->
            <img
              src="{{ $fac->image ? asset('storage/'.$fac->image) : './assets/img/avatars/1.png' }}"
              class="rounded-circle"
              id="previewImage{{ $fac->id }}" style="background-size: cover; background-position: center; background-repeat: no-repeat; width: 100px; height: 100px" />
            <input type="file" name="image" class="form-control mt-2" onchange="previewImage(event, {{ $fac->id }})">

          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Faculty Name</label>
            <input type="text" name="name" class="form-control" value="{{ $fac->name }}" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Asign Classes</label>
            <br />
            <div>
              <!-- all classes show here just checked those classes which are assigned -->
              @foreach ($classes as $class)
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="assigned_classes[]"
                  value="{{ $class->id }}"
                  id="class{{ $fac->id }}_{{ $class->id }}"
                  {{ in_array($class->id, $fac->assigned_classes ?? []) ? 'checked' : '' }}>
                <label class="form-check-label" for="class{{ $fac->id }}_{{ $class->id }}">
                  {{ $class->name }}
                </label>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Email ID</label>
            <input type="email" name="email" class="form-control" value="{{ $fac->email }}" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Mobile</label>
            <input type="text" name="mobile" value="{{ $fac->mobile }}" class="form-control" />
          </div>
        </div>

        <!-- <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Profile Image</label>
            <input type="file" name="image" class="form-control" />
          </div>
        </div> -->

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">About Faculty</label>
            <textarea
              name="about_fac"
              id="about_fac"
              class="form-control"
              rows="5">{{ $fac->about_fac }}</textarea>
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

<!-- Delete Faculty Modal -->
@foreach ($faculties as $fac)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $fac->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-upload-faculties.delete', $fac->id) }}" method="POST">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Faculty
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
              Are you sure you want to delete this Faculty
              <span class="text-danger">{{ $fac->fac_id }}</span>?
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

<script>
  function previewImage(event, id) {
    const reader = new FileReader();
    reader.onload = function() {
      document.getElementById('previewImage' + id).src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }
</script>

@endsection