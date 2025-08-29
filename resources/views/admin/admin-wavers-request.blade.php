@extends('admin.layouts.app')

@section('title', 'Waver Requests - Schoolwala')

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
              List of Waver Requests !
            </h5>
            <p class="mb-4">
              You can <strong>see/ delete</strong> waver requests
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
        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Request Date</th>
                  <th>Student's/ Parent's Name</th>
                  <th>Student Age</th>
                  <th>Class</th>
                  <th>Email/ Mobile</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <strong>1</strong>
                  </td>

                  <td>
                    <p class="m-0 p-0 badge bg-label-info">
                      01-01-2025
                    </p>
                  </td>

                  <td>
                    <p class="m-0 p-0">
                      <strong>STU Name:</strong> Xyx Mnp
                    </p>
                    <p class="m-0 p-0">
                      <strong>PRNT Name:</strong> Xyx Mnp
                    </p>
                  </td>

                  <td>Age: 7</td>

                  <td>
                    <span class="badge bg-label-primary">Class 8</span>
                  </td>
                  <td>
                    <p class="m-0 p-0">
                      <strong>Email:</strong> xyz@gmail.com
                    </p>
                    <p class="m-0 p-0">
                      <strong>Mobile:</strong> +91 1234567890
                    </p>
                  </td>

                  <td>
                    <button
                      class="btn btn-primary"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalAddress">
                      Address
                    </button>
                  </td>

                  <td>
                    <button class="btn btn-info" type="button">
                      Mail Back
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass">
                      Delete
                    </button>
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

<!-- Address View Modal -->
<div
  class="modal fade"
  id="backDropModalAddress"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Address
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
              <strong><i class="bx bx-mail-send"></i> Email: xyz@gmail.com</strong>
              <br />
              <i class="bx bx-map"></i> <strong>Address:</strong> Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Quisquam, quae?
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

<!-- Delete Waver Request Modal -->
<div
  class="modal fade"
  id="backDropModalDeleteClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Request
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
              Are you sure you want to delete this request
              <span class="text-danger">Email ID | Mobile</span>?
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

@endsection