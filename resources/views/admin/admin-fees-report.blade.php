@extends('admin.layouts.app')

@section('title', 'Fees Report - Schoolwala')

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
            <h5 class="card-title text-primary">Fees Report !</h5>
            <p class="mb-4">
              You can <strong>see</strong> the fees report
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
            <div class="input-group mb-4">
              <label for="" class="input-group-text">
                Choose Class</label>
              <select name="" class="form-select" id="">
                <option value="1">Class 1</option>
                <option value="2">Class 2</option>
                <option value="3">Class 3</option>
                <option value="4">Class 4</option>
                <option value="5">Class 5</option>
              </select>
            </div>

            <div class="input-group mb-4">
              <label for="" class="input-group-text">
                From Date</label>
              <input type="date" class="form-control" />
              &nbsp;&nbsp;&nbsp;
              <label for="" class="input-group-text">
                To Date</label>
              <input type="date" class="form-control" />
            </div>

            <div class="d-flex justify-content-end">
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
                  <th>Class Name</th>
                  <th>Parent's/ Student's Name</th>
                  <th>Email/Mobile</th>
                  <th>Fees/ Date</th>
                  <th>Status</th>
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
                    <span class="badge bg-label-warning">25-SW-CLASS8-01</span>
                  </td>

                  <td>
                    <span class="badge bg-label-primary">Class 8</span>
                  </td>

                  <td>
                    <p class="m-0 p-0">Parent's Name: Xyz Mnp</p>
                    <p class="m-0 p-0">Student's Name: Mnp</p>
                  </td>

                  <td>
                    <p class="m-0 p-0">
                      <i class="bx bx-envelope"></i> xyz@gmail.com
                    </p>
                    <p>
                      <i class="bx bx-phone"></i> +91-123456789
                    </p>
                  </td>
                  <td>
                    <p class="m-0 p-0">Rs: 89.00</p>
                    <p class="m-0 p-0">
                      Paid Date:
                      <span class="badge bg-label-info">01-01-2025</span>
                    </p>
                    <p class="m-0 p-0">
                      Expiry Date:
                      <span class="badge bg-label-danger">01-01-2025</span>
                    </p>
                  </td>
                  <td>
                    <span class="badge bg-label-success">Paid</span>
                  </td>

                  <td>
                    <button class="btn btn-info" type="button">
                      Send Invoice
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

@endsection