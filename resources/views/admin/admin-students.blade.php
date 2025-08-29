@extends('admin.layouts.app')

@section('title', 'Students - Schoolwala')

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
              List of Students !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> students
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
        <div class="col-lg-12 mb-4">
          <form action="">
            <div class="input-group">
              <label for="" class="input-group-text">
                Choose Class</label>
              <select name="" class="form-select" id="">
                <option value="1">Class 1</option>
                <option value="2">Class 2</option>
                <option value="3">Class 3</option>
                <option value="4">Class 4</option>
                <option value="5">Class 5</option>
              </select>

              <button class="btn btn-primary">Search</button>
              &nbsp;&nbsp;
              <button class="btn btn-info">Export</button>
            </div>
          </form>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Profile</th>
                  <th>STU ID</th>
                  <th>STU Type</th>
                  <th>Student Name</th>
                  <th>Student Age</th>
                  <th>Class Name</th>
                  <th>Parent's Name</th>
                  <th>Email/ Mobile</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <strong>1</strong>
                  </td>
                  <td>
                    <img
                      src="{{ asset('./admin/assets/img/avatars/1.png') }}"
                      class="w-px-40 h-auto rounded-circle" />
                  </td>
                  <td>
                    <span class="badge bg-label-danger">25-SW-CLASS8-01</span>
                  </td>
                  <td>Regular</td>
                  <td>Xyz Mnp</td>
                  <td>
                    <span class="badge bg-label-primary">Age: 8</span>
                  </td>
                  <td>
                    <span class="badge bg-label-warning">Class 8</span>
                  </td>
                  <td>MNP</td>
                  <td>
                    <p class="m-0 p-0">xyz@gmail.com</p>
                    <p class="m-0 p-0">+91 123456789</p>
                  </td>

                  <td>
                    <div class="row g-2">
                      <button
                        type="button"
                        class="btn btn-info">
                        Add to Waver
                      </button>
                      <button
                        type="button"
                        class="btn btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalEditClass">
                        Edit
                      </button>
                      <button
                        class="btn btn-danger"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalDeleteClass">
                        Delete
                      </button>

                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Student Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Student
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
            <label for="nameBackdrop" class="form-label">Profile Image</label>
            <input type="file" class="form-control" />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Student Type</label>
            <select name="" id="" class="form-select">
              <option value="regular">Regular</option>
              <option value="waver">Waver</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Parent's Name</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student's Name</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Email ID</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Mobile</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student's Age</label>
            <input type="text" class="form-control" />
          </div>

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
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Password</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Confirm Password</label>
            <input type="text" class="form-control" />
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
</div>

<!-- Edit Student Modal -->
<div
  class="modal fade"
  id="backDropModalEditClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Student
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
            <img
              src="./assets/img/avatars/1.png"
              class="w-px-100 h-auto rounded-circle"
              alt="" />
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Profile Image</label>
            <input type="file" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Student Type</label>
            <select name="" id="" class="form-select">
              <option value="regular">Regular</option>
              <option value="waver">Waver</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Parent's Name</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student's Name</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Email ID</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Mobile</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Student's Age</label>
            <input type="text" class="form-control" />
          </div>

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
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Password</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Confirm Password</label>
            <input type="text" class="form-control" />
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
</div>

<!-- Delete Student Modal -->
<div
  class="modal fade"
  id="backDropModalDeleteClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Student
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
              Are you sure you want to delete this student
              <span class="text-danger">25-SW-CLASS8-01</span>?
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

@endsection